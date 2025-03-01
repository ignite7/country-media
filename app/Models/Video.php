<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\VideoFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $youtube_video_id
 * @property ?string $description
 * @property ?string $thumbnail_default
 * @property ?string $thumbnail_high
 * @property Country $country
 * @property Carbon $published_at
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
final class Video extends Model
{
    /** @use HasFactory<VideoFactory> */
    use HasFactory, HasUlids;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'country_id',
        'youtube_video_id',
        'description',
        'thumbnail_default',
        'thumbnail_high',
        'published_at',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'id',
        'updated_at',
    ];

    /**
     * @return BelongsTo<Country, $this>
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
