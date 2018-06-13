<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Translation\Translator as LaravelTranslator;

use \Twig_Extension;
use \Twig_SimpleFilter;
use \Twig_SimpleFunction;

class Translator extends Twig_Extension
{
    protected $translator;

    public function __construct(LaravelTranslator $translator)
    {
        $this->translator = $translator;
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Translator';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('trans', [$this->translator, 'trans']),
            new Twig_SimpleFunction('trans_choice', [$this->translator, 'transChoice']),
        ];
    }

    public function getFilters()
    {
        return [
            new Twig_SimpleFilter(
                'trans',
                [$this->translator, 'trans'],
                [
                    'pre_escape' => 'html',
                    'is_safe' => ['html'],
                ]
            ),
            new Twig_SimpleFilter(
                'trans_choice',
                [$this->translator, 'transChoice'],
                [
                    'pre_escape' => 'html',
                    'is_safe' => ['html'],
                ]
            ),
        ];
    }
}
