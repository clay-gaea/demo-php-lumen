<?php namespace Com\Clay\Common;

use Com\Clay\Common\Commands\Run;
use Illuminate\Console\Application as Artisan;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCommands([
            'Run' => 'command.run'
        ]);
    }

    /**
     * Docs: php artisan run test.php
     */
    protected function registerRunCommand()
    {
        $this->app->singleton('command.run', function ($app) {
            return new Run();
        });
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            call_user_func_array([$this, "register{$command}Command"], []);
        }

        $this->commands(array_values($commands));
    }

    /**
     * Register the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    public function commands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        Artisan::starting(function ($artisan) use ($commands) {
            $artisan->resolveCommands($commands);
        });
    }
}