<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use DateTimeInterface;

final class UserDTO extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly string $name = '',
        public readonly string $email = '',
        public readonly string $password = '',
        public readonly ?DateTimeInterface $emailVerifiedAt = null,
    ) {}

    public static function getModel(): string
    {
        return User::class;
    }

    public static function fromModel(User $user): self
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            password: $user->password,
            emailVerifiedAt: $user->email_verified_at,
        );
    }
}
