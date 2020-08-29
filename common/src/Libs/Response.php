<?php namespace Com\Clay\Common\Libs;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Response implements Arrayable, Jsonable, \JsonSerializable
{
    public $code;
    public $message;
    public $data;

    /**
     * Response constructor.
     * @param $code
     * @param $message
     * @param $data
     */
    public function __construct($data = null, $message = '请求成功', $code = 0)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    public function toArray()
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}