<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Enums\CountryEnum;
use App\Http\Resources\Api\V1\CountryResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

final class CountryController
{
    /**
     * @OA\Get(
     *     path="/countries",
     *     operationId="getCountriesList",
     *     tags={"Countries"},
     *     summary="Get list of countries",
     *     description="Returns list of countries",
     *
     *      @OA\Parameter(
     *          name="countryCode",
     *          in="query",
     *          description="Filter countries by country code (e.g., GB, NL, DE, FR, ES, IT, GR)",
     *          required=false,
     *
     *          @OA\Schema(type="string", example="NL")
     *      ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(ref="#/components/schemas/CountryResource")
     *      ),
     *
     *     @OA\Response(
     *          response=429,
     *          description="Too many requests"
     *      )
     *  )
     *
     * @param  Request  $request
     * @return AnonymousResourceCollection
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        $countryCode = $request->string('countryCode');

        return CountryResource::collection(
            Country::query()
                ->with('videos', static function (Relation $query): void {
                    $query->select(
                        'id',
                        'country_id',
                        'youtube_video_id',
                        'description',
                        'thumbnail_default',
                        'thumbnail_high',
                        'published_at',
                        'created_at'
                    )
                        ->orderByDesc('published_at')
                        ->limit(5);
                })
                ->when(
                    CountryEnum::isValidCountryCode($countryCode->value()),
                    static function (Builder $query) use ($countryCode): void {
                        $query->where('country_code', $countryCode->value());
                    }
                )
                ->simplePaginate(5)
        );
    }
}
