<?php namespace Com\Clay\UacSimpleApi\Facade;

use Illuminate\Support\Facades\Facade;
use Com\Clay\UacSimpleApi\Service\UserInterface;
use Com\Clay\Common\Libs\Page;
use Com\Clay\UacSimpleApi\Entity\User;
use Com\Clay\UacSimpleApi\Entity\UserFilter;

/**
 * @method static User[] queryUserList(?UserFilter $userFilter, int $limit = 1000) 用户列表
 * @method static Page queryUserPage(?UserFilter $userFilter, int $size = 20, int $page = 1) 用户列表（分页）
 * @method static int createUser(User $user) 创建用户
 * @method static User findUser(int $id) 用户信息
 * @method static bool updateUser(int $id, User $user) 更新用户
 * @method static bool deleteUser(int $id) 删除用户
 */
class UserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserInterface::class;
    }
}
