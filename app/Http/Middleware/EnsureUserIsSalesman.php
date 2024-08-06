<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsSalesman
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is a salesman
        if (auth()->check() && auth()->user()->usertype === 'salesman') {
            return $next($request);
        }

        // If the user is not a salesman, abort with a 403 error
        return abort(403, 'Unauthorized');
    }
}
