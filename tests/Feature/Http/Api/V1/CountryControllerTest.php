<?php

declare(strict_types=1);

use App\Enums\CountryEnum;
use App\Models\Country;
use App\Models\Video;
use Illuminate\Testing\Fluent\AssertableJson;

it('can get countries with associated videos', function (): void {
    $country = Country::factory()->create();
    Video::factory(5)->for($country)->create();

    $this->getJson(route('api.v1.countries.index'))
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'country_code',
                    'description',
                    'created_at',
                    'videos' => [
                        '*' => [
                            'id',
                            'youtube_video_id',
                            'description',
                            'thumbnail_default',
                            'thumbnail_high',
                            'published_at',
                            'created_at',
                        ],
                    ],
                ],
            ],
        ]);
});

it('can filter countries by countryCode', function (): void {
    Country::factory()->create(['country_code' => CountryEnum::FR->name]);

    $this->getJson(route('api.v1.countries.index', ['countryCode' => CountryEnum::FR->name]))
        ->assertOk()
        ->assertJsonPath('data.0.country_code', CountryEnum::FR->name);
});

it('returns paginated results', function (): void {
    Country::factory(10)->create();

    $this->getJson(route('api.v1.countries.index'))
        ->assertOk()
        ->assertJson(fn (AssertableJson $json): AssertableJson => $json->has('data', 5)
            ->has('links')
            ->has('meta')
        );
});
