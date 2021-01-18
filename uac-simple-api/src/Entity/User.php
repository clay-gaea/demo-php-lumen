<?php namespace Com\Clay\UacSimpleApi\Entity;

use Com\Clay\Common\Libs\Entity;

/**
 * @property $id int 
 * @property $nickname string 昵称
 * @property $username string 用户名
 * @property $password string 密码
 * @property $mobile string 手机
 * @property $email string 邮箱
 * @property $avatar string 头像
 * @property $status int 状态0禁用 1启用
 * @property $remark string 备注
 * @property $createdAt string 
 * @property $updatedAt string 
 */
class User extends Entity
{
    protected $attributes = [
        'id' => null,
        'nickname' => null,
        'username' => null,
        'password' => null,
        'mobile' => null,
        'email' => null,
        'avatar' => null,
        'status' => null,
        'remark' => null,
        'createdAt' => null,
        'updatedAt' => null,
    ];
}
