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
            // set cookie everytime
            $uuid = Uuid::generate()->string;
            $minutes = 60 * 24 * 365 * 10; // 10 years
            $response->cookie(config('const.COOKIE_GUEST_ID_KEY'), $uuid, $minutes);
        }

        return $response;
    }
}
