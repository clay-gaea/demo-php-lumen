<?php namespace Com\Clay\UacSimpleApi\Controller;

use Laravel\Lumen\Routing\Controller;
use Com\Clay\UacSimpleApi\Entity\UserFilter;
use Com\Clay\UacSimpleApi\Service\UserInterface;

class UserController extends Controller
{
    /**
     * @var UserInterface
     */
    protected $userService;

    public function __construct(UserInterface $userService)
    {
        $this->userService = $userService;
    }

    public function queryUserList(?UserFilter $userFilter, int $limit = 1000)
    {
        return $this->userService->queryUserList($userFilter, $limit);
    }

    public function queryUserPage(?UserFilter $userFilter, int $size = 20, int $page = 1)
    {
        return $this->userService->queryUserPage($userFilter, $size, $page);
    }

    public function createUser(User $user)
    {
        return $this->userService->createUser($user);
    }

    public function findUser(int $id)
    {
        return $this->userService->findUser($id);
    }

    public function updateUser(int $id, User $user)
    {
        return $this->userService->updateUser($id, $user);
    }

    public function deleteUser(int $id)
    {
        return $this->userService->deleteUser($id);
    }

}
