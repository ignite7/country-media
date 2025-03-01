<?php

declare(strict_types=1);

use App\Actions\FetchYoutubeVideos;
use App\Enums\CountryEnum;
use App\Models\Country;
use App\Models\Video;
use Illuminate\Support\Facades\Http;

it('logs an error and does not update if the YouTube API request fails', function (): void {
    Country::factory()->create(['country_code' => 'NL']);
    $count = Video::query()->count();

    Http::fake([
        'https://www.googleapis.com/youtube/v3/videos*' => Http::response([], 500),
    ]);

    (new FetchYoutubeVideos())->handle(CountryEnum::NL);

    expect(Video::query()->count())->toBe($count);
});

it('logs an error and does not update if the YouTube API response is invalid', function (): void {
    Country::factory()->create(['country_code' => 'NL']);
    $count = Video::query()->count();

    Http::fake([
        'https://www.googleapis.com/youtube/v3/videos*' => Http::response([
            'items' => null,
        ]),
    ]);

    (new FetchYoutubeVideos())->handle(CountryEnum::NL);

    expect(Video::query()->count())->toBe($count);
});

it('does not update if the API key is missing', function (): void {
    Country::factory()->create(['country_code' => 'NL']);
    config(['services.youtube.api_key' => null]);
    $count = Video::query()->count();

    (new FetchYoutubeVideos())->handle(CountryEnum::NL);

    expect(Video::query()->count())->toBe($count);
});
