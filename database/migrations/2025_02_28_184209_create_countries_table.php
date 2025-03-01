<?php

declare(strict_types=1);

use App\Console\Commands\FetchWikipediaCountryArticlesCommand;
use App\Enums\CountryEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', static function (Blueprint $table): void {
            $table->ulid('id')->primary();
            $table->enum('country_code', CountryEnum::names());
            $table->enum('name', CountryEnum::values());
            $table->longText('description')->nullable();
            $table->timestamps();
        });

        foreach (CountryEnum::cases() as $countryCode) {
            $now = now();
            DB::table('countries')->insert([
                'id' => mb_strtolower(Str::ulid($now)->toString()),
                'country_code' => $countryCode->name,
                'name' => $countryCode->value,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        Artisan::call(FetchWikipediaCountryArticlesCommand::class);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
