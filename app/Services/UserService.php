<?php

declare(strict_types=1);

namespace App\Services;

use App\Data\UserDTO;
use App\Repositories\User\UserRepositoryContract;

final class UserService
{
    public function __construct(
        private readonly UserRepositoryContract $userRepository,
    ) {}

    public function register(string $name, string $email, string $password): UserDTO
    {
        return $this->userRepository->create(new UserDTO(
            name: $name,
            email: $email,
            password: $password,
        ));
    }
}
