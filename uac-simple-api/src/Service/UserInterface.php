<?php namespace Com\Clay\UacSimpleApi\Service;

use Com\Clay\Common\Libs\Page;
use Com\Clay\UacSimpleApi\Entity\User;
use Com\Clay\UacSimpleApi\Entity\UserFilter;

interface UserInterface
{
    /**
     * 用户列表
     * @param $userFilter UserFilter|NULL
     * @param $limit int 限制，默认1000，最大值10000
     * @return User[]
     */
    public function queryUserList(?UserFilter $userFilter, int $limit = 1000): array;

    /**
     * 用户列表（分页）
     * @param $userFilter UserFilter|NULL
     * @param $size int 每页数量，默认 20
     * @param $page int 页码，从 1 开始，默认 1
     * @return Page
     */
    public function queryUserPage(?UserFilter $userFilter, int $size = 20, int $page = 1): Page;

    /**
     * 创建用户
     * @param $user User
     * @return int
     */
    public function createUser(User $user): int;

    /**
     * 用户信息
     * @param $id int
     * @return User
     */
    public function findUser(int $id): User;

    /**
     * 更新用户
     * @param $id int
     * @param $user User
     * @return bool
     */
    public function updateUser(int $id, User $user): bool;

    /**
     * 删除用户
     * @param $id int
     * @return bool
     *
     * @throws \Exception
     */
    public function deleteUser(int $id): bool;

}
