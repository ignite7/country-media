<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(type="object")
 *
 * @property string $id
 * @property string $youtube_video_id
 * @property ?string $description
 * @property ?string $thumbnail_default
 * @property ?string $thumbnail_high
 * @property Carbon $published_at
 * @property ?Carbon $created_at
 */
final class VideoResource extends JsonResource
{
    /**
     * @OA\Property(property="id", type="string")
     * @OA\Property(property="youtube_video_id", type="string")
     * @OA\Property(property="description", type="string", nullable=true)
     * @OA\Property(property="thumbnail_default", type="string", nullable=true)
     * @OA\Property(property="thumbnail_high", type="string", nullable=true)
     * @OA\Property(
     *       property="published_at",
     *       type="string",
     *       format="date-time"
     *   )
     * @OA\Property(
     *      property="created_at",
     *      type="string",
     *      format="date-time",
     *      nullable=true
     *  )
     *
     * @return array<string, mixed>
     */
    // @codeCoverageIgnoreStart
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'youtube_video_id' => $this->youtube_video_id,
            'description' => $this->description,
            'thumbnail_default' => $this->thumbnail_default,
            'thumbnail_high' => $this->thumbnail_high,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
        ];
    }
}
// @codeCoverageIgnoreEnd
