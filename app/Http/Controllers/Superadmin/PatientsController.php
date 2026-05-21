<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Superadmin\PatientsService;
use App\Models\PatientTreatmentPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Patients;
use Illuminate\Support\Facades\Hash;

class PatientsController extends Controller
{
    protected $patientsService;

    public function __construct(PatientsService $patientsService)
    {
        $this->patientsService = $patientsService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->patientsService->getPatients($request);
        }
        $statusOptions = PatientTreatmentPlan::where('is_deleted', 0)
                        ->distinct()
                        ->pluck('status');
        $caseHolderOptions = PatientTreatmentPlan::where('is_deleted', 0)
                        ->distinct()
                        ->pluck('case_holder');
        $doctors =  DB::table('users as u')
            ->where(function ($query) {
                if(Auth::user()->role == 'rep') {
                    $query->where('u.registered_by', Auth::user()->id);
                }
            })
            ->select(
                'u.id',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_full_name")
            )
            ->where('role', 'doctor')
            ->orderBy('user_full_name', 'asc')
            ->get();
        return view('superadmin.patients.index', compact('statusOptions', 'caseHolderOptions', 'doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeExpiryDate(Request $request)
    {
        // ✅ Check password with logged-in user
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password'
            ], 422);
        }
        return $this->patientsService->changeExpiryDate($request);
    }

    public function updateExpiryDate()
    {
        $allshipedRecords = Patients::from('patients as p')
                ->join('p_treatment_plans as tp', 'p.id', '=', 'tp.patient_id')
                ->where('p.is_deleted', 0)
                ->where('tp.status', 'Shipped')
                ->where('tp.shipping_date_time', '!=', null)
                ->select('p.id', 'p.first_name', 'p.last_name', 'tp.status', 'tp.id as treatment_plan_id', 'tp.shipping_date_time', 'p.pricing_package', 'tp.aligner_steps')
                ->get();

        foreach($allshipedRecords as $key => $record){
            if ($record->pricing_package == 'AL-SECRET-SELECT') {
                $aligner_steps = $record->aligner_steps;
                $addOnweeks = 2*$aligner_steps;
                $planExprieyDate = date('Y-m-d', strtotime($record->shipping_date_time . ' + '.$addOnweeks.' weeks'));
                if($aligner_steps > 0 && $aligner_steps <= 20) {
                    $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 3 months'));
                } else {
                    $planExprieyDate = date('Y-m-d', strtotime($planExprieyDate . ' + 6 months'));
                }
            } else {
                $planExprieyDate = date('Y-m-d', strtotime($record->shipping_date_time . ' + 3 years'));
            }

            $obj = PatientTreatmentPlan::find($record->treatment_plan_id);
            $obj->expiry_date = date('Y-m-d', strtotime($planExprieyDate));
            $obj->save();
        }
    }

    public function changePatientStatus(Request $request)
    {
        // ✅ Check password with logged-in user
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password'
            ], 422);
        }
        return $this->patientsService->changePatientStatus($request);
    }
    public function changeCaseHolder(Request $request)
    {
        // ✅ Check password with logged-in user
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password'
            ], 422);
        }
        return $this->patientsService->changeCaseHolder($request);
    }

    public function changeTreatmentPlan(Request $request)
    {
        // ✅ Check password with logged-in user
        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect password'
            ], 422);
        }
        return $this->patientsService->changeTreatmentPlan($request);
    }
}
