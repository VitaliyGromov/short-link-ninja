<?php

declare(strict_types=1);

namespace App\Filament\Pages\Auth;

use App\Services\UserService;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Password;

final class Register extends BaseRegister
{
    protected function handleRegistration(array $data): Model
    {
        $userDTO = app(UserService::class)->register(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
        );

        return $userDTO->toModel();
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label(__('filament-panels::pages/auth/register.form.password.label'))
            ->password()
            ->revealable(filament()->arePasswordsRevealable())
            ->required()
            ->rule(Password::default())
            ->same('passwordConfirmation')
            ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute'));
    }
}
