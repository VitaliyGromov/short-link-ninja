<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Data\UserDTO;
use App\Models\User;

final readonly class EloquentUserRepository implements UserRepositoryContract
{
    public function create(UserDTO $user): UserDTO
    {
        /** @var User $model */
        $model = $user->toModel();
        $model->saveOrFail();

        return UserDTO::fromModel($model);
    }
}
