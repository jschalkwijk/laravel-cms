<?php

namespace JornSchalkwijk\LaravelCMS\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    // Add this to middlware Kernel under route middleware
    public function handle($request, Closure $next,...$roles)
    {

        foreach($roles as $role) {
            // Check if user has the role This check will depend on how your roles are set up
            if($request->user()->hasRole($role)){
                return $next($request);
            }
        }

        return abort(404);
    }
}
