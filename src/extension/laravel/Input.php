<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Http\Request;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Input extends Twig_Extension
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Input';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('input_get', [$this->request, 'input']),
            new Twig_SimpleFunction('input_old', [$this->request, 'old']),
            new Twig_SimpleFunction('input_has', [$this->request, 'has']),
            new Twig_SimpleFunction('old', [$this->request, 'old']),
        ];
    }
}
