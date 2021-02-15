<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$rolesPermitidos)
    {
        $payload = Auth::payload();
        $userRoles = $payload['roles'];
        if(!($this->checkRole($rolesPermitidos, $userRoles)))
           return response('Unauthorized.', 401);

        return $next($request);
    }
    private function checkRole($rolesPermitidos, $userRoles){
        foreach($userRoles as $userRole){
            if(in_array($userRole, $rolesPermitidos)){
                return true;
            }
        }
        return false;
    }
}
