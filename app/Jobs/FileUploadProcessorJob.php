<?php

namespace App\Jobs;

use App\DTOs\DocumentDTO;
use App\Interfaces\DocumentRepositoryInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FileUploadProcessorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $documentUuid;
    private DocumentRepositoryInterface $documentRepository;
    private const FILE_NOT_FOUND_ERROR_MESSAGE = 'Documento não encontrado!';

    public function __construct(string $documentUuid)
    {
        $this->documentUuid = $documentUuid;
    }

    /**
     * @throws Exception
     */
    public function handle(DocumentRepositoryInterface $repository): void
    {
        $document = $repository->getByUuid($this->documentUuid);

        if (! $document) {
            $message = self::FILE_NOT_FOUND_ERROR_MESSAGE;
            Log::error($message);
            throw new Exception($message);
        }

        $document->update(['status' => 'processed']);
    }
}
