<?php

namespace SynergiTech\Twig\Twig;

use Illuminate\Filesystem\Filesystem;
use Illuminate\View\ViewFinderInterface;

use InvalidArgumentException;

use \Twig_LoaderInterface;
use \Twig_Error_Loader;
use \Twig_Source;

class Loader implements Twig_LoaderInterface
{
    protected $files;

    protected $finder;

    protected $extension;

    protected $cache = [];

    public function __construct(Filesystem $files, ViewFinderInterface $finder, $extension = 'twig')
    {
        $this->files = $files;
        $this->finder = $finder;
        $this->extension = $extension;
    }

    public function findTemplate($name)
    {
        if ($this->files->exists($name)) {
            return $name;
        }

        $name = $this->normalizeName($name);

        if (isset($this->cache[$name])) {
            return $this->cache[$name];
        }

        try {
            $this->cache[$name] = $this->finder->find($name);
        } catch (InvalidArgumentException $ex) {
            throw new Twig_Error_Loader($ex->getMessage());
        }

        return $this->cache[$name];
    }

    protected function normalizeName($name)
    {
        if ($this->files->extension($name) === $this->extension) {
            $name = substr($name, 0, - (strlen($this->extension) + 1));
        }

        return $name;
    }

    public function exists($name)
    {
        try {
            $this->findTemplate($name);
        } catch (Twig_Error_Loader $exception) {
            return false;
        }

        return true;
    }

    public function getSource($name)
    {
        $path = $this->findTemplate($name);

        return $this->files->get($path);
    }

    public function getSourceContext($name)
    {
        $path = $this->findTemplate($name);

        return new Twig_Source($this->files->get($path), $name, $path);
    }

    public function getCacheKey($name)
    {
        return $this->findTemplate($name);
    }

    public function isFresh($name, $time)
    {
        return $this->files->lastModified($this->findTemplate($name)) <= $time;
    }
}
