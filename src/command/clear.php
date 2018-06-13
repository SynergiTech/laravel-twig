<?php

namespace SynergiTech\Twig\Command;

class ViewClearCommand extends \Illuminate\Foundation\Console\ViewClearCommand
{
    public function handle()
    {
        $path = $this->laravel['config']['view.compiled'];

        if (!$path) {
            throw new RuntimeException('View path not found.');
        }

        foreach ($this->files->glob("{$path}/*") as $view) {
            if ($this->files->isDirectory($view)) {
                $this->files->deleteDirectory($view);
            } else {
                $this->files->delete($view);
            }
        }

        $this->info('Compiled views cleared!');
    }
}
