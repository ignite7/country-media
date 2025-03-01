<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CountryEnum;
use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
final class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var CountryEnum $country */
        $country = fake()->randomElement(CountryEnum::cases());

        return [
            'country_code' => $country->name,
            'name' => $country->value,
            'description' => fake()->paragraph(),
        ];
    }
}
