<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // Check if the request is for admin routes
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login'); // Redirect to admin login page
            }

            // Default redirect for regular users
            return route('home'); // Or route('login') if you have user login
        }

        return null; // JSON requests get a 401
    }
}
