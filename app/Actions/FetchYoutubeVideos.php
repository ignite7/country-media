<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\CountryEnum;
use App\Models\Country;
use App\Models\Video;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// @codeCoverageIgnoreStart
final class FetchYoutubeVideos
{
    private const API_URL = 'https://www.googleapis.com/youtube/v3/videos';

    /**
     * @param  CountryEnum  $countryEnum
     * @return void
     *
     * @throws ConnectionException
     */
    public function handle(CountryEnum $countryEnum): void
    {
        $apiKey = config('services.youtube.api_key');
        $country = Country::query()->firstWhere('country_code', $countryEnum->name);

        if (empty($apiKey) || ! $country instanceof Country) {
            return;
        }

        $response = Http::get(self::API_URL, [
            'part' => 'snippet',
            'chart' => 'mostPopular',
            'regionCode' => $country->country_code,
            'maxResults' => 5,
            'key' => $apiKey,
        ]);

        $items = $response->json('items');
        $validator = Validator::make(
            ['items' => $items],
            [
                'items' => ['required', 'array'],
                'items.*.id' => ['required', 'string'],
                'items.*.snippet.publishedAt' => ['required', 'date'],
                'items.*.snippet.description' => ['nullable', 'string'],
                'items.*.snippet.thumbnails' => ['required', 'array'],
                'items.*.snippet.thumbnails.default.url' => ['nullable', 'url'],
                'items.*.snippet.thumbnails.high.url' => ['nullable', 'url'],
            ]
        );

        if ($response->failed() || $validator->fails()) {
            Log::error("Failed to fetch YouTube videos for $country->name country.", [
                'response' => $response->json(),
                'errors' => $validator->errors()->all(),
            ]);

            return;
        }

        foreach ($validator->safe()->array('items') as $item) {
            /**
             * @var array{id: string, snippet: array{description: ?string, thumbnails: array{default: array{url: ?string}, high: array{url: ?string}}, publishedAt: string}} $item
             */
            Video::query()->updateOrCreate(
                ['youtube_video_id' => $item['id']],
                [
                    'country_id' => $country->id,
                    'description' => $item['snippet']['description'] ?? null,
                    'thumbnail_default' => $item['snippet']['thumbnails']['default']['url'] ?? null,
                    'thumbnail_high' => $item['snippet']['thumbnails']['high']['url'] ?? null,
                    'published_at' => $item['snippet']['publishedAt'],
                ]
            );
        }
    }
}
// @codeCoverageIgnoreEnd
