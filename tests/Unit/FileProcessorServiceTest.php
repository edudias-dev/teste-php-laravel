<?php

namespace Tests\Unit;

use App\Enums\CategoriesEnum;
use App\Enums\ProcessorStatusEnum;
use App\Exceptions\InvalidDocumentTitle;
use App\Interfaces\DocumentRepositoryInterface;
use App\Models\Category;
use App\Models\Document;
use App\Services\FileProcessorService;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class FileProcessorServiceTest extends TestCase
{

    /**
     * @throws Exception
     * @throws InvalidDocumentTitle
     */
    public function testValidRemessaTitle(): void
    {
        $document = Document::factory()->make([
            'title' => 'title semestre',
            'contents' => 'content',
            'status' => ProcessorStatusEnum::PENDING
        ]);

        $repository = $this->createMock(DocumentRepositoryInterface::class);
        $fileProcessorService = new FileProcessorService($repository);

        $this->expectNotToPerformAssertions();

        $fileProcessorService->validateFileTitle($document);
    }

    /**
     * @throws Exception
     */
    public function testInvalidRemessaTitleException(): void
    {
        $document = Document::factory()->make([
            'title' => 'title',
            'contents' => 'content',
            'status' => ProcessorStatusEnum::PENDING
        ]);

        $repository = $this->createMock(DocumentRepositoryInterface::class);
        $fileProcessorService = new FileProcessorService($repository);

        $this->expectException(InvalidDocumentTitle::class);

        $fileProcessorService->validateFileTitle($document);
    }

    /**
     * @throws Exception
     * @throws InvalidDocumentTitle
     */
    public function testValidRemessaParcialTitle(): void
    {
        $document = Document::factory()->make([
            'title' => 'title Janeiro',
            'contents' => 'content',
            'status' => ProcessorStatusEnum::PENDING,
            'category_id' => function () {
                return Category::factory()->make([
                    'id' => 3,
                    'name' => CategoriesEnum::REMESSA_PARCIAL
                ])->id;
            }
        ]);

        $repository = $this->createMock(DocumentRepositoryInterface::class);
        $fileProcessorService = new FileProcessorService($repository);

        $this->expectNotToPerformAssertions();

        $fileProcessorService->validateFileTitle($document);
    }

    public function testInvalidRemessaParcialTitle(): void
    {
        $document = Document::factory()->make([
            'title' => 'some title without month name',
            'contents' => 'content',
            'status' => ProcessorStatusEnum::PENDING,
            'category_id' => function () {
                return Category::factory()->make([
                    'id' => 3,
                    'name' => CategoriesEnum::REMESSA_PARCIAL
                ])->id;
            }
        ]);

        $repository = $this->createMock(DocumentRepositoryInterface::class);
        $fileProcessorService = new FileProcessorService($repository);

        $this->expectException(InvalidDocumentTitle::class);

        $fileProcessorService->validateFileTitle($document);
    }
}
