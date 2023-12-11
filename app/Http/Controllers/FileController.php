<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Services\FileProcessorService;
use Illuminate\View\View;

class FileController extends Controller
{
    public FileProcessorService $fileService;
    public function __construct(FileProcessorService $service)
    {
        $this->fileService = $service;
    }

    public function index(): View
    {
        return view('upload-file');
    }

    public function uploadFile(UploadFileRequest $request): void
    {
        $this->fileService->process($request->file('file'));
    }
}
