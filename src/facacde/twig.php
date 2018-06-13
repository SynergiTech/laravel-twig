<?php

namespace SynergiTech\Twig\Facade;

use Illuminate\Support\Facades\Facade;

class Twig implements Facade
{
    protected static function getFacadeAccessor()
    {
        return 'twig';
    }
}
