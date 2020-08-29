<?php

namespace App\Services;

use Com\Clay\Common\Libs\Page;
use Com\Clay\UacSimpleApi\Entity\User;
use Com\Clay\UacSimpleApi\Entity\UserFilter;
use Com\Clay\UacSimpleApi\Service\UserInterface;
use App\Models\User as UserRepository;

class UserService implements UserInterface
{
    public function queryUserPage(?UserFilter $userFilter, int $size = 20, int $page = 1): Page
    {
        $query = $this->getQuery($userFilter);
        $total = $query->count();
        $list = User::batchCreateFromArray($query->get());
        return new Page(compact('total', 'list'));
    }

    public function createUser(User $user): int
    {
        $repository = new UserRepository();
        $repository->setRawAttributes(array_filter($user->toArray()));
        $repository->save();
        return $repository->getKey();
    }

    public function findUser(int $id): ?User
    {
        $userRepository = UserRepository::query()->find($id);
        return User::createFromModel($userRepository);
    }

    public function updateUser(int $id, User $user): bool
    {
        $repository = UserRepository::query()->find($id);
        $repository->setRawAttributes(array_filter($user->toArray()));
        return $repository->save();
    }

    public function deleteUser(int $id): bool
    {
        $repository = UserRepository::query()->findOrFail($id);
        return $repository->delete();
    }

    protected function getQuery(?UserFilter $userFilter)
    {
        $query = UserRepository::query();
        if (!$userFilter) return $query->orderBy('id', 'desc');
        if ($userFilter->ids) {
            $query->whereIn('id', $userFilter->ids);
        }
        if ($userFilter->nickname) {
            $query->whereIn('nickname', "%{$userFilter->nickname}%");
        }
        if ($userFilter->username) {
            $query->whereIn('username', "%{$userFilter->username}%");
        }
        if ($userFilter->mobile) {
            $query->whereIn('mobile', $userFilter->mobile);
        }
        if ($userFilter->email) {
            $query->whereIn('email', $userFilter->email);
        }
        if ($userFilter->status != null) {
            $query->whereIn('status', $userFilter->status);
        }
        if ($userFilter->createdAtRange && count($userFilter->createdAtRange) == 2) {
            $query->whereBetween('created_at', $userFilter->createdAtRange);
        }
        if ($userFilter->updatedAtRange && count($userFilter->updatedAtRange) == 2) {
            $query->whereBetween('updated_at', $userFilter->updatedAtRange);
        }
        return $query->orderBy('id', 'desc');
    }

    public function queryUserList(?UserFilter $userFilter, int $limit = 1000): array
    {
        $query = $this->getQuery($userFilter);
        return User::batchCreateFromArray($query->limit($limit)->get());
    }
}
