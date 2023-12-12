<?php

namespace Database\Factories;

use App\Enums\ProcessorStatusEnum;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => function () {
                return Category::factory()->make()->id;
            },
            'title' => $this->faker->name(),
            'contents' => 'Lorem ipsum dolor',
            'status' => ProcessorStatusEnum::PENDING,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
