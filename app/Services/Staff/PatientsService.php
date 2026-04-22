<?php

namespace App\Services\Staff;

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

            ->leftJoin('p_treatment_plans as tp', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('tp.is_deleted', 0)
                    ->whereRaw('tp.id = (
                    SELECT MAX(id) FROM p_treatment_plans
                    WHERE patient_id = p.id AND is_deleted = 0
                )');
            })
            ->join("users as u", function ($join) {
                $join->on("u.id", "=", "p.user_id");
            })
            ->leftJoin("users as l", function ($join) {
                $join->on("tp.lab", "=", "l.id")
                    ->where("l.role", "lab");
            })
            ->leftJoin('treatment_checks as tc', function ($join) {
                $join->on('tc.patient_id', '=', 'tp.id');
            });

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

        // Status
        $status = $request->get('status');
        if (!empty($status)) {
            if (strpos($status, "Continuing Treatment") !== false) {
                $query->where('tp.is_continue', true);
            } else {
                $query->where('tp.status', $status);
            }
        }

        // doctor
        $ft_doctor = $request->get('ft_doctor');
        if (!empty($ft_doctor)) {
            $query->where('p.user_id', $ft_doctor);
        }

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
                'tc.id as treatment_checklist',
                // 'u.first_name as d_first_name',
                // 'u.last_name as d_last_name',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_full_name"),
                'u.postal_code',
                'u.city',
                'u.country',
                'l.first_name as lab_first_name',
                'l.last_name as lab_last_name'
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
            if ($patient->recommended_advisor) {
                $advisor = '<div class="dropdown font-sans-serif btn-reveal-trigger">
                    <a class="btn btn-danger text-600 btn-sm btn-reveal-sm transition-none"
                        href="' . url('/patient/case-overview/' . $hashids->encode($patient->treatment_plan)) . '"
                        data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                        Requested for Advisor
                    </a>
                </div>';
            } else {
                $advisor = 'N/A';
            }

            if ($patient->case_holder === 'lab') {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Lab</span>';
            } elseif ($patient->case_holder === 'staff') {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger">Staff</span>';
            } else {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-info">Doctor</span>';
            }

            $records['data'][] = [

                'patientId' => $hashids->encode($patient->id),
                'doctor' => $patient->user_full_name. " - " . $patient->city  ." " . $patient->country. " " .  $patient->postal_code ,
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
                'advisor' => $advisor,
                'case_overview' => '<a class="badge  badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none" href="' . url('/patient/case-overview/' . $hashids->encode($patient->treatment_plan)) . '"
                                data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Case Overview</a>',
                'case_holder' => $case_holder,
                'treatment_checklist' => $patient->treatment_checklist ? '<a class="badge  badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none" href="' . url('/staff/treatment/preview/' . $hashids->encode($patient->treatment_checklist)) . '"
                                data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Checklist Preview</a>' : "NA",
            ];
        }

        return $records;
    }
}
