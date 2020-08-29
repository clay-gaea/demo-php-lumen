<?php namespace Com\Clay\Common\Libs;

/**
 * @property Mixed[] $list
 * @property int $total
 */
class Page extends Entity
{
    protected $attributes = [
        'total' => 0,
        'list' => []
    ];
}
