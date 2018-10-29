<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Forum;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle(Request $request, Closure $next)
    {
        $this->authenticate($request);
        
        return $next($request);
    }

    /**
     * Determine if the forum is logged in.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function authenticate(Request $request)
    {
        $forum = $request->route()->parameter('forum');

        $authed = 0;
        if($forum->password != NULL) {
            if (Auth::guard('forum')->check()) {
                if (Auth::guard('forum')->user()->id === $forum->id) {
                    $authed = 1;
                }
            }
            if($authed === 0){
                throw new AuthenticationException(
                    'Unauthenticated.', ['forum'], $this->redirectTo($request, $forum)
                );
            }
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo(Request $request, Forum $forum)
    {
        return route('forums.showLoginForm', ['forum' => $forum]);
    }
}
