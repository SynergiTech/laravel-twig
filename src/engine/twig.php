<?php

namespace SynergiTech\Twig\Engine;

use Illuminate\View\Engines\CompilerEngine;

use ErrorException;

use \Twig_Error;
use \Twig_Error_Loader;

use SynergiTech\Twig\Twig\Loader;

class Twig extends CompilerEngine
{
    protected $globalData = [];

    protected $loader = [];

    public function __construct(Compiler $compiler, Loader $loader, array $globalData = [])
    {
        parent::__construct($compiler);

        $this->loader = $loader;
        $this->globalData = $globalData;
    }

    public function getGlobalData()
    {
        return $this->globalData;
    }

    public function setGlobalData(array $globalData)
    {
        $this->globalData = $globalData;
    }

    public function get($path, array $data = [])
    {
        $data = array_merge($this->globalData, $data);

        try {
            $content = $this->compiler->load($path)->render($data);
        } catch (Twig_Error $exception) {
            $this->handleTwigError($exception);
        }

        return $content;
    }

    protected function handleTwigError(Twig_Error $exception)
    {
        $context = $exception->getSourceContext();

        if (null === $context) {
            throw $exception;
        }

        $templateFile = $context->getPath();
        $templateLine = $exception->getTemplateLine();

        if ($templateFile && file_exists($templateFile)) {
            $file = $templateFile;
        } elseif ($templateFile) {
            try {
                $file = $this->loader->findTemplate($templateFile);
            } catch (Twig_Error_Loader $exceptionception) {
            }
        }

        if (isset($file)) {
            $exception = new ErrorException($exception->getMessage(), 0, 1, $file, $templateLine, $exception);
        }

        throw $exception;
    }
}
