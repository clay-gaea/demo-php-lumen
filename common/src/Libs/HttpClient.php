<?php namespace Com\Clay\Common\Libs;

use Psr\Http\Message\ResponseInterface;

abstract class HttpClient
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;
    protected $artifactId;

    public function __construct()
    {
        $host = config("gaea_services.{$this->artifactId}.host", '');
        if (!$host) {
            throw new RuntimeException("{$this->artifactId} host not config.");
        }
        $config = ['base_uri' => $host];
        $this->client = new \GuzzleHttp\Client($config);
    }

    /**
     * 异步方法
     *
     * @param $method   string
     * @param $uri      string
     * @param $options  array
     * @param $callback callable
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    protected function requestAsync($method, $uri, $options, $callback = null, $class = '')
    {
        return $this->client->requestAsync($method, $uri, $options)->then(
            function (ResponseInterface $response) use ($callback, $class) {
                $responseData = json_decode($response->getBody(), true);
//                if ($responseData['code'] !== 0) {
//                    throw new LogicException($responseData['message'] ?? 'service error', $responseData['code']);
//                }

                return is_callable($callback) && $responseData['data'] && is_array($responseData['data'])
                    ? call_user_func($callback, $class, $responseData['data']) : $responseData['data'] ?? null;
            },
            function (RequestException $e) {
                dd($e);
//                $promise->reject($e);
            }
        );
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return $this->client;
    }

    public function toPage($class, $data)
    {
        if (!isset($data['total']) || !isset($data['list']) || !is_array($data['list'])) {
            return new Page();
        }

        $list = [];
        foreach ($data['list'] as $item) {
            $list [] = $this->toEntity($class, $item);
        }

        return new Page(['total' => $data['total'], 'list' => $list]);
    }

    public function toArray($class, $data)
    {
        $list = [];
        foreach ($data as $item) {
            $list[] = $this->toEntity($class, $item);
        }

        return $list;
    }

    public function toEntity($class, $data)
    {
        if (!$data || !is_array($data)) return null;
        return new $class($data);
    }
}