<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;

use \Twig_Extension;
use \Twig_SimpleFunction;

class Gate extends Twig_Extension
{
    protected $gate;

    public function __construct(GateContract $gate)
    {
        $this->gate = $gate;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Gate';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('can', [$this->gate, 'check']),
        ];
    }
}
