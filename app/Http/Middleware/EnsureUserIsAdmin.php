<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if (auth()->check() && auth()->user()->usertype === 'admin') {
            return $next($request);
        }

        // If the user is not an admin, abort with a 403 error
        return abort(403, 'Unauthorized');
    }
}
