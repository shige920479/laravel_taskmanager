<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $requestUser = $this->getRequestUser($request);
        if (! $request->expectsJson()) {
            return match ($requestUser) {
                'users' => route('index'),
                'manager' => route('manager.index'),
                default => route('index')
            };
        }
        return null;
    }

    private function getRequestUser(Request $request)
    {
        if($request->routeIs('manager.*')) {
            return 'manager';
        }
        return 'users';
    }
}
