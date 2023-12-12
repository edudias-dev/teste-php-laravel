<?php

namespace Database\Factories;

use App\Enums\CategoriesEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => 1,
            'name' => CategoriesEnum::REMESSA,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
