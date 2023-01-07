<?php

namespace App\Services;

use App\Contracts\DataServiceContract;
use App\Helpers\UserHelper;

class LocalDataService implements DataServiceContract
{

    public function create(array $data)
    {
        return UserHelper::currentUserData()->create($data);
    }

    public function delete(int $id)
    {
        return UserHelper::currentUserData()->find($id)
            ->delete();
    }

    public function update(array $data)
    {
        return UserHelper::currentUserData()->find((int) $data['id'])
            ->update($data);
    }

    public function get(?int $id = null)
    {
        if ($id) {
            return UserHelper::currentUserData()->find($id)
                ->get();
        }
        return UserHelper::currentUserData()->get();
    }
}
