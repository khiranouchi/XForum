<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class SaveCookieGuestId
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
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (!$request->user()) {
            $guest_id = $request->cookie(config('const.COOKIE_GUEST_ID_KEY'));

            // if cookie 'guest_id' does not exist in the client request
            if (!$guest_id) {
                // set cookie
                $uuid = Uuid::generate()->string;
                $response->cookie(config('const.COOKIE_GUEST_ID_KEY'), $uuid);
            }
        }

        return $response;
    }
}
