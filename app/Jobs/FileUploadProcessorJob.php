<?php

namespace App\Jobs;

use App\DTOs\DocumentDTO;
use App\Interfaces\DocumentRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FileUploadProcessorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $documentUuid;
    private DocumentRepositoryInterface $documentRepository;

    public function __construct(string $documentUuid, DocumentRepositoryInterface $documentRepository)
    {
        $this->documentUuid = $documentUuid;
        $this->documentRepository = $documentRepository;
    }

    public function handle(): void
    {
        $document = $this->documentRepository->getByUuid($this->documentUuid);
        $document->update(['status' => 'processed']);
    }
}
