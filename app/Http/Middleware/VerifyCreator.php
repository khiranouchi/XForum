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

        /*
         * current check
         *  "current user" must be logined user
         *  "creator user" must be logined user
         *  "current user" === "creator user"
         */ 
        if (!$request->user() or !$obj->creator_user_id or $request->user()->id !== $obj->creator_user_id) {
            return abort(419);
        }

        return $next($request);
    }
}
