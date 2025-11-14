<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileSettings extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function profile_settings()
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();
        return view("users.edit_user", compact("user"));
    }
}
