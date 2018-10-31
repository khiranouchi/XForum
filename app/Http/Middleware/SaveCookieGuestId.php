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

        // if not logined
        if (!$request->user()) {
            $guest_id = $request->cookie(config('const.COOKIE_GUEST_ID_KEY'));
            $minutes = 60 * 24 * 365 * 10; // 10 years
            if ($guest_id) {
                // extend cookie lifetime
                $response->cookie(config('const.COOKIE_GUEST_ID_KEY'), $guest_id, $minutes);
            } else {
                // set cookie
                $uuid = Uuid::generate()->string;
                $response->cookie(config('const.COOKIE_GUEST_ID_KEY'), $uuid, $minutes);
            }
        }

        return $response;
    }
}
