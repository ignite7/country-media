<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Country;
use App\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Video>
 */
final class VideoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'country_id' => Country::factory(),
            'youtube_video_id' => fake()->uuid(),
            'description' => fake()->paragraph(),
            'thumbnail_default' => fake()->imageUrl(),
            'thumbnail_high' => fake()->imageUrl(),
            'published_at' => fake()->dateTime(),
        ];
    }
}
