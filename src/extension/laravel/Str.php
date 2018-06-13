<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Support\Str as IlluminateStr;

use \Twig_Extension;
use \Twig_SimpleFunction;
use \Twig_SimpleFilter;

class Str extends Twig_Extension
{
    protected $callback = 'Illuminate\Support\Str';

    public function getCallback()
    {
        return $this->callback;
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_String';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction(
                'str_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);
                    $name = IlluminateStr::camel($name);

                    return call_user_func_array([$this->callback, $name], $arguments);
                }
            ),
        ];
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('camel_case', [$this->callback, 'camel']),
            new Twig_SimpleFilter('snake_case', [$this->callback, 'snake']),
            new Twig_SimpleFilter('studly_case', [$this->callback, 'studly']),
            new Twig_SimpleFilter(
                'str_*',
                function ($name) {
                    $arguments = array_slice(func_get_args(), 1);
                    $name = IlluminateStr::camel($name);

                    return call_user_func_array([$this->callback, $name], $arguments);
                }
            ),
        ];
    }
}
