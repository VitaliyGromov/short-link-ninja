<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Services\UserService;
use Tests\TestCase;

final class UserServiceTest extends TestCase
{
    private UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = app(UserService::class);
    }

    public function test_register_user(): void
    {
        $user = $this->userService->register('John Doe', 'john@example.com', 'password');
        $this->assertNotNull($user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
        $this->assertNotNull($user->password);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
