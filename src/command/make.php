<?php

namespace SynergiTech\Twig\Command;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeViewCommand extends Command
{
    protected $files;

    protected $name = 'make:view';

    protected $description = 'Create a new view';

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $filenames = explode(',', $this->argument('name'));

        foreach ($filenames as $filename) {
            $basename = $filename;

            $filename = resource_path('views') . DIRECTORY_SEPARATOR . implode('.', [$basename, $this->option('extension')]);
            if ($this->files->exists($filename)) {
                return $this->error('View already exists.');
            }

            $directory = resource_path('views') . DIRECTORY_SEPARATOR . substr($basename, 0, strrpos($basename, '/'));

            if (!$this->files->exists($directory)) {
                $this->files->makeDirectory($directory, 0777, true, false);
            }

            $file = '';

            if ($this->option('extension') == 'twig') {
                $file .= "{# " . implode('.', [$basename, $this->option('extension')]) . " #}\r\n";
                if ($this->option('extends') != null) {
                    $extension = pathinfo($this->option('extends'), PATHINFO_EXTENSION);

                    if ($extension == null) {
                        $extends = resource_path('views') . DIRECTORY_SEPARATOR . implode('.', [$this->option('extends'), $this->option('extension')]);
                    }

                    if (!$this->files->exists($extends)) {
                        return $this->error('Extended view does not exist.');
                    }

                    $file .= "\r\n{% extends '" . $this->option('extends') . "' %}\r\n";

                    $view = $this->files->get($extends);

                    $blocks = [];

                    preg_match_all('/{% block (.+?) %}/', $view, $blocks, PREG_PATTERN_ORDER);

                    foreach ($blocks[0] as $block) {
                        $file .= "\r\n" . $block . "\r\n{% endblock %}\r\n";
                    }
                }
            }

            $this->files->put($filename, $file);
        }

        $this->info('View(s) created successfully.');
    }

    protected function getOptions()
    {
        return [
            ['extension', null, InputOption::VALUE_OPTIONAL, 'The extension of the generated view.', 'twig'],
            ['extends', null, InputOption::VALUE_OPTIONAL, 'The view to "extend" from the created view(s).'],
        ];
    }

    protected function getArguments()
    {
        return [
            [
                'name',
                InputArgument::REQUIRED,
                'The name of the view to create.'
            ]
        ];
    }
}
