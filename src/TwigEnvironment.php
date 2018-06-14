<?php

namespace SynergiTech\Twig;

use Illuminate\Contracts\Container\Container;
use Illuminate\View\ViewFinderInterface;

use \Twig_Environment;
use \Twig_LoaderInterface;
use \Twig_Error;

use InvalidArgumentException;

class TwigEnvironment extends Twig_Environment
{
    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $app;

    /**
     * {@inheritdoc}
     */
    public function __construct(Twig_LoaderInterface $loader, $options = [], Container $app = null)
    {
        if (isset($options['autoescape']) && $options['autoescape'] === true) {
            $options['autoescape'] = 'html';
        }

        parent::__construct($loader, $options);

        $this->app = $app;
    }

    /**
     * Get the Laravel application
     *
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getApplication()
    {
        return $this->app;
    }

    /**
     * Set the Laravel application
     *
     * @param \Illuminate\Contracts\Container\Container $app
     *
     * @return void
     */
    public function setApplication(Container $app)
    {
        $this->app = $app;
    }
}
