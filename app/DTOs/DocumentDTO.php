<?php

namespace App\DTOs;

class DocumentDTO extends DTO
{
    public string $category;
    public string $title;
    public string $contents;

    public function __construct(string $category, string $title, string $content)
    {
        $this->category = $category;
        $this->title = $title;
        $this->contents = $content;
    }
}
