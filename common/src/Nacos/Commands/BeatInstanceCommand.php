<?php namespace Com\Clay\Common\Nacos\Commands;

use Com\Clay\Common\Nacos\NacosForService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BeatInstanceCommand extends Command
{
    protected $signature = 'nacos:beatInstance {serviceName} {--ip=} {--port=} {--weight=}';

    protected $description = 'Nacos实例心跳';

    public function handle()
    {
        $serviceName = $this->argument('serviceName');
        $ip = $this->option('ip');
        $port = $this->option('port');
        $weight = $this->option('weight');

        $nacosService = new NacosForService();
//        "cluster":"DEFAULT","ip":"2.2.2.2","metadata":{},"port":9999,"scheduled":true,"serviceName":"nacos.test.3","weight":1.0
        $beat = [
            'cluster' => 'DEFAULT',
            'ip' => $ip,
            'port' => $port,
            'weight' => $weight,
            'scheduled' => true,
            'ephemeral' => false,
            'serviceName' => 'com.clay.services.uac',
            'metadata' => ['hostname' => gethostname()],
        ];
        $nacosService->beatInstanceAsync($serviceName, $beat)->wait();
    }
}
