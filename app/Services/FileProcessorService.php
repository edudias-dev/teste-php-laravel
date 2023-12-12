<?php
namespace App\Services;

use App\DTOs\DocumentDTO;
use App\Enums\CategoriesEnum;
use App\Enums\MonthsEnum;
use App\Enums\PeriodsEnum;
use App\Enums\ProcessorStatusEnum;
use App\Exceptions\InvalidDocumentTitle;
use App\Helper\Util;
use App\Interfaces\DocumentRepositoryInterface;
use App\Jobs\FileUploadProcessorJob;
use App\Models\Document;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class FileProcessorService {

    private DocumentRepositoryInterface $repository;

    public function __construct(DocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function addToProcess($file): void
    {
        $this->storeFile($file);

        $data = Util::getJsonFileContent($file);

        foreach ($data['documentos'] as $document) {
            $dto = new DocumentDTO(
                arr::get($document, 'categoria'),
                arr::get($document, 'titulo'),
                arr::get($document, 'conteúdo'),
            );

            $addDocument = $this->repository->add($dto);
            FileUploadProcessorJob::dispatch($addDocument->uuid)->onQueue('post-processor-file');
        }
    }

    /**
     * @throws InvalidDocumentTitle
     */
    public function processFile(string $documentUuid): void
    {
        $document = $this->repository->getByUuid($documentUuid);

        $this->validateFileTitle($document);

        $this->repository->update($document->id, [
            'status' => ProcessorStatusEnum::PROCESSED
        ]);
    }

    /**
     * @param $document
     * @return void
     * @throws InvalidDocumentTitle
     * @expectedException InvalidDocumentTitle
     */
    private function validateFileTitle($document): void
    {
        if (
            $document->category->name == CategoriesEnum::REMESSA &&
            ! str_contains($document->title, PeriodsEnum::SEMESTER)
        ) {
            throw new InvalidDocumentTitle(
                sprintf(
                    'O título deve conter a palavra %s para os arquivos da categoria %s',
                    PeriodsEnum::SEMESTER,
                    CategoriesEnum::REMESSA
                )
            );
        }

        if (
            $document->category->name == CategoriesEnum::REMESSA_PARCIAL &&
            ! $this->hasMonthNameOnTitle($document->title)
        ) {
            throw new InvalidDocumentTitle(
                sprintf(
                    'O título deve conter um mês do ano para os arquivos da categoria %s',
                    CategoriesEnum::REMESSA_PARCIAL
                )
            );
        }
    }

    private function hasMonthNameOnTitle(string $title): bool
    {
        foreach (MonthsEnum::MONTHS_OF_YEAR as $month) {
            if (stripos($title, $month) !== false) {
                return true;
            }
        }

        return false;
    }

    private function storeFile($file): void
    {
        $fileName = $file->getClientOriginalName();
        $processedFileName = time().'_processed_'.$fileName;
        Storage::disk('public')->put($processedFileName, file_get_contents($file));
    }
}
