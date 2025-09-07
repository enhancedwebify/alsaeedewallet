<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            if ($request->routeIs('admin.*') || $request->routeIs('superuser.*')) {
                // Redirect admin users to the superuser login page
                return route('admin.login');
            }

            // Redirect regular users to the user login page
            return route('user.login.page');
        }

        return null;
    }
}
