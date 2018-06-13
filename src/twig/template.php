<?php

namespace SynergiTech\Twig\Twig;

use Illuminate\View\View;

use \Twig_Template;

abstract class Template implements Twig_Template
{
    protected $firedEvents = false;

    protected $name = null;

    public function display(array $context, array $blocks = [])
    {
        if (!isset($context['__env'])) {
            $context = $this->env->mergeShared($context);
        }

        if ($this->shouldFireEvents()) {
            $context = $this->fireEvents($context);
        }

        parent::display($context, $blocks);
    }

    public function fireEvents($context)
    {
        if (!isset($context['__env'])) {
            return $context;
        }

        $env= $context['__env'];
        $viewName = $this->name ?: $this->getTemplateName();

        $view = new View(
            $env,
            $env->getEngineResolver()->resolve('twig'),
            $viewName,
            null,
            $context
        );

        $env->callCreator($view);
        $env->callComposer($view);

        return $view->getData();
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function shouldFireEvents()
    {
        return !$this->firedEvents;
    }

    public function setFiredEvents($fired = true)
    {
        $this->firedEvents = $fired;
    }

    protected function getAttribute($object, $item, array $arguments = [], $type = Twig_Template::ANY_CALL, $isDefinedTest = false, $ignoreStrictCheck = false)
    {
        if (Twig_Template::METHOD_CALL !== $type and is_a($object, 'Illuminate\Database\Eloquent\Model')) {
            if ($isDefinedTest) {
                return true;
            }

            if ($this->env->hasExtension('sandbox')) {
                $this->env->getExtension('sandbox')->checkPropertyAllowed($object, $item);
            }

            return $object->$item;
        }

        return parent::getAttribute($object, $item, $arguments, $type, $isDefinedTest, $ignoreStrictCheck);
    }
}
