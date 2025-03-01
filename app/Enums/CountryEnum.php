<?php

declare(strict_types=1);

namespace App\Enums;

enum CountryEnum: string
{
    case GB = 'United Kingdom';
    case NL = 'Netherlands';
    case DE = 'Germany';
    case FR = 'France';
    case ES = 'Spain';
    case IT = 'Italy';
    case GR = 'Greece';

    /**
     * @return array<string>
     */
    public static function names(): array
    {
        $names = [];

        foreach (self::cases() as $case) {
            $names[] = $case->name;
        }

        return $names;
    }

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        $values = [];

        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }

        return $values;
    }

    /**
     * @param  string  $countryCode
     * @return bool
     */
    public static function isValidCountryCode(string $countryCode): bool
    {
        return in_array(mb_strtoupper($countryCode), self::names(), true);
    }
}
