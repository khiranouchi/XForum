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
        $this->middleware('verify.creator:forum')->except(['store', 'show', 'edit', 'update']); // user check for delete
        $this->middleware('save.cookie.guest');
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
        if($request->user()) {
            $forum->creator_user_id = $request->user()->id;
            if($request->filled('password')) {
                $forum->password = Hash::make($request->password);
            }
        } else {
            $forum->creator_guest_id = $request->cookie(config('const.COOKIE_GUEST_ID_KEY'));
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
            'user' => $request->user(),
            'guest_id' => $request->cookie(config('const.COOKIE_GUEST_ID_KEY'))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Forum $forum)
    {
        return view('forms.forum_form', [
            'forum' => $forum,
            'user' => $request->user(),
            'method' => 'PATCH'
        ]);
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
        if ($request->isMethod('PATCH')) {
            foreach ($forum->getAllColumnNames() as $field) {
                if ($request->filled($field)) {
                    if ($field === 'password') {
                        // verify (only logined creator can change password)
                        if ($forum->creator_user_id !== $request->user()->id) {
                            return abort(419);
                        }
                        $forum->password = Hash::make($request->password);
                    } else {
                        $forum->$field = $request->$field;
                    }
                }
            }
            $forum->save();
            return redirect()->route('forums.show', ['forum' => $forum]);
        }else{
            return abort(501);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function destroy(Forum $forum)
    {
        $forum->delete();
        return redirect()->route('top');
    }
}
