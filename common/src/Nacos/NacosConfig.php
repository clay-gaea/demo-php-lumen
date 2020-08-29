<?php namespace Com\Clay\Common\Nacos;

use GuzzleHttp\Client;

class NacosConfig
{
    protected $host = '';
    protected $namespace = '';

    public function __construct()
    {
        $this->host = trim(config('nacos.host'), '/') . '/';
        $this->namespace = config('nacos.namespace');
    }

    protected function getClient()
    {
        return new Client(['base_uri' => $this->host]);
    }
}
