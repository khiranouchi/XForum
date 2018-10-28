<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumLoginController extends Controller
{
    use AuthenticatesUsers;

    protected function guard()
    {
        return Auth::guard('forum');
    }

    /**
     * Show the login form for the forum.
     *
     * @param Request $request
     * @param Forum $forum
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function showLoginForm(Request $request, Forum $forum)
    {
        return view('auth.forum_login', ['forum'=>$forum]);
    }

    /**
     * Authentication.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request)
    {
        Auth::guard('forum');
        
        $forum_id = $request->forum_id;
        $password = $request->password;
        
        if (Auth::guard('forum')->attempt(['id' => $forum_id, 'password' => $password])) {
            return redirect(session('redirect_to'));
        } else {
            return redirect()->route('forums.showLoginForm', ['id' => $forum_id]);
        }
    }
}