<?php

namespace SynergiTech\Twig\Extension\Vendor\Spatie;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Permission extends Twig_Extension
{
    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Spatie_Permission';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('role', function () {
                if (auth()->check()) {
                    return [auth()->user(), 'hasRole'];
                }

                return false;
            }),
            new Twig_SimpleFunction('hasrole', function () {
                if (auth()->check()) {
                    return [auth()->user(), 'hasRole'];
                }

                return false;
            }),
            new Twig_SimpleFunction('hasanyrole', function () {
                if (auth()->check()) {
                    return [auth()->user(), 'hasAnyRole'];
                }

                return false;
            }),
            new Twig_SimpleFunction('hasallroles', function () {
                if (auth()->check()) {
                    return [auth()->user(), 'hasAllRoles'];
                }

                return false;
            }),
        ];
    }
}
