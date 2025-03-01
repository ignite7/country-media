<?php

declare(strict_types=1);

use App\Console\Commands\FetchWikipediaCountryArticlesCommand;
use App\Console\Commands\FetchYoutubeVideosCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(FetchWikipediaCountryArticlesCommand::class)->everySixHours();
Schedule::command(FetchYoutubeVideosCommand::class)->hourly();
