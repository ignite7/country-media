<?php

declare(strict_types=1);

use App\Enums\CountryEnum;

it('can get names', function (): void {
    $names = CountryEnum::names();

    expect($names)->toBe([
        'GB',
        'NL',
        'DE',
        'FR',
        'ES',
        'IT',
        'GR',
    ]);
});

it('can get values', function (): void {
    $values = CountryEnum::values();

    expect($values)->toBe([
        'United Kingdom',
        'Netherlands',
        'Germany',
        'France',
        'Spain',
        'Italy',
        'Greece',
    ]);
});

it('can check if a country code is valid', function (): void {
    expect(CountryEnum::isValidCountryCode('GB'))->toBeTrue()
        ->and(CountryEnum::isValidCountryCode('NL'))->toBeTrue()
        ->and(CountryEnum::isValidCountryCode('DE'))->toBeTrue()
        ->and(CountryEnum::isValidCountryCode('FR'))->toBeTrue()
        ->and(CountryEnum::isValidCountryCode('ES'))->toBeTrue()
        ->and(CountryEnum::isValidCountryCode('IT'))->toBeTrue()
        ->and(CountryEnum::isValidCountryCode('GR'))->toBeTrue()
        ->and(CountryEnum::isValidCountryCode('US'))->toBeFalse()
        ->and(CountryEnum::isValidCountryCode('CA'))->toBeFalse()
        ->and(CountryEnum::isValidCountryCode('AU'))->toBeFalse()
        ->and(CountryEnum::isValidCountryCode('NZ'))->toBeFalse()
        ->and(CountryEnum::isValidCountryCode('ZA'))->toBeFalse()
        ->and(CountryEnum::isValidCountryCode('BR'))->toBeFalse()
        ->and(CountryEnum::isValidCountryCode('AR'))->toBeFalse();
});
