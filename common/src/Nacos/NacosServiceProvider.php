<?php namespace Com\Clay\Common\Nacos;

use Com\Clay\Common\Nacos\Commands\NacosBeatInstanceCommand;
use Com\Clay\Common\Nacos\Commands\NacosGetConfigCommand;
use Illuminate\Support\ServiceProvider;

class NacosServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->registerConfig();

        $this->commands([
            NacosBeatInstanceCommand::class,
            NacosGetConfigCommand::class,
        ]);
    }

    private function registerConfig()
    {
        $config = $this->app->basePath() . '/config/nacos.php';
        if (!is_file($config)) {
            $config = __DIR__ . '/config/nacos.php';
        }
        $this->mergeConfigFrom($config, 'nacos');
    }
}
