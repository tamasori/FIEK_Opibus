<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use User;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $menu)
    {
        $user = User::find(Auth::User()->id);
        if($user->CanAccessMenu($menu)){
            return $next($request);
        }
        return redirect('404');
    }
}
