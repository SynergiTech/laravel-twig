<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Auth\AuthManager;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Auth extends Twig_Extension
{
    protected $auth;

    public function __construct(AuthManager $auth)
    {
        $this->auth = $auth;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Auth';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('auth_check', [$this->auth, 'check']),
            new Twig_SimpleFunction('auth_guest', [$this->auth, 'guest']),
            new Twig_SimpleFunction('auth_user', [$this->auth, 'user']),
            new Twig_SimpleFunction('auth_guard', [$this->auth, 'guard']),
        ];
    }
}
