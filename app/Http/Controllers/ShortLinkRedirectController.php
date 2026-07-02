<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\ShortLinkRedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ShortLinkRedirectController extends Controller
{
    public function __construct(
        private readonly ShortLinkRedirectService $shortLinkRedirectService,
    ) {}

    public function redirect(string $shortCode, Request $request): RedirectResponse
    {
        try {
            $redirectUrl = $this->shortLinkRedirectService->redirect(
                shortCode: $shortCode,
                ipAddress: $request->ip() ?? '0.0.0.0',
            );
        } catch (NotFoundException) {
            abort(404);
        }

        return redirect($redirectUrl);
    }
}
