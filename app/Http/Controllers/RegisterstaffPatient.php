<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Http\Services\TaskService;
use App\Http\Services\NemoTechService;
use App\Jobs\SubmitCaseMailJob;
use App\Jobs\SubmitCaseMailStaffJob;
use App\Models\DoctorClinicalPreference;
use Illuminate\Support\Facades\View;
use Hashids\Hashids;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\MeditLink;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Audittrails;
use App\Models\PatientTreatmentPlan;
class RegisterstaffPatient extends Controller
{


    public function checkMovixScanStatus (Request $request){
        $getmovixScanStatus = PatientTreatmentPlan::where('id', $request->treatment_plan_id)
                                ->where('patient_id', $request->patient_id)
                                ->select('primary_case_movix_status', 'optional_scan_case_movix_status')
                                ->first();
        if($getmovixScanStatus){
            if($getmovixScanStatus->primary_case_movix_status == 1 || $getmovixScanStatus->optional_scan_case_movix_status == 1){
                return response()->json(['status' => 'error', 'message' => 'Please upload the Movix Scan link.']);
            }
            return response()->json(['status' => 'success', 'data' => $getmovixScanStatus]);
        }

        return response()->json(['status' => 'success', 'data' => $getmovixScanStatus]);
    }



}
