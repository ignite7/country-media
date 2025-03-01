<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\CountryController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], static function (): void {
    Route::get('countries', CountryController::class)
        ->middleware('throttle')
        ->name('countries.index');
});
