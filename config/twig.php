<?php

return [
    'extension' => 'twig',

    'environment' => [
        'debug' => env('APP_DEBUG', false),
        'charset' => 'utf-8',
        'cache' => null,
        'auto_reload' => true,
        'strict_variables' => false,
        'autoescape' => 'html',
        'optimizations' => -1,
    ],

    'extensions' => [
        // 'SynergiTech\Twig\Extension\Vendor\Spatie\Permission',
        // 'SynergiTech\Twig\Extension\Vendor\Sentry\Sentry',

        // 'SynergiTech\Twig\Extension\Laravel\Facade',

        'SynergiTech\Twig\Extension\Laravel\Auth',
        'SynergiTech\Twig\Extension\Laravel\Config',
        'SynergiTech\Twig\Extension\Laravel\Dump',
        'SynergiTech\Twig\Extension\Laravel\Input',
        'SynergiTech\Twig\Extension\Laravel\Session',
        'SynergiTech\Twig\Extension\Laravel\Str',
        'SynergiTech\Twig\Extension\Laravel\Translator',
        'SynergiTech\Twig\Extension\Laravel\Url',
        'SynergiTech\Twig\Extension\Laravel\Gate',
        'SynergiTech\Twig\Extension\Laravel\Mix',
    ],

    'filters' => []
];
