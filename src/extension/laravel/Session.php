<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Session\Store;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Session extends Twig_Extension
{
    protected $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Session';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('session', [$this->session, 'get']),
            new Twig_SimpleFunction('csrf_token', [$this->session, 'token'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('csrf_field', 'csrf_field', ['is_safe' => ['html']]),
            new Twig_SimpleFunction('method_field', 'method_field', ['is_safe' => ['html']]),
            new Twig_SimpleFunction('session_get', [$this->session, 'get']),
            new Twig_SimpleFunction('session_pull', [$this->session, 'pull']),
            new Twig_SimpleFunction('session_has', [$this->session, 'has']),
        ];
    }
}
