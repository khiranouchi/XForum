<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify.current.forum');
        $this->middleware('auth.forum');
        $this->middleware('verify.forum.inclusion');
        $this->middleware('verify.creator:reply')->except('store'); // user check for edit/update/delete
        $this->middleware('save.cookie.guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Forum $forum, Thread $thread, Comment $comment)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Forum $forum, Thread $thread, Comment $comment)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Forum $forum, Thread $thread, Comment $comment)
    {
        $reply = new Reply;

        $reply->comment_id = $comment->id;
        $reply->content = $request->content;
        if($request->user()) {
            $reply->creator_user_id = $request->user()->id;
        } else {
            $reply->creator_guest_id = $request->cookie(config('const.COOKIE_GUEST_ID_KEY'));
            $reply->creator_name = $request->creator_name;
        }

        $reply->save();

        return redirect(route('threads.show', ['forum' => $forum, 'thread' => $thread])."?scroll=".$request->scroll);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum, Thread $thread, Comment $comment, Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Forum $forum, Thread $thread, Comment $comment, Reply $reply)
    {
        return view('forms.reply_form', [
            'forum' => $forum,
            'thread' => $thread,
            'comment' => $comment,
            'reply' => $reply,
            'user' => $request->user(),
            'method' => 'PATCH',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum, Thread $thread, Comment $comment, Reply $reply)
    {
        if ($request->isMethod('PATCH')) {
            foreach ($reply->getAllColumnNames() as $field) {
                if ($request->filled($field)) {
                    $reply->$field = $request->$field;
                }
            }
            $reply->save();
            return redirect(route('threads.show', ['forum' => $forum, 'thread' => $thread])."?scroll=".$request->scroll);
        }else{
            return abort(501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Forum $forum, Thread $thread, Comment $comment, Reply $reply)
    {
        $reply->delete();
        return redirect(route('threads.show', ['forum' => $forum, 'thread' => $thread])."?scroll=".$request->scroll);
    }
}
