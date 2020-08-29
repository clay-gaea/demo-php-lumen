<?php

namespace App\Services;

use Com\Clay\Common\Libs\Page;
use Com\Clay\UacSimpleApi\Entity\Resource;
use Com\Clay\UacSimpleApi\Entity\ResourceFilter;
use Com\Clay\UacSimpleApi\Service\ResourceInterface;
use App\Models\Resource as ResourceRepository;

class ResourceService implements ResourceInterface
{
    public function queryResourceList(?ResourceFilter $resourceFilter, int $limit = 1000): array
    {
        $query = $this->getQuery($resourceFilter);
        return Resource::batchCreateFromArray($query->limit($limit)->get());
    }

    public function queryResourcePage(?ResourceFilter $resourceFilter, int $size = 20, int $page = 1): Page
    {
        $query = $this->getQuery($resourceFilter);
        $total = $query->count();
        $list = Resource::batchCreateFromArray($query->offset($size * ($page - 1))->limit($size)->get());
        return new Page(compact('total', 'list'));
    }

    public function createResource(Resource $resource): Resource
    {
        $repository = new ResourceRepository();
        $repository->setRawAttributes(array_filter($resource->toArray()));
        $repository->save();
        return Resource::createFromModel($repository);
    }

    public function findResource(int $id): ?Resource
    {
        $find = ResourceRepository::query()->findOrFail($id);
        return Resource::createFromModel($find);
    }

    public function updateResource(int $id, Resource $resource): ?Resource
    {
        $find = ResourceRepository::query()->findOrFail($id);
        $find->setRawAttributes(array_filter($resource->toArray()));
        $find->save();
        return Resource::createFromModel($find);
    }

    public function deleteResource(int $id): bool
    {
        $find = ResourceRepository::query()->findOrFail($id);
        return $find->delete();
    }

    protected function getQuery(?ResourceFilter $filter)
    {
        $query = ResourceRepository::query();
        if (!$filter) return $query->orderBy('id', 'desc');
        if ($filter->ids) {
            $query->whereIn('id', $filter->ids);
        }
        if ($filter->name) {
            $query->whereIn('name', "%{$filter->name}%");
        }
        if ($filter->type) {
            $query->whereIn('type', $filter->type);
        }
        if ($filter->default != null) {
            $query->whereIn('default', $filter->default);
        }
        if ($filter->status) {
            $query->whereIn('status', $filter->status);
        }
        if ($filter->pId) {
            $query->whereIn('pId', $filter->pId);
        }
        if ($filter->createdAtRange && count($filter->createdAtRange) == 2) {
            $query->whereBetween('created_at', $filter->createdAtRange);
        }
        if ($filter->updatedAtRange && count($filter->updatedAtRange) == 2) {
            $query->whereBetween('updated_at', $filter->updatedAtRange);
        }
        if ($filter->bSort == 1) {
            $query->orderBy('sort', 'asc');
        }

        return $query->orderBy('id', 'desc');
    }
}
