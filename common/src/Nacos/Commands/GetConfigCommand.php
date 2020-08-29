<?php namespace Com\Clay\Common\Nacos\Commands;

use Com\Clay\Common\Nacos\NacosForService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetConfigCommand extends Command
{
    protected $signature = 'nacos:getConfig';

    protected $description = 'Nacos获取配置';

    public function handle()
    {
        // serviceName
        $nacosService = new NacosForService();
        $config = $nacosService->getConfig('dev', 'com.clay.services.uac');
    }
}
