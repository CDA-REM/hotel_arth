<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;



class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     * @throws Exception
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if($request->user()->user_role == $role) {

            return $next($request);
        }else{
//            throw new Exception('Impossible');
            abort(401);

        }
    }
}
