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
        'SynergiTech\Twig\Extension\Loader\Facades',
        'SynergiTech\Twig\Extension\Loader\Filters',
        'SynergiTech\Twig\Extension\Loader\Functions',

        'SynergiTech\Twig\Extension\Laravel\Auth',
        'SynergiTech\Twig\Extension\Laravel\Config',
        'SynergiTech\Twig\Extension\Laravel\Dump',
        'SynergiTech\Twig\Extension\Laravel\Input',
        'SynergiTech\Twig\Extension\Laravel\Session',
        'SynergiTech\Twig\Extension\Laravel\Str',
        'SynergiTech\Twig\Extension\Laravel\Translator',
        'SynergiTech\Twig\Extension\Laravel\Url',
        'SynergiTech\Twig\Extension\Laravel\Gate',

        // 'SynergiTech\Twig\Extension\Vendor\Spatie\Permission',
    ],

    'facades' => [],

    'functions' => [
        'mix'
    ],

    'filters' => []
];
