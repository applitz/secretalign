<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Staff\PatientsService;
use App\Models\PatientTreatmentPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return view('staff.patients.index', compact('statusOptions', 'caseHolderOptions', 'doctors'));
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
}
