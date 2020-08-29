<?php namespace Com\Clay\Common\Nacos;

use GuzzleHttp\Client;

class NacosForClient extends NacosConfig
{

    static $APIS = [
        'getInstance' => ['method' => 'GET', 'path' => 'nacos/v1/ns/instance'],
        'getInstanceList' => ['method' => 'GET', 'path' => 'nacos/v1/ns/instance/list'],
    ];

    /**
     * 查询实例详情
     * 获取一个健康实例，根据负载均衡算法随机获取一个健康实例 need
     *
     * @param array $data
     * @return array
     *
     * data 属性:
     * 名称           类型      是否必选    描述
     * serviceName   字符串    是         服务名
     * groupName     字符串    否         分组名
     * ip            字符串    是         实例IP
     * port          字符串    是         实例端口
     * namespaceId   字符串    否         命名空间ID
     * cluster       字符串    否         集群名称
     * healthyOnly   boolean  否         默认为false    是否只返回健康实例
     * ephemeral     boolean  否         是否临时实例
     */
    function getInstance(array $data): array
    {
        $client = $this->getClient();
        $api = self::$APIS[__FUNCTION__];
        $resp = $client->request($api['method'], $api['path'], ['query' => $data]);
        return json_decode($resp->getBody()->getContents(), true);
    }

    /**
     * @param $serviceName string
     * @return array|null
     */
    function getOneHealthyInstance($serviceName)
    {
        $data = $this->getInstanceList($serviceName, []);
        if (!$data['hosts']) return null;

        $index = array_rand($data['hosts']);
        return $data['hosts'][0];
    }

    public function getInstanceList($serviceName, $clusters = [], $healthyOnly = false)
    {
        $query = array_filter([
            'serviceName' => $serviceName,
            'namespaceId' => $this->namespace,
            'clusters' => join(',', $clusters),
            'healthyOnly' => $healthyOnly,
        ]);

        $api = self::$APIS[__FUNCTION__];
        $resp = $this->getClient()->request($api['method'], $api['path'], [
            'query' => $query,
        ]);

        $data = json_decode($resp->getBody(), JSON_OBJECT_AS_ARRAY);
        return $data;
    }
}
