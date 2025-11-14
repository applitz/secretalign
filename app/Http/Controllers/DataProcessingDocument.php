<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DataProcessingDocument extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function sign_document()
    {
        if(Auth::user()->role == 'doctor') {
            return view("users.data_processing_document");
        }
        abort(403, "unauthorized request");
    }
    public function view_data_processing_document($id)
    {
       if(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') {
            $doctor = DB::table('users')->where('role', 'doctor')->where('id', $id)->first();
            if(@$doctor) {
                return view("users.data_processing_document", compact('doctor'));
            }
            abort(404, "page not found");
       }
       abort(403, "unauthorized request");
    }
    public function post_sign_document(Request $request)
    {
        if(Auth::user()->role == 'doctor') {
            if(@$request->input('signatures')) {
                DB::table('users')->where('id', Auth::user()->id)->update([
                    "data_processing_document_signatures" => $request->input('signatures'),
                ]);
                return response()->json(["status" => 200]);
            }
        }
        return response()->json(["status" => 400]);
    }
    public function view_data_processing_documents(Request $request)
    {
        if(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin') {
            $search = @$request->get('search');
            $doctors = DB::table('users')->where(function ($query) use ($search) {
                $query->where('role', 'doctor');
                if($search != "") {
                    $query->where('first_name', 'LIKE', '%'. $search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
                }
            })->orderBy('id', 'desc')->paginate(20);
            return view("users.view_doctors", compact("doctors"));
        }
        abort(403, "unauthorized request");
    }
}
