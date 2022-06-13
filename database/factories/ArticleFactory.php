<?php

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $updatedAt = CarbonImmutable::now()
            ->subDays(mt_rand(0, 365))
            ->subSeconds(mt_rand(0, 24 * 60 * 60));
        $createdAt = $updatedAt
            ->subDays(mt_rand(0, 30))
            ->subSeconds(mt_rand(0, 24 * 60 * 60));
        
        return [
            'created_at' => $createdAt->toDateTimeString(),
            'updated_at' => $updatedAt->toDateTimeString(),
            'slug' => implode('-', $this->faker->unique()->words()),
            'title' => rtrim($this->faker->sentence(), '.'),
            'body' => implode("\n", array_map(
                fn($paragraph) => "<p>$paragraph</p>",
                $this->faker->paragraphs(mt_rand(5, 10))
            )),
            'cover_url' => 'https://loremflickr.com/1294/540?'
                .$this->faker->unique()->numberBetween(),
            'cover_thumbnail_url' => 'https://loremflickr.com/420/315?'
                .$this->faker->unique()->numberBetween(),
            'views' => $this->faker->numberBetween(0, 10000),
            'likes' => $this->faker->numberBetween(0, 100)
        ];
    }
}
