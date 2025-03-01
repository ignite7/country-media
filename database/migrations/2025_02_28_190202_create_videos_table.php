<?php

declare(strict_types=1);

use App\Console\Commands\FetchYoutubeVideosCommand;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videos', static function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->foreignUlid('country_id')->constrained();
            $table->string('youtube_video_id')->unique()->index();
            $table->longText('description')->nullable();
            $table->string('thumbnail_default')->nullable();
            $table->string('thumbnail_high')->nullable();
            $table->timestamp('published_at');
            $table->timestamps();
        });

        Artisan::call(FetchYoutubeVideosCommand::class);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
