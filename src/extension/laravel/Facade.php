<?php

namespace SynergiTech\Twig\Extension\Laravel;

use Illuminate\Config\Repository;
use Illuminate\Foundation\Application;

use \Twig_Extension;
use \Twig_Function_Function;

class Facade extends Twig_Extension
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var array Lookup cache
     */
    protected $lookup = [];

    /**
     * @var array Aliases loaded by Illuminate.
     */
    protected $aliases;

    /**
     * Create the new Facade extension
     *
     * @param \Illuminate\Foundation\Application
     * @param \Illuminate\Config\Repository
     */
    public function __construct(Application $app, Repository $config)
    {
        $this->app = $app;
        $this->config = $config;

        $this->setAliases($this->config->get('app.aliases', []));

        $this->app['twig']->registerUndefinedFunctionCallback(function ($name) {
            return $this->getFunction($name);
        });
    }

    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Laravel_Facade';
    }

    /**
     * Set aliases
     *
     * @param array $aliases Aliased classes
     *
     * @return void
     */
    public function setAliases(array $aliases)
    {
        $this->aliases = array_change_key_case($aliases, CASE_LOWER);
    }

    /**
     * Get aliases
     *
     * @return array
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * Checks for the function in the lookup cache
     *
     * @param string $name Function name
     *
     * @return Twig_Function_Function|false
     */
    public function getLookup($name)
    {
        $name = strtolower($name);

        return (array_key_exists($name, $this->lookup)) ? $this->lookup[$name] : false;
    }

    /**
     * Add a function to the cache
     *
     * @param string $name Function name
     * @param Twig_Function_Function $function Function to cache
     *
     * @return void
     */
    public function setLookup($name, Twig_Function_Function $function)
    {
        $this->lookup[strtolower($name)] = $function;
    }

    /**
     * Get the class and method from the function name
     *
     * @param string $name Function name
     *
     * @return array|bool Array containing class and method or FALSE if invalid
     */
    public function getAliasParts($name)
    {
        if (strpos($name, '_') !== false) {
            $parts = explode('_', $name);
            $parts = array_filter($parts);

            if (count($parts) < 2) {
                return false;
            }

            return [
                $parts[0],
                implode('_', array_slice($parts, 1))
            ];
        }

        return false;
    }

    /**
     * Allow twig to call aliased functions
     *
     * @param string $name Function name
     *
     * @return Twig_Function_Function|false
     */
    public function getFunction($name)
    {
        $name = $this->getShortcut($name);

        // Check if the function has been cached
        if ($function = $this->getLookup($name)) {
            return $function;
        }

        // Get the class or method
        $parts = $this->getAliasParts($name);

        if ($parts === false) {
            return false;
        }

        list($class, $method) = $parts;
        $class = strtolower($class);

        // Check if the alias exists
        if (array_key_exists($class, $this->aliases)) {
            $class = $this->aliases[$class];
            $function = new Twig_Function_Function($class . '::' . $method);

            $this->setLookup($name, $function);

            return $function;
        }

        return false;
    }
}
