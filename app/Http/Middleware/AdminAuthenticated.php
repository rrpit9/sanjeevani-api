<?php

namespace App\Http\Middleware;

use Exception;
use App\Models\UserRole;
use Closure,Auth,Session;
use Illuminate\Http\Request;

class AdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if($user && in_array(UserRole::ADMIN, explode(',', $user->user_role))){
            return $next($request);
        }
        throw new Exception(__('auth.middleware_unauthenticated'));
        // return back()->with('Errors','you are not authorise to perform the task');
    }
}
