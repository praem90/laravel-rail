<?php

namespace Praem90\Rail;

use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Monolog\Formatter\LineFormatter;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('rail', fn($app) => new Rail($app));
    }

    public function boot()
    {
        $this->app['events']->listen(MessageLogged::class, [$this->app['rail'], 'log']);

        foreach ($this->app['log']->getHandlers() as $handler) {
            $formatter = $handler->getFormatter();
            if ($formatter instanceof LineFormatter) {
                $formatter->allowInlineLineBreaks();
            }
        }
    }
}
