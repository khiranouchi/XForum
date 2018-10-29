<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ForumController extends Controller
{
    public function __construct()
    {
        $this->middleware('verify.current.forum')->except(['store', 'show']);
        $this->middleware('auth.forum')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(404);
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
    public function store(Request $request)
    {
        $forum = new Forum;

        $forum->title = $request->title;
        $forum->description = $request->description;
        if($request->filled('password')) {
            $forum->password = Hash::make($request->password);
        }
        if($request->user()) {
            $forum->creator_user_id = $request->user()->id;
        }

        $forum->save();

        return redirect()->route('forums.show', ['id' => $forum]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Forum $forum)
    {
        // put forum_id in session
        session(['forum_id' => $forum->id]);

        // get lines of Thread (ordered by updated_at)
        $ln_threads = Thread::where('forum_id', $forum->id)->orderBy('updated_at', 'desc');
        $threads = $ln_threads->get();

        return view('forum', [
            'forum' => $forum,
            'threads' => $threads,
            'user' => $request->user()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit(Forum $forum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forum $forum)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        //
    }
}
