<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyCreator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $target_parameter  'comment' or 'reply'
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next, $target_parameter)
    {
        $obj = $request->route()->parameter($target_parameter);

        // when current user is logined
        if ($request->user()) {
            // if (creator exists) and (current user is creator)
            if ($obj->creator_user_id === $request->user()->id) {
                return $next($request);
            }
        }
        // when guest (including when current user is logined)
        if ($request->cookie(config('const.COOKIE_GUEST_ID_KEY'))) {
            // if "creator guest exists" and "current guest is creator"
            if ($obj->creator_guest_id === $request->cookie(config('const.COOKIE_GUEST_ID_KEY'))) {
                return $next($request);
            }
        }

        return abort(419);
    }
}
