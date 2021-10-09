<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginPage(Request $request)
    {
        // dd($request->message);
        if ($request->message) {
            return view('login')->with('message', $request->message);
        }
        return view('login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $user = User::where('uuid', $request->token)->first();
        $link = \Linkeys\UrlSigner\Models\Link::where('uuid', $request->token)->first();

        if ($link) {
            if ($user->login_status == 0) {
                if (Carbon::now()->gt($link->expiry)) {
                    $message = "Your link is expire. Please send email again.";
                    return redirect()->route('login.page', ['message' => $message]);
                } else {
                    $link->delete();
                    Auth::login($user);
                    $user->login_status = 1;
                    $user->save();
                    // dd(Auth::user());
                    return redirect()->route('home', ['token' => $request->token]);
                }
            } else {
                return redirect()->route('home', ['token' => $request->token]);
            }
        } else {
            $message = "You failed the authentication process.";
            return redirect()->route('login.page', ['message' => $message]);
        }
        // return redirect()->route('home', ['token' => $request->token]);
    }

    public function logout(Request $request)
    {
        $user = User::where('uuid',$request->token)->first();
        $user->login_status = 0;
        $user->save();
        Auth::logout();
        return redirect()->route('login.page');
    }
}
