<?php

namespace SynergiTech\Twig\Extension\Vendor\Spatie;

use \Twig_Extension;
use \Twig_Function;

class Permission extends Twig_Extension
{
    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Spatie_Permission';
    }

    public function getFunctions()
    {
        return [
            new Twig_Function('role', function ($roleName = "") {
                if (auth()->check()) {
                    return auth()->user()->hasRole($roleName);
                }

                return false;
            }),
            new Twig_Function('hasrole', function ($roleName = "") {
                if (auth()->check()) {
                    return auth()->user()->hasRole($roleName);
                }

                return false;
            }),
            new Twig_Function('hasanyrole', function ($roleNames = []) {
                if (auth()->check()) {
                    return auth()->user()->hasAnyRole($roleNames);
                }

                return false;
            }),
            new Twig_Function('hasallroles', function ($roleNames = []) {
                if (auth()->check()) {
                    return auth()->user()->hasAllRoles($roleNames);
                }

                return false;
            }),
        ];
    }
}
