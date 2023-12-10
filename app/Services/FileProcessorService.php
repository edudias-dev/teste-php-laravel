<?php
namespace App\Services;

use App\DTOs\DocumentDTO;
use App\Helper\Util;
use App\Interfaces\DocumentRepositoryInterface;
use App\Jobs\FileUploadProcessorJob;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class FileProcessorService {

    private DocumentRepositoryInterface $repository;

    public function __construct(DocumentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function process($file): void
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

    private function storeFile($file): void
    {
        $fileName = $file->getClientOriginalName();
        $processedFileName = time().'_processed_'.$fileName;
        Storage::disk('public')->put($processedFileName, file_get_contents($file));
    }
}
