<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    // app/Http/Middleware/AdminMiddleware.php
public function handle(Request $request, Closure $next)
{
    if (!$request->user() || !$request->user()->isAdmin()) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        
        return redirect('/')->with('error', 'Unauthorized access');
    }

    return $next($request);
}
}