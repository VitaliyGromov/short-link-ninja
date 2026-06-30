<?php

declare(strict_types=1);

namespace App\Data;

use App\Models\User;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

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

    public function toModel(): Model
    {
        /** @var User $model */
        $model = $this->id !== null
            ? User::query()->findOrFail($this->id)
            : new User;

        $model->fill([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if ($this->emailVerifiedAt !== null) {
            $model->email_verified_at = $this->emailVerifiedAt;
        }

        return $model;
    }
}
