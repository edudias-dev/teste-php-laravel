<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadFileRequest;
use App\Services\FileProcessorService;
use Illuminate\View\View;

class FileController extends Controller
{
    public FileProcessorService $service;

    public function __construct(FileProcessorService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        return view('upload-file');
    }

    public function uploadFile(UploadFileRequest $request): void
    {
        $this->service->processFile($request->file('file'));
    }
}
