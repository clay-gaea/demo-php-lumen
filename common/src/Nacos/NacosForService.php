<?php namespace Com\Clay\Common\Nacos;

use Com\Clay\Common\Exceptions\NacosException;
use GuzzleHttp\Client;

class NacosForService extends NacosConfig
{
    const APIS = [
        'getConfig' => ['method' => 'GET', 'path' => 'nacos/v1/cs/configs'], //获取配置
        'beatInstance' => ['method' => 'PUT', 'path' => 'nacos/v1/ns/instance/beat'], //发送实例心跳
        'registerInstance' => ['method' => 'POST', 'path' => 'nacos/v1/ns/instance'], // 实例注册
    ];

    // 获取配置
    public function getConfig(string $dataId, string $group = 'DEFAULT_GROUP'): string
    {
        $client = $this->getClient();
        $api = self::APIS[__FUNCTION__];
        $resp = $client->request($api['method'], $api['path'], [
            'query' => [
                'tenant' => $this->namespace,
                'dataId' => $dataId,
                'group' => $group
            ]
        ]);

        return $resp->getBody()->getContents();
    }

    /**
     * 发送实例心跳
     *
     * @param $serviceName  字符串         是    服务名
     * @param $groupName    字符串         否    分组名
     * @param $ephemeral    boolean       否    是否临时实例
     * @param $beat         JSON格式字符串  是    实例心跳内容
     * @return bool
     *
     * beatInfo {"cluster":"DEFAULT","ip":"2.2.2.2","metadata":{},"port":9999,"scheduled":true,"serviceName":"nacos.test.3","weight":1.0}
     *
     */
    function beatInstance(string $serviceName, array $beat, string $groupName = 'DEFAULT_GROUP', bool $ephemeral = false): bool
    {
        $client = $this->getClient();
        $api = self::APIS[__FUNCTION__];
        $resp = $client->request($api['method'], $api['path'], [
            'query' => [
                'namespaceId' => $this->namespace,
                'serviceName' => $serviceName,
                'group' => $group,
                'ephemeral' => $ephemeral,
                'beat' => json_encode($content, JSON_UNESCAPED_UNICODE)
            ]
        ]);
        return $resp->getBody()->getContents() === 'ok';
    }

    /**
     * @param string $serviceName
     * @param array $content
     * @param string $group
     * @param bool $ephemeral
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    function beatInstanceAsync(string $serviceName, array $content, string $group = 'DEFAULT_GROUP', bool $ephemeral = false)
    {
        $client = $this->getClient();
        $api = self::APIS['beatInstance'];
        return $client->requestAsync($api['method'], $api['path'], [
            'query' => [
                'namespaceId' => $this->namespace,
                'serviceName' => $serviceName,
                'group' => $group,
                'ephemeral' => $ephemeral,
                'beat' => json_encode($content, JSON_UNESCAPED_UNICODE)
            ]
        ]);
    }

    /**
     * 注册实例 need
     *
     * @param array $data
     * @return bool
     *
     * data属性：
     * 名称           类型    必选   描述
     * ip            字符串   是    服务实例IP
     * port          int     是    服务实例port
     * namespaceId   字符串   否    命名空间ID
     * weight        double  否    权重
     * enabled       boolean 否    是否上线
     * healthy       boolean 否    是否健康
     * metadata      字符串   否    扩展信息
     * clusterName   字符串   否    集群名
     * serviceName   字符串   是    服务名
     * groupName     字符串   否    分组名
     * ephemeral
     */
    function registerInstance(array $data): bool
    {
        $client = $this->getClient();
        $api = self::APIS[__FUNCTION__];
        $resp = $client->request($api['method'], $api['path'], ['json' => $data]);
        return $resp->getBody()->getContents() === 'ok';
    }
}
