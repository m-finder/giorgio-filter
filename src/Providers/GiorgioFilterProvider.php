<?php

namespace GiorgioFilter\Providers;

use GiorgioFilter\Console\Commands\Make\Filter;
use Illuminate\Support\ServiceProvider;

class GiorgioFilterProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerCommands();
    }

    protected function registerCommands(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->commands([
            Filter::class,
        ]);
    }
}