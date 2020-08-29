<?php namespace Com\Clay\Common\Libs;

use ArrayAccess;
use JsonSerializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Entity implements ArrayAccess, Arrayable, Jsonable, JsonSerializable
{
    protected $attributes = [];

    public function __construct($data = [])
    {
        $this->setAttributes($data);
    }

    protected function setAttributes(array $data = [])
    {
        if (!$data) return;
        
        foreach ($this->attributes as $key => $value) {
            $this->attributes[$key] = $data[$key] ?? null;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (isset($this->attributes[$offset]))
            $this->attributes[$offset] = null;
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    public function toArray()
    {
        return $this->attributes;
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param $model Model
     * @return mixed
     */
    public static function createFromModel($model)
    {
        if (!$model) return null;
        return new static(
            array_combine(
                array_map(
                    function ($item) {
                        return Str::camel($item);
                    }, array_keys($model->getAttributes())
                ),
                array_values($model->getAttributes())
            )
        );
    }

    /**
     * @param $models ArrayAccess
     * @return array
     */
    public static function batchCreateFromArray($models)
    {
        $rt = [];
        foreach ($models as $model) {
            $rt[] = static::createFromModel($model);
        }
        return $rt;
    }
}
