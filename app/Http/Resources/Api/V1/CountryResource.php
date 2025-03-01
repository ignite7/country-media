<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(type="object")
 *
 * @property string $id
 * @property string $country_code
 * @property ?string $description
 * @property ?Carbon $created_at
 * @property Collection<int, Video> $videos
 */
final class CountryResource extends JsonResource
{
    /**
     * @OA\Property(property="id", type="string")
     * @OA\Property(property="country_code", type="string")
     * @OA\Property(
     *     property="description",
     *     type="string",
     *     nullable=true
     * )
     * @OA\Property(
     *       property="created_at",
     *       type="string",
     *       format="date-time",
     *       nullable=true
     * )
     * @OA\Property(property="videos", type="array", @OA\Items(ref="#/components/schemas/VideoResource"))
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'country_code' => $this->country_code,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'videos' => VideoResource::collection($this->videos),
        ];
    }
}
