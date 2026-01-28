<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Stripe\RequestTelemetry;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function view(Request $request)
    {
        $whereClauses = [
            ['u.id', '!=', Auth::user()->id],
        ];
        if (Auth::user()->role == 'rep') {
            array_push($whereClauses, ['u.role', 'doctor']);
            array_push($whereClauses, ['u.registered_by', Auth::user()->id]);
        }
        $role = @$request->get("role");
        if (Auth::user()->role == 'superadmin' && !empty($role)) {
            array_push($whereClauses, ['u.role', $role]);
        }
        $search = @$request->get('search');
        $users = DB::table('users as u')
            ->where($whereClauses)
            ->where('u.id', '!=', Auth::user()->id)
            ->leftJoin("tiers as t", function ($join) {
                $join->on("u.tier", "=", "t.id")
                    ->where("u.role", "doctor");
            })
            ->where(function ($query) use ($search) {
                if (!empty($search)) {
                    $query->where('u.first_name', 'like', '%' . $search . '%')
                        ->orWhere('u.last_name', 'like', '%' . $search . '%')
                        ->orWhere('u.email', 'like', '%' . $search . '%');
                }
            })
            ->select(
                "u.*",
                "t.tier_name",
                DB::raw("(CASE WHEN u.role='lab' THEN (SELECT COUNT(*) FROM lab_requests WHERE user_id = u.id) ELSE NULL END) as lab_request_count"),
                DB::raw("(CASE WHEN u.role='doctor' THEN (SELECT COUNT(*) FROM patients WHERE user_id = u.id AND is_deleted=0 AND first_name IS NOT NULL AND last_name IS NOT NULL AND dob IS NOT NULL) ELSE NULL END) as patient_count"),
                DB::raw("(CASE WHEN u.role='rep' THEN (SELECT COUNT(*) FROM users WHERE registered_by = u.id AND role='doctor') ELSE NULL END) as doctors_count"),

            )
            ->orderBy('id', 'desc')
            ->paginate(20);
        $users->appends([
            "search" => $search,
            "role" => $role,
        ]);
        return view("users.view_users", compact("users"));
    }
    public function add()
    {
        $tiers = DB::table('tiers')->orderBy('id', 'asc')->get();
        return view("users.add_user", compact("tiers"));
    }
    public function save(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            'email' => 'required | email | unique:users',
            'password' =>
            [
                'required',
                'min:6',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                //'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit

            ],
            'confirm_password' => 'required | same:password',
        ], [
            'password.regex' => 'Invalid password format. Must contain at least one lowercase letter and must contain at least one digit.',
        ]);
        if ($validated) {
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $email = $request->input('email');
            $password = $request->input('password');
            $phone_number = $request->input('phone_number');
            $billing_address = $request->input('billing_address');
            $shipping_address = $request->input('shipping_address');
            $role = $request->input('role');
            if (Auth::user()->role == 'rep') {
                $role = 'doctor';
            }
            $tier = 0;
            if($role == 'doctor'){
                $tier = @$request->input('tier') ? $request->input('tier') : 1;
            }
            $latest = DB::table('users')->insert([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'role' => $role,
                'email' => $email,
                'password' => Hash::make($password),
                'phone_number' => $phone_number,
                'billing_address' => $billing_address,
                "shipping_address" => $shipping_address,
                "registered_by" => Auth::user()->id,
                "tier" => $tier,
                 "advisor_price" => $request->input('advisor_price'),
            ]);
            return redirect('/users/view')->with('success', 'New User Registered.');
        }
        return \redirect()->back();
    }
    public function profile_settings()
    {
        $user = DB::table('users')->where('id', Auth::user()->id)->first();
        if (@$user) {
            return view("users.profile_settings", compact("user"));
        }
        return redirect()->back()->with('error', 'page not found.');
    }
    public function edit($id)
    {
        $user = DB::table('users')->where('id', $id)->where('role', '!=', 'admin')->first();
        if (@$user) {
            $tiers = DB::table('tiers')->orderBy('id', 'asc')->get();
            return view("users.edit_user", compact("user", "tiers"));
        }
        return redirect()->back()->with('error', 'page not found.');
    }
    public function post_profile(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id)
            ],
        ]);
        if ($validated) {
            $first_name = $request->input('first_name');
            $email = $request->input('email');
            $doctor_id = $request->input('doctor_id');
            $shining3d_org_name = $request->input('shining3d_org_name');
            DB::table('users')->where('id', $id)->update([
                'first_name' => $first_name,
                'last_name' => $request->input('last_name'),
                'email' => $email,
                'doctor_id' => $doctor_id,
                'shining3d_org_name' => $shining3d_org_name,
                'phone_number' => $request->input('phone_number'),
                "billing_address" => $request->input('billing_address'),
                "shipping_address" => $request->input('shipping_address')
            ]);
            if(Auth::user()->role == 'doctor') {
                foreach (DB::table('users')->where('role', 'staff')->pluck('id')->toArray() as $u) {
                    DB::table('notifications')->insert([
                        "type" => 'staff',
                        "title" => 'Doctor Profile Changed',
                        "body" => $first_name . ' ' . $request->input('last_name') . ' has updated his profile.',
                        "user_id" => $u,
                    ]);
                }
                foreach (DB::table('users')->whereIn('role', ['superadmin', 'admin'])->pluck('id')->toArray() as $u) {
                    DB::table('notifications')->insert([
                        "type" => 'admin',
                        "title" => 'Doctor Profile Changed',
                        "body" => $first_name . ' ' . $request->input('last_name') . ' has updated his profile.',
                        "user_id" => $u,
                    ]);
                }
            }
            // if (DB::table('users')->where('role', 'doctor')->where('id', $id)->exists()) {
            //     DB::table('users')->where('id', $id)->update([
            //         "tier" => $request->input('tier'),
            //     ]);
            // }
            return redirect('/profile-settings')->with('success', 'User Profile Updated');
        }
        return \redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'role' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id)
            ],
        ]);
        if ($validated) {
            $first_name = $request->input('first_name');
            $email = $request->input('email');
            DB::table('users')->where('id', $id)->update([
                'first_name' => $first_name,
                'last_name' => $request->input('last_name'),
                'email' => $email,
                'role' => $request->input('role'),
                'phone_number' => $request->input('phone_number'),
                "billing_address" => $request->input('billing_address'),
                "shipping_address" => $request->input('shipping_address'),
                "advisor_price" => $request->input('advisor_price')
            ]);
            if (DB::table('users')->where('role', 'doctor')->where('id', $id)->exists()) {
                DB::table('users')->where('id', $id)->update([
                    "tier" => @$request->input('tier') ? $request->input('tier') : 1,
                ]);
            }
            if (Auth::user()->role == 'superadmin') {
                DB::table('users')->where('id', $id)->update([
                    "login" => @$request->input('allow_login') ? 1 : 0,
                ]);
            }
            return redirect('/users/view')->with('success', 'User Profile Updated');
        }
        return \redirect()->back();
    }
    public function change_password(Request $request, $id)
    {
        $validated = $request->validate([
            'password' =>
            [
                'required',
                'min:6',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                //'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit

            ],
            'confirm_password' => 'required | same:password',
        ], [
            'password.regex' => 'Invalid password format. Must contain at least one lowercase letter and must contain at least one digit.',
        ]);
        if ($validated) {
            DB::table('users')->where('id', $id)->update([
                'password' => Hash::make($request->input('password')),
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            if (Auth::user()->role == 'superadmin') {
                return redirect('/users/view')->with('success', 'User password changed.');
            } else {
                return redirect()->back()->with('success', 'User password changed.');
            }
        }
        return \redirect()->back();
    }
    public function change_profile_photo(Request $request, $id)
    {
        $this->validate($request, [
            "file" => "required|file|mimes:jpg,jpeg,png,webp,gif",
        ]);
        if($request->hasFile("file")) {
            $file = $request->file('file');
            $fileName = mt_rand(1, 1000) . time() . '.' . $file->getClientOriginalExtension();
            $file->move(storage_path() . '/app/public/Profiles', $fileName);
            DB::table('users')->where('id', $id)->update([
                "photo" => $fileName,
            ]);
            return redirect()->back()->with('success', 'You have successfully changed your profile picture');
        }
        return redirect()->back()->with('error', 'enable to upload file');
    }
    public function delete($id)
    {
        $user = DB::table('users')->where('id', $id)->where('role', '!=', 'superamdin')->where('role', '!=', 'doctor')->first();
        if (@$user) {
            DB::table('users')->where('id', $id)->delete();
            Session::flash('success', 'User deleted!');
            return \redirect()->back();
        }
        Session::flash('error', 'User cannot be deleted!');
        return \redirect()->back();
    }
    public function update_fcm_token(Request $request)
    {
        $platform = $request->post("platform");
        $token = $request->post("device_token");
        if (!empty($platform) && !empty($token)) {
            DB::table('users')->where('id', Auth::user()->id)->update([
                "fcm_device_token" => $token,
                "fcm_platform" => $platform,
            ]);
        }
        return response()->json();
    }
}
