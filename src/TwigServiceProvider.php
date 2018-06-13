<?php

namespace SynergiTech\Twig;

use Illuminate\View\ViewServiceProvider;

use \Twig_Loader_Chain;
use \Twig_Loader_Array;
use \Twig_Environment;

class TwigServiceProvider extends ViewServiceProvider
{
    protected function registerCommands()
    {
        $this->app->extend('command.view.clear', function ($command, $app) {
            return new Command\ViewClearCommand($app['files']);
        });

        $this->app->singleton('command.make.view', function ($app) {
            return new Command\MakeViewCommand($app['files']);
        });

        $this->commands(
            'command.view.clear',
            'command.make.view'
        );
    }

    public function register()
    {
        $this->registerCommands();

        $this->app->bindIf('twig.extension', function () {
            return $this->app['config']->get('twig.extension');
        });

        $this->app->bindIf('twig.options', function () {
            $options = $this->app['config']->get('twig.environment', []);

            if (!isset($options['cache']) || is_null($options['cache'])) {
                $options['cache'] = $this->app['config']->get('view.compiled');
            }

            return $options;
        });

        $this->app->bindIf('twig.extensions', function () {
            $load = $this->app['config']->get('twig.extensions', []);

            $options = $this->app['twig.options'];
            $isDebug = (bool) (isset($options['debug'])) ? $options['debug'] : false;

            if ($isDebug) {
                array_unshift($load, 'Twig_Extension_Debug');
            }

            return $load;
        });

        $this->app->bindIf('twig.lexer', function () {
            return null;
        });

        $this->app->bindIf('twig.templates', function () {
            return [];
        });

        $this->app->bindIf('twig.loader.array', function ($app) {
            return new Twig_Loader_Array($app['twig.templates']);
        });

        $this->app->bindIf('twig.loader.viewfinder', function () {
            return new Twig\Loader(
                $this->app['files'],
                $this->app['view']->getFinder(),
                $this->app['twig.extension']
            );
        });

        $this->app->bindIf(
            'twig.loader',
            function () {
                return new Twig_Loader_Chain([
                    $this->app['twig.loader.array'],
                    $this->app['twig.loader.viewfinder'],
                ]);
            },
            true
        );

        $this->app->bindIf(
            'twig',
            function () {
                $extensions = $this->app['twig.extensions'];
                $lexer = $this->app['twig.lexer'];

                if (isset($this->app['twig.options']['autoescape']) && $this->app['twig.options']['autoescape'] === true) {
                    $this->app['twig.options']['autoescape'] = 'html';
                }

                $twig = new Twig_Environment(
                    $this->app['twig.loader'],
                    $this->app['twig.options'],
                    $this->app
                );

                foreach ($extensions as $extension) {
                    if (is_string($extension)) {
                        try {
                            $extension = $this->app->make($extension);
                        } catch (\Exception $e) {
                            throw new InvalidArgumentException(
                                "Cannot instantiate Twig extension '$extension': " . $e->getMessage()
                            );
                        }
                    } elseif (is_callable($extension)) {
                        $extension = $extension($this->app, $twig);
                    } elseif (!is_a($extension, 'Twig_Extension')) {
                        throw new InvalidArgumentException('Incorrect extension type');
                    }

                    $twig->addExtension($extension);
                }

                if (is_a($lexer, 'Twig_LexerInterface')) {
                    $twig->setLexer($lexer);
                }

                return $twig;
            },
            true
        );

        $this->app->alias('twig', '\Twig_Environment');
        $this->app->alias('twig', 'SynergiTech\Twig\Twig');

        $this->app->bindIf('twig.compiler', function () {
            return new Engine\Compiler($this->app['twig']);
        });

        $this->app->bindIf('twig.engine', function () {
            return new Engine\Twig(
                $this->app['twig.compiler'],
                $this->app['twig.loader.viewfinder'],
                []
            );
        });
    }

    public function boot()
    {
        $config = __DIR__ . '/../config/twig.php';

        $this->publishes([
            $config => config_path('twig.php')
        ], 'config');

        $this->mergeConfigFrom($config, 'twig');

        $this->app['view']->addExtension(
            $this->app['twig.extension'],
            'twig',
            function () {
                return $this->app['twig.engine'];
            }
        );
    }

    public function provides()
    {
        return [
            'command.view.clear',
            'twig.extension',
            'twig.options',
            'twig.extensions',
            'twig.lexer',
            'twig.templates',
            'twig.loader.array',
            'twig.loader.viewfinder',
            'twig.loader',
            'twig',
            'twig.compiler',
            'twig.engine',
        ];
    }
}
