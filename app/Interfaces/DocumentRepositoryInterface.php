<?php

namespace App\Interfaces;

use App\DTOs\DocumentDTO;
use Illuminate\Database\Eloquent\Model;

interface DocumentRepositoryInterface extends BaseInterface
{
    public function add(DocumentDTO $document): Model;
}
