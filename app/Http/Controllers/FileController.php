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

    public function uploadFile(UploadFileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->fileService->process($request->file('file'));

        return back()->with(
            'success',
            'Arquivo carregado com sucesso! Acesse /post-upload para iniciar o processamento.'
        );
    }
}
