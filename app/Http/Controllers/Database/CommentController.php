<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Thread;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify.current.forum');
        $this->middleware('auth.forum');
        $this->middleware('verify.forum.inclusion');
        $this->middleware('verify.creator:comment')->except('store'); // user check for edit/update/delete
        $this->middleware('save.cookie.guest');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Forum $forum, Thread $thread)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Forum $forum, Thread $thread)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Forum $forum, Thread $thread)
    {
        $comment = new Comment;

        $comment->thread_id = $thread->id;
        $comment->title = $request->title;
        $comment->content = $request->content;
        if($request->user()) {
            $comment->creator_user_id = $request->user()->id;
        } else {
            $comment->creator_guest_id = $request->cookie(config('const.COOKIE_GUEST_ID_KEY'));
            $comment->creator_name = $request->creator_name;
        }

        $comment->save();

        return redirect(route('threads.show', ['forum' => $forum, 'thread' => $thread])."?scroll=".$request->scroll);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Forum $forum, Thread $thread, Comment $comment)
    {
        return view('forms.comment_form', [
            'forum' => $forum,
            'thread' => $thread,
            'comment' => $comment,
            'user' => $request->user(),
            'method' => 'PATCH',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum, Thread $thread, Comment $comment)
    {
        if ($request->isMethod('PATCH')) {
            foreach ($comment->getAllColumnNames() as $field) {
                if ($request->filled($field)) {
                    $comment->$field = $request->$field;
                }
            }
            $comment->save();
            return redirect(route('threads.show', ['forum' => $forum, 'thread' => $thread])."?scroll=".$request->scroll);
        }else{
            return abort(501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Forum $forum, Thread $thread, Comment $comment)
    {
        $comment->delete();
        return redirect(route('threads.show', ['forum' => $forum, 'thread' => $thread])."?scroll=".$request->scroll);
    }
}
