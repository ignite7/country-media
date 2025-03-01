<?php

declare(strict_types=1);

use App\Models\Country;
use App\Models\Video;

it('toArray', function (): void {
    $video = Video::factory()->create();

    expect($video->toArray())->toBe([
        'country_id' => $video->country_id,
        'youtube_video_id' => $video->youtube_video_id,
        'description' => $video->description,
        'thumbnail_default' => $video->thumbnail_default,
        'thumbnail_high' => $video->thumbnail_high,
        'published_at' => $video->published_at->toISOString(),
        'created_at' => $video->created_at?->toISOString(),
    ]);
});

it('can get the country of the video', function (): void {
    $country = Country::factory()->create();
    $video = Video::factory()->for($country)->create();

    expect($video->country->id)->toBe($country->id);
});
