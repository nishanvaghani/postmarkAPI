<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('uuid', $request->token)->first();
        if ($user->login_status == 0) {
            return redirect()->route('login.page');
        } elseif ($user->login_status == 1) {
            if ($user->uuid == $request->token) {
                return $next($request);
            } else {
                redirect()->route('login.page');
            }
        }
    }
}
