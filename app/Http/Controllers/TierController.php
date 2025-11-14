<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'auth.superadmin']);
    }
    public function view_tiers()
    {
        $tiers = DB::table('tiers')->orderBy('id', 'asc')->get();
        return view("settings.tiers.tier_prices", compact("tiers"));
    }
    public function change_jaw_price(Request $request)
    {
        $tier = $request->post('tier');
        $jaw = $request->post('jaw');
        $price = $request->post('price');
        if($price > 0)
        {
            DB::table('tiers')->where('id', $tier)->update([
                $jaw => intval($price),
            ]);
            return response()->json(["status" => 200]);
        }
        return response()->json(["status" => 400]);
    }
}
