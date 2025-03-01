<?php

declare(strict_types=1);

use App\Actions\FetchWikipediaCountryArticle;
use App\Enums\CountryEnum;
use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

it('updates the country description when Wikipedia returns valid data', function (): void {
    Country::factory()->create(['country_code' => 'NL', 'description' => null]);

    Http::fake([
        'https://en.wikipedia.org/w/api.php*' => Http::response([
            'query' => ['pages' => [['extract' => 'The Netherlands is a country in Europe.']]],
        ]),
    ]);

    (new FetchWikipediaCountryArticle())->handle(CountryEnum::NL);

    $this->assertDatabaseHas('countries', [
        'country_code' => 'NL',
        'description' => 'The Netherlands is a country in Europe.',
    ]);
});

it('does not update the country when Wikipedia request fails', function (): void {
    Country::factory()->create(['country_code' => 'NL', 'description' => null]);

    Http::fake([
        'https://en.wikipedia.org/w/api.php*' => Http::response([], 500),
    ]);

    Log::shouldReceive('error')->once();

    (new FetchWikipediaCountryArticle())->handle(CountryEnum::NL);

    $this->assertDatabaseHas('countries', [
        'country_code' => 'NL',
        'description' => null,
    ]);
});

it('logs an error and does not update the country when extract is missing', function (): void {
    Country::factory()->create(['country_code' => 'NL', 'description' => null]);

    Http::fake([
        'https://en.wikipedia.org/w/api.php*' => Http::response([
            'query' => ['pages' => [['missing' => true]]],
        ]),
    ]);

    Log::shouldReceive('error')->once();

    (new FetchWikipediaCountryArticle())->handle(CountryEnum::NL);

    $this->assertDatabaseHas('countries', [
        'country_code' => 'NL',
        'description' => null,
    ]);
});
