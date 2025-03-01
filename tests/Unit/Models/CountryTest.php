<?php

declare(strict_types=1);

use App\Models\Country;
use App\Models\Video;

it('toArray', function (): void {
    $country = Country::factory()->create();

    expect($country->toArray())->toBe([
        'country_code' => $country->country_code,
        'name' => $country->name,
        'description' => $country->description,
        'created_at' => $country->created_at?->toISOString(),
    ]);
});

it('can get the videos of the country', function (): void {
    $country = Country::factory()->create();
    $videos = Video::factory(5)->for($country)->create();

    expect($country->videos)->toHaveCount(5)
        ->and($videos)->toHaveCount(5)
        ->and($country->videos->pluck('id')->toArray())
        ->toBe($videos->pluck('id')->toArray());
});
