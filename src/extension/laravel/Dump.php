<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;

use \Twig_SimpleFunction;
use \Twig_Template;
use \Twig_Environment;

class Dump extends \Twig_Extension
{
    public function __construct()
    {
        $this->cloner = new VarCloner();
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('dump', [$this, 'dump'], [
                'is_safe' => ['html'],
                'needs_context' => true,
                'needs_environment' => true
            ]),
        ];
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Dump';
    }

    public function dump(Twig_Environment $env, $context)
    {
        if (!$env->isDebug()) {
            return;
        }
        if (2 === func_num_args()) {
            $vars = array();
            foreach ($context as $key => $value) {
                if (!$value instanceof Twig_Template) {
                    $vars[$key] = $value;
                }
            }
            $vars = array($vars);
        } else {
            $vars = func_get_args();
            unset($vars[0], $vars[1]);
        }
        $dump = fopen('php://memory', 'r+b');
        $dumper = new HtmlDumper($dump);
        foreach ($vars as $value) {
            $dumper->dump($this->cloner->cloneVar($value));
        }
        rewind($dump);
        return stream_get_contents($dump);
    }
}
