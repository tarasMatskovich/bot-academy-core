<?php

namespace BotAcademy\Core\Providers;

use BotAcademy\Core\Console\Command\CreateStrategyCommand;
use BotAcademy\Core\Console\Command\CreateUserCommand;
use BotAcademy\Core\Console\Command\TestCommand;
use BotAcademy\Core\Console\Command\TradeCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->commands([
            TradeCommand::class,
            CreateUserCommand::class,
            CreateStrategyCommand::class,
            TestCommand::class,
        ]);
    }
}
