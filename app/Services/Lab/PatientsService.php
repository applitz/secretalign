<?php

namespace App\Services\Lab;

use App\Services\CommonFunction;
use App\Models\Patients;
use App\Models\Patients_treatment_plans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Hashids\Hashids;

class PatientsService extends CommonFunction
{
    public function getPatients($request)
    {
        $filters = $this->DTFilters($request->all());
        $offset = $filters['offset'] ?? 0;
        $limit = $filters['limit'] ?? 10;

        $query = DB::table('patients as p')
                ->where('p.is_deleted', 0)
                ->whereNotNull('p.first_name')
                ->join('p_treatment_plans as tp', function ($join) {
                    $join->on('p.id', '=', 'tp.patient_id')
                        ->where('tp.is_deleted', 0)
                        ->whereRaw('tp.id =
                                  (select max(id) from p_treatment_plans
                                   where patient_id = p.id)');
                    $join->where("tp.lab", Auth::user()->id);
                })
                ->Join("users as u", function ($join) {
                    $join->on("u.id", "=", "p.user_id");
                })
                ->leftJoin("users as l", function ($join) {
                    $join->on("tp.lab", "=", "l.id")
                        ->where("l.role", "lab");
                });
        // Date range
        $date = $request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                [$start, $end] = explode('to', $date);
                $query->where('p.created_at', '>=', date('Y-m-d', strtotime(trim($start))) . ' 00:00:00');
                $query->where('p.created_at', '<=', date('Y-m-d', strtotime(trim($end))) . ' 23:59:59');
            } else {
                $query->where('p.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00');
                $query->where('p.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59');
            }
        }


        // Status
        $status = $request->get('status');
        if (!empty($status)) {
            if (strpos($status, "Continuing Treatment") !== false) {
                $query->where('tp.is_continue', true);
            } else {
                $query->where('tp.status', $status);
            }
        }

        // Case Holder
        $case_holder = $request->get('case_holder');
        if (!empty($case_holder)) {
            if (strpos($case_holder, "lab") !== false) {
                $query->where('tp.case_holder', 'lab');
            } elseif (strpos($case_holder, "staff") !== false) {
                $query->where('tp.case_holder', 'staff');
            } else {
                $query->where('tp.case_holder', 'doctor');
            }
        }

        // search
        $ft_search = $request->get('ft_search');
        // Search
        if (!empty($ft_search)) {
            $hashids = new Hashids();
            $decoded = $hashids->decode($ft_search);
            $query->where(function ($q) use ($ft_search, $decoded) {
                if (count($decoded)) {
                    $q->where('p.id', $decoded[0]);
                } else {
                    $q->where('p.dob', 'like', "%{$ft_search}%")
                        ->orWhere('p.first_name', 'like', "%{$ft_search}%")
                        ->orWhere('p.last_name', 'like', "%{$ft_search}%");
                }
            });
        }
        // Total count before pagination
        $total = $query->count();

        // Fetch paginated results
        $patientsLists = $query
            ->select(
                'p.*',
                'tp.id as treatment_plan',
                'tp.status',
                'tp.phase',
                'tp.treatment_type',
                'tp.is_submitted',
                'tp.case_holder',
                'tp.is_completed',
                'tp.completed_at',
                'tp.treatment_plan_duration',
                'tp.cancellation_date',
                'tp.setup_approval_date',
                'tp.recommended_advisor',

            )
            ->orderBy('tp.id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $hashids = new Hashids();


        $records = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => [],
        ];
        $hashids = new Hashids();
        foreach ($patientsLists as $patient) {

            if ($patient->case_holder === 'lab') {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Lab</span>';
            } elseif ($patient->case_holder === 'staff') {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger">Staff</span>';
            } else {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-info">Doctor</span>';
            }

            $records['data'][] = [

                'patientId' => $hashids->encode($patient->id),
                'last_name' => $patient->last_name,
                'first_name' => $patient->first_name,
                'dob' => date_formate($patient->dob),
                'treatment_type' => $patient->treatment_type == '2' ? '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger"> Aligners Full-Service </span>' : '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Treatment Planning Service</span>',
                'package' => '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">' . ($patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'Confidence' : 'Select') . '</span>',
                'status' => '<span class="badge fw-semi-bold rounded-pill status ' . (getPatientTreatmentPlanStatus($patient->status)) . '">'
                    . ($patient->status == "Waiting for Review from Advisor" ? "Waiting Advisor's Review" : ucfirst($patient->status))
                    . '</span>',
                'due_date' => checkForRequestNewPlanExpriyDate($patient->id),
                'setup_approval_date' => $patient->setup_approval_date ? date_formate($patient->setup_approval_date) : '',
                'case_overview' => '<a class="badge  badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none" href="' . url('/patient/case-overview/' . $hashids->encode($patient->treatment_plan)) . '"
                                data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Case Overview</a>',
                'case_holder' => $case_holder,
            ];
        }

        return $records;
    }
}
