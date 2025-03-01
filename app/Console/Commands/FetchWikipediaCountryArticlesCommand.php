<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Actions\FetchWikipediaCountryArticle;
use App\Enums\CountryEnum;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;

final class FetchWikipediaCountryArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-wikipedia-country-articles-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Wikipedia country articles';

    /**
     * @return void
     *
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $this->withProgressBar(CountryEnum::cases(), static function (CountryEnum $country): void {
            (new FetchWikipediaCountryArticle)->handle($country);
        });
    }
}
