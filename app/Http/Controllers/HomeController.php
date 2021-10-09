<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        // $link = \Linkeys\UrlSigner\Models\Link::where('uuid', $request->input('token'))->first();
        // if ($link) {
        //     if (Carbon::now()->gt($link->expiry)) {
        //         $message = "Your link is expire. Please send email again.";
        //         return redirect()->route('login.page', ['message' => $message]);
        //     } else {
        //         // $link->delete();
        //         return view('home');
        //     }
        // } else {
        //     $message = "You failed the authentication process.";
        //     return redirect()->route('login.page', ['message' => $message]);
        // }

        return view('user-view',['token' => $request->token]);
    }
}
