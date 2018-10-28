<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Forum;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.forum');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Forum $forum)
    {
        $thread = new Thread;

        // verify forum_id with one in session
        if ($forum->id !== session('forum_id')) {
            return abort(419);
        }
        $thread->forum_id = $forum->id;

        $thread->title = $request->title;
        $thread->description = $request->description;
        if($request->user()) {
            $thread->creator_user_id = $request->user()->id;
        } else {
            $thread->creator_name = $request->creator_name;
        }

        $thread->save();

        return redirect()->route('threads.show', ['forum' => $forum, 'thread' => $thread]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum, Thread $thread)
    {
        // verify the specified thread is in the specified forum
        if ($thread->forum_id !== $forum->id) {
            abort(404);
        }

        // put forum_id in session
        session(['forum_id' => $forum->id]);

        // get lines of Comment (ordered by updated_at)
        $ln_comments = Comment::where('thread_id', $thread->id)->orderBy('updated_at', 'desc');
        $comments = $ln_comments->get();




        return view('thread', [
            'forum' => $forum,
            'thread' => $thread,

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum, Thread $thread)
    {
        //
    }
}
