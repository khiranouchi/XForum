<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyForumInclusion
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
        $forum = $request->route()->parameter('forum');
        $thread = $request->route()->parameter('thread');

        // check if the thread is in the forum
        if ($thread->forum_id !== $forum->id) {
            abort(404);
        }
        
        $comment = $request->route()->parameter('comment');
        if ($comment) {
            // check if the comment is in the thread
            if ($comment->thread_id !== $thread->id) {
                abort(404);
            }

            $reply = $request->route()->parameter('reply');
            if ($reply) {
                // check if the reply is in the comment
                if ($reply->comment_id !== $comment->id) {
                    abort(404);
                }
            }
        }

        return $next($request);
    }
}
