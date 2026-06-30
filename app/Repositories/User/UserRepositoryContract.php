<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\Data\UserDTO;

interface UserRepositoryContract
{
    public function create(UserDTO $user): UserDTO;
}
