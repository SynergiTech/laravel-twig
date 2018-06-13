<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Config\Repository as ConfigRepository;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Config extends Twig_Extension
{
    protected $config;

    public function __construct(ConfigRepository $config)
    {
        $this->config = $config;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Config';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('config', [$this->config, 'get']),
            new Twig_SimpleFunction('config_get', [$this->config, 'get']),
            new Twig_SimpleFunction('config_has', [$this->config, 'has']),
        ];
    }
}
