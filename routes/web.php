<?php

declare(strict_types=1);

use App\Http\Controllers\ShortLinkRedirectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('welcome');
});

Route::get('/{shortCode}', [ShortLinkRedirectController::class, 'redirect'])
    ->where('shortCode', '[a-z0-9]{' . config('short-link.short_code_length') . '}')
    ->name('short-link.redirect');
