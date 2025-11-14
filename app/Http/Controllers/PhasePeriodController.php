<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;

class PhasePeriodController extends Controller
{
    public $hashids;
    public function __construct()
    {
        $this->middleware(['auth', 'auth.superadmin']);
        $this->hashids = new Hashids();
        View::share("hashids", $this->hashids);
    }
    public function form(Request $request)
    {
        $settings = DB::table('settings')->where('type', 'period')->first();
        return view("settings.phase_period", compact("settings"));
    }
    public function post(Request $request)
    {
        $validated = $request->validate([
            "period_duration" => 'required',
        ]);
        if ($validated) {
            if (!DB::table('settings')->where('type', 'period')->exists()) {
                DB::table('settings')->insert([
                    "type" => "period",
                    "user_id" => Auth::user()->id,
                    "payload" => $request->input("period_duration"),
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            } else {
                DB::table('settings')->where('type', 'period')->update([
                    "payload" => $request->input('period_duration'),
                    "updated_at" => date("Y-m-d H:i:s"),
                ]);
            }
            return \redirect()->back()->with('success', "Period Duration Changed");
        }
        return redirect()->back();
    }
}
