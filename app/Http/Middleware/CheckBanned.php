<?php

namespace App\Http\Middleware;

use Closure;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user && $user->is_banned) {

            //Logout
            auth()->logout();

            return $request->expectsJson()
                    ? abort(403, __('auth.banned'))
                    : redirect(url('/login'))->with([
                        'error' => [
                            'message' =>  __('auth.banned'),
                            'name' => $user->name,
                            'avatar' => $user->avatar_url,
                        ]
                    ]);;
        }
        return $next($request);
    }
}
