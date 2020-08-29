<?php

namespace App\Services;

use Com\Clay\Common\Libs\Page;
use Com\Clay\UacSimpleApi\Entity\Department;
use Com\Clay\UacSimpleApi\Entity\DepartmentFilter;
use Com\Clay\UacSimpleApi\Service\DepartmentInterface;
use App\Models\Department as DeptRepository;

class DepartmentService implements DepartmentInterface
{
    public function queryDepartmentList(?DepartmentFilter $departmentFilter, int $limit = 1000): array
    {
        $query = $this->getQuery($departmentFilter);
        return Department::batchCreateFromArray($query->limit($limit)->get());
    }

    public function queryDepartmentPage(?DepartmentFilter $departmentFilter, int $size = 20, int $page = 1): Page
    {
        $query = $this->getQuery($departmentFilter);
        $total = $query->count();
        $list = Department::batchCreateFromArray($query->offset($size * ($page - 1))->limit($size)->get());
        return new Page(compact('total', 'list'));
    }

    public function createDepartment(Department $department): ?Department
    {
        $repository = new DeptRepository();
        $repository->setRawAttributes(array_filter($department->toArray()));
        $repository->save();
        return Department::createFromModel($repository);
    }

    public function findDepartment(int $id): ?Department
    {
        $find = DeptRepository::query()->findOrFail($id);
        return Department::createFromModel($find);
    }

    public function updateDepartment(int $id, Department $department): ?Department
    {
        $find = DeptRepository::query()->findOrFail($id);
        $find->setRawAttributes(array_filter($department->toArray()));
        return Department::createFromModel($find);
    }

    public function deleteDepartment(int $id): bool
    {
        $find = DeptRepository::query()->findOrFail($id);
        return $find->delete();
    }

    protected function getQuery(?DepartmentFilter $filter)
    {
        $query = DeptRepository::query();
        if (!$filter) return $query->orderBy('id', 'desc');
        if ($filter->ids) {
            $query->whereIn('id', $filter->ids);
        }
        if ($filter->name) {
            $query->where('name', 'like', "%{$filter->name}%");
        }
        if ($filter->leaderId) {
            $query->where('leaderId', $filter->leaderId);
        }
        if ($filter->pId) {
            $query->where('p_id', $filter->pId);
        }
        if ($filter->status) {
            $query->where('status', $filter->status);
        }
        if ($filter->bSort == 1) {
            $query->orderBy('sort', 'asc');
        }
        if ($filter->createdAtRange && count($filter->createdAtRange) == 2) {
            $query->whereBetween('created_at', $filter->createdAtRange);
        }
        if ($filter->updatedAtRange && count($filter->updatedAtRange) == 2) {
            $query->whereBetween('updated_at', $filter->updatedAtRange);
        }

        return $query->orderBy('id', 'desc');
    }
}
