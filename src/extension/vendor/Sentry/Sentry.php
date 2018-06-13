<?php

namespace SynergiTech\Twig\Extension\Vendor\Sentry;

use \Twig_Extension;
use \Twig_SimpleFunction;

use \Sentry as SentryFacade;

class Sentry extends Twig_Extension
{
    public function getName()
    {
        return 'SynergiTech_Twig_Extension_Sentry_Sentry';
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('sentry_last_event', function () {
                return SentryFacade::getLastEventID();
            })
        ];
    }
}
