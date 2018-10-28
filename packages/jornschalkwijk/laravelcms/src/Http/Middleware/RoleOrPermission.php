<?php

namespace JornSchalkwijk\LaravelCMS\Http\Middleware;

use Closure;

class RoleOrPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$role,$permission = null)
    {

        // Check if user has the role This check will depend on how your roles are set up
        if($request->user()->hasRole($role)){
            return $next($request);
        }

        if($permission !== null && $request->user()->can($permission)){
            return $next($request);
        }
        return abort(404);
    }
}
