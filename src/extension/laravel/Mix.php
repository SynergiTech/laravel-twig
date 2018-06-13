<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Auth\AuthManager;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Mix extends Twig_Extension
{
    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Mix';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('mix', function () {
                return call_user_func_array('mix', func_get_args());
            })
        ];
    }
}
