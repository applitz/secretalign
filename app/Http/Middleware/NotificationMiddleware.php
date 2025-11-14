<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class NotificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $notifications = array();
            if (Auth::user()->role != 'staff') {
                $notifications = DB::table('notifications')
                    ->where('type', Auth::user()->role)
                    ->where('user_id', Auth::user()->id)
                    ->orderByDesc('id')
                    ->limit(10)
                    ->get();
            } else {
                $notifications = DB::table('notifications')
                    ->where('type', Auth::user()->role)
                    ->orderByDesc('id')
                    ->limit(10)
                    ->get();
            }
            View::share('notifications', $notifications);
        }

        return $next($request);
    }
}
