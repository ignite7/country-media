<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\FetchYoutubeVideos;
use App\Enums\CountryEnum;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;

final class FetchYoutubeVideosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-youtube-videos-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch YouTube videos';

    /**
     * @return void
     *
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $this->withProgressBar(CountryEnum::cases(), static function (CountryEnum $country): void {
            (new FetchYoutubeVideos())->handle($country);
        });
    }
}
