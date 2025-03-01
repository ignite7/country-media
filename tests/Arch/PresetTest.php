<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Controller;

arch()->preset()->php();
arch()->preset()->security();
arch()->preset()->laravel();

arch('strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('avoid open for extension')
    ->expect('App')
    ->classes()
    ->toBeFinal()
    ->ignoring([
        Controller::class,
    ]);

arch('ensure no extends')
    ->expect('App')
    ->classes()
    ->not->toBeAbstract()
    ->ignoring([
        Controller::class,
    ]);

arch('avoid mutation')
    ->expect('App')
    ->classes()
    ->toBeReadonly()
    ->ignoring([
        'App\Console\Commands',
        'App\Http\Controllers',
        'App\Http\Requests',
        'App\Http\Resources',
        'App\Models',
        'App\Providers',
        'App\Actions',
    ]);

arch('avoid inheritance')
    ->expect('App')
    ->classes()
    ->toExtendNothing()
    ->ignoring([
        'App\Console\Commands',
        'App\Http\Requests',
        'App\Http\Resources',
        'App\Models',
        'App\Providers',
        'App\Actions',
    ]);

arch('annotations')
    ->expect('App')
    ->toHavePropertiesDocumented()
    ->toHaveMethodsDocumented();
