<?php

declare(strict_types=1);

namespace App\Actions;

use App\Enums\CountryEnum;
use App\Models\Country;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

final class FetchWikipediaCountryArticle
{
    private const API_URL = 'https://en.wikipedia.org/w/api.php';

    /**
     * @param  CountryEnum  $country
     * @return void
     *
     * @throws ConnectionException
     */
    public function handle(CountryEnum $country): void
    {
        $response = Http::get(self::API_URL, [
            'action' => 'query',
            'prop' => 'extracts',
            'exintro' => true,
            'explaintext' => true,
            'titles' => $country->value,
            'format' => 'json',
            'formatversion' => 2,
        ]);

        $extract = $response->json('query.pages.0.extract');
        $validator = Validator::make(
            ['extract' => $extract],
            ['extract' => ['required', 'string']]
        );

        if ($response->failed() || $validator->fails()) {
            Log::error("Failed to fetch Wikipedia article for $country->name country.", [
                'response' => $response->json(),
                'errors' => $validator->errors()->all(),
            ]);

            return;
        }

        Country::query()
            ->where('country_code', $country->name)
            ->update(['description' => $validator->safe()->string('extract')]);
    }
}
