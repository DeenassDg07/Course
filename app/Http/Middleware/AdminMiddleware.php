<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        protected $routeMiddleware = [
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }
          'admin' => \App\Http\Middleware\AdminMiddleware::class,
];
        return $next($request);
    }
}
