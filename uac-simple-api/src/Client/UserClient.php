<?php namespace Com\Clay\UacSimpleApi\Client;

use Com\Clay\Common\Libs\HttpClient;
use Com\Clay\UacSimpleApi\Service\UserInterface;
use Com\Clay\Common\Libs\Page;
use Com\Clay\UacSimpleApi\Entity\UserFilter;
use Com\Clay\UacSimpleApi\Entity\User;

class UserClient extends HttpClient implements UserInterface
{
    protected $artifactId = 'uac-simple-api';

    protected $apis = [
        'queryUserList' => ['method' => 'POST', 'path' => '/user/list'],
        'queryUserPage' => ['method' => 'POST', 'path' => '/user/page'],
        'createUser' => ['method' => 'POST', 'path' => '/user/create'],
        'findUser' => ['method' => 'GET', 'path' => '/user/find'],
        'updateUser' => ['method' => 'PUT', 'path' => '/user/update'],
        'deleteUser' => ['method' => 'DELETE', 'path' => '/user/delete'],
    ];

    public function queryUserList(?UserFilter $userFilter, int $limit = 1000): array
    {
        return $this->queryUserListAsync($userFilter, $limit)->wait();
    }

    public function queryUserPage(?UserFilter $userFilter, int $size = 20, int $page = 1): Page
    {
        return $this->queryUserPageAsync($userFilter, $size, $page)->wait();
    }

    public function createUser(User $user): int
    {
        return $this->createUserAsync($user)->wait();
    }

    public function findUser(int $id): User
    {
        return $this->findUserAsync($id)->wait();
    }

    public function updateUser(int $id, User $user): bool
    {
        return $this->updateUserAsync($id, $user)->wait();
    }

    public function deleteUser(int $id): bool
    {
        return $this->deleteUserAsync($id)->wait();
    }

    public function queryUserListAsync(?UserFilter $userFilter, int $limit = 1000)
    {
        $api = $this->apis['queryUserList'];
        return $this->requestAsync(
            $api['method'], $api['path'],
            [
                'query' => [
                    'limit' => $limit,
                ],
                'json' => !$userFilter ? [] : $userFilter->toArray(),
            ],
            // 需要转义
            [$this, 'toArray'],
            User::class
        );
    }

    public function queryUserPageAsync(?UserFilter $userFilter, int $size = 20, int $page = 1)
    {
        $api = $this->apis['queryUserPage'];
        return $this->requestAsync(
            $api['method'], $api['path'],
            [
                'query' => [
                    'size' => $size,
                    'page' => $page,
                ],
                'json' => !$userFilter ? [] : $userFilter->toArray(),
            ],
            // 需要转义
            [$this, 'toPage'],
            User::class
        );
    }

    public function createUserAsync(User $user)
    {
        $api = $this->apis['createUser'];
        return $this->requestAsync(
            $api['method'], $api['path'],
            [
                'json' => $user->toArray(),
            ]
        );
    }

    public function findUserAsync(int $id)
    {
        $api = $this->apis['findUser'];
        return $this->requestAsync(
            $api['method'], $api['path'],
            [
                'query' => [
                    'id' => $id,
                ],
            ],
            // 需要转义
            [$this, 'toEntity'],
            User::class
        );
    }

    public function updateUserAsync(int $id, User $user)
    {
        $api = $this->apis['updateUser'];
        return $this->requestAsync(
            $api['method'], $api['path'],
            [
                'query' => [
                    'id' => $id,
                ],
                'json' => $user->toArray(),
            ]
        );
    }

    public function deleteUserAsync(int $id)
    {
        $api = $this->apis['deleteUser'];
        return $this->requestAsync(
            $api['method'], $api['path'],
            [
                'query' => [
                    'id' => $id,
                ],
            ]
        );
    }

}
