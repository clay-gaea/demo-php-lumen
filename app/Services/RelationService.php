<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Resource;
use Com\Clay\UacSimpleApi\Service\RelationInterface;

/**
 * 维度：部门 资源 用户
 * 关系：部门->资源、部门->人员、资源->部门、人员->部门
 */
class RelationService implements RelationInterface
{
    public function createDeptRes(array $deptIds, array $resIds): bool
    {
        return true;
    }

    public function createDeptUser(array $deptIds, array $userIds): bool
    {
        return true;
    }
}
