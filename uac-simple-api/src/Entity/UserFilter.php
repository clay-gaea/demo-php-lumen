<?php namespace Com\Clay\UacSimpleApi\Entity;

use Com\Clay\Common\Libs\Entity;

/**
 * @property $ids int[] 
 * @property $nickname string 昵称模糊匹配
 * @property $username string 昵称模糊匹配
 * @property $mobile string 手机
 * @property $email string 邮箱模糊匹配
 * @property $status int 
 * @property $createdAtRange string[] 两个元素数组
 * @property $updatedAtRange string[] 两个元素数组
 */
class UserFilter extends Entity
{
    protected $attributes = [
        'ids' => null,
        'nickname' => null,
        'username' => null,
        'mobile' => null,
        'email' => null,
        'status' => null,
        'createdAtRange' => null,
        'updatedAtRange' => null,
    ];
}
