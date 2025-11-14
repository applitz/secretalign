<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class NotificationController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware('auth');
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function check(Request $request)
    {
        // if ($request->input('type') != 'fetch-api') {
        //     return redirect('/home');
        // }
        $notifications = DB::table('notifications')
            ->where('type', Auth::user()->role)
            ->where('user_id', Auth::user()->id)
            ->whereNull("read_at")
            ->orderByDesc('id')
            ->limit(10)
            ->get();
        $count = DB::table('notifications')
            ->where('type', Auth::user()->role)
            ->where('user_id', Auth::user()->id)
            ->whereNull("read_at")
            ->count();
        return view("layouts.notifications", compact("notifications", "count"))->render();
    }
    public function view(Request $request)
    {
        $read = @$request->get('read');
        if($read != "") {
            DB::table('notifications')->where('id', $read)->update([
                "read_at" => date("Y-m-d H:i:s"),
            ]);
        }
        $notifications = DB::table('notifications')
            ->where('type', Auth::user()->role)
            ->where('user_id', Auth::user()->id)
            ->orderByDesc('id')
            ->paginate(20);
        return view("users.view_notifications", compact("notifications"));
    }
    public function read_all(Request $request)
    {

        if (Auth::check()) {
            DB::table('notifications')
                ->where('type', Auth::user()->role)
                ->where('user_id', Auth::user()->id)
                ->whereNull('read_at')
                ->update([
                    'read_at' => \Carbon\Carbon::now(),
                ]);
        }

        return redirect()->back();
    }
}
