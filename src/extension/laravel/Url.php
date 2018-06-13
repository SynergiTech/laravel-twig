<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Str as IlluminateStr;
use Illuminate\Routing\Router;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Url extends Twig_Extension
{
    protected $url;

    protected $router;

    public function __construct(UrlGenerator $url, Router $router)
    {
        $this->url = $url;
        $this->router = $router;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Url';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('asset', [$this->url, 'asset'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('mix', [$this->url, 'mix'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('action', [$this->url, 'action'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('url', [$this, 'url'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('route', [$this->url, 'route'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('route_has', [$this->router, 'has'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('secure_url', [$this->url, 'secure'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('secure_asset', [$this->url, 'secureAsset'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction(
                'url_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);
                    $name = IlluminateStr::camel($name);

                    return call_user_func_array([$this->url, $name], $arguments);
                }
            ),
        ];
    }

    public function url($path = null, $parameters = [], $secure = null)
    {
        if (!$path) {
            return $this->url;
        }

        return $this->url->to($path, $parameters, $secure);
    }
}
