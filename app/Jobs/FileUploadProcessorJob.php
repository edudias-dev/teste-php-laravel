<?php

namespace App\Jobs;

use App\DTOs\DocumentDTO;
use App\Interfaces\DocumentRepositoryInterface;
use App\Services\FileProcessorService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FileUploadProcessorJob implements ShouldQueue
{
    protected int $tries = 1;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $documentUuid;
    private DocumentRepositoryInterface $documentRepository;

    public function __construct(string $documentUuid)
    {
        $this->documentUuid = $documentUuid;
    }

    /**
     * @throws Exception
     */
    public function handle(FileProcessorService $service): void
    {
        try {
            $service->processFile($this->documentUuid);

            Log::info(sprintf("file processor job: %s", $this->documentUuid), [
                'status' => 'processed',
                'message' => 'file processed successfully'
            ]);
        } catch (Exception $exception) {
            Log::error(
                sprintf("error to process file job: %s", $this->documentUuid), [
                    'status' => 'pending',
                    'message' => $exception->getMessage()
                ]);
        }
    }
}
