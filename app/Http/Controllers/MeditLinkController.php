<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeditLinkController extends Controller
{
    public function __construct()
    {

    }
    public function receiveData(Request $request)
    {
        $patientInfo = @$request->get('patientInfo');
        $caseUuid = @$request->get('caseUuid');
        // dd($request);
        if(!empty($caseUuid) && !empty($patientInfo)) {
            $patientInfo = json_decode($patientInfo);
            if($patientInfo->Name != "") {
                $ip = $request->ip();
                $patient = (object)[
                    "ip" => $ip,
                    "name" => $patientInfo->Name,
                    "dob" => $patientInfo->BirthDate,
                    "case_uuid" => $caseUuid,
                ];
                header('Content-Type: text/html; charset=UTF-8');
                session()->put("medit_pending_data", json_encode($patient, JSON_UNESCAPED_UNICODE));
                if(Auth::check()) {
                    if(Auth::user()->role == 'doctor') {
                        return redirect('/patient/create');
                    }
                    abort("404", "You need a doctor account in order to fetch this data.");
                }
                return redirect('/login');
            }
        }
        abort(404, "Invalid request");
    }
}
