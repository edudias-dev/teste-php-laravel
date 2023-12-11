<?php

namespace App\Repositories;

use App\DTOs\DocumentDTO;
use App\Interfaces\DocumentRepositoryInterface;
use App\Models\Document;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;

class DocumentRepository implements DocumentRepositoryInterface
{
    private Builder $model;

    public function __construct()
    {
        $this->model = Document::query();
    }

    public function add(DocumentDTO $document): Model
    {
        return $this->model->create($document->toArray());
    }

    public function getByUuid(string $uuid): Model
    {
        return $this->model->where('uuid', $uuid)->first();
    }
}
