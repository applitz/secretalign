<?php

namespace App\Services;

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

        $search = $filters['search'] ?? '';
        $offset = $filters['offset'] ?? 0;
        $limit = $filters['limit'] ?? 10;

        $query = DB::table('patients as p')
            ->where('p.is_deleted', 0)
            ->where('p.user_id', Auth::id())
            ->leftJoin('p_treatment_plans as tp', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('tp.is_deleted', 0)
                    ->whereRaw('tp.id = (
                    SELECT MAX(id) FROM p_treatment_plans
                    WHERE patient_id = p.id AND is_deleted = 0
                )');
            })
            ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
            ->leftJoin('users as l', function ($join) {
                $join->on('tp.lab', '=', 'l.id')->where('l.role', 'lab');
            });

        // Search
        if (!empty($search)) {
            $hashids = new Hashids();
            $decoded = $hashids->decode($search);
            $query->where(function ($q) use ($search, $decoded) {
                if (count($decoded)) {
                    $q->where('p.id', $decoded[0]);
                } else {
                    $q->where('p.dob', 'like', "%{$search}%")
                        ->orWhere('p.first_name', 'like', "%{$search}%")
                        ->orWhere('p.last_name', 'like', "%{$search}%");
                }
            });
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

        // Status
        $status = $request->get('status');
        if (!empty($status)) {
            if (strpos($status, "Continuing Treatment") !== false) {
                $query->where('tp.is_continue', true);
            } else {
                $query->where('tp.status', $status);
            }
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
        // Date range
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
                'tp.treatment_type',
                'tp.phase',
                'tp.aligner_steps',
                'tp.is_submitted',
                'tp.case_holder',
                'tp.is_completed',
                'tp.completed_at',
                'tp.treatment_plan_duration',
                'tp.cancellation_date',
                'tp.setup_approval_date',
                'tp.recommended_advisor',
                'u.first_name as d_first_name',
                'u.last_name as d_last_name',
                'l.first_name as lab_first_name',
                'l.last_name as lab_last_name'
            )
            ->orderBy('tp.id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $hashids = new Hashids();
        $sr_no = $offset + 1;

        $records = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => [],
        ];

        foreach ($patientsLists as $patient) {
            $loopIndex = $sr_no;
            // Continue Treatment logic
            $canContinueStatuses = ['Treatment Plan Completed', 'Shipped', 'Production'];
            $continueTreatment = '<div class="text-end dropdown font-sans-serif btn-reveal-trigger">N/A</div>';
            if ($patient->case_holder === 'lab') {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Lab</span>';
            } elseif ($patient->case_holder === 'staff') {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger">Staff</span>';
            } else {
                $case_holder = '<span class="badge fw-semi-bold rounded-pill status badge-soft-info">Doctor</span>';
            }
            if (in_array($patient->status, $canContinueStatuses)) {
                $continueTreatment = '<div class="text-end dropdown font-sans-serif btn-reveal-trigger">
                <form method="POST" action="' . url('/patient/treatment-plan/continue') . '" id="continue-plan-' . $patient->id . '">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input name="patient_id" value="' . $patient->id . '" type="hidden">
                </form>
                <a class="badge  badge-soft-danger text-600 btn-sm btn-reveal-sm transition-none continue-treatment"
                href="javascript:void(0);" data-first_name="' . ($patient->first_name) . '" data-last_name="' . ($patient->last_name) . '" data-loop_index="' . ($patient->id) . '"
                data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                Continue Treatment
                </a>
            </div>';
            }

            if ($patient->request_new_scan == 1) {

                $caseOverview = '<div class="font-sans-serif btn-reveal-trigger"><a class="badge badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none"
                            href="'. route('patient.upload-new-scan', $hashids->encode($patient->treatment_plan)) .'" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            Case Overview</a></div>';
            } else {
                $caseOverview = '<div class="font-sans-serif btn-reveal-trigger"><a class="badge badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none"
                            href="'. route('patient.case-overview', $hashids->encode($patient->treatment_plan)) .'" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            Case Overview</a></div>';
            }

            $records['data'][] = [

                'id' => $patient->treatment_plan,
                'patientId' => $hashids->encode($patient->id),
                'last_name' => $patient->last_name,
                'first_name' => $patient->first_name,
                'dob' => date_formate($patient->dob),
                'package' => '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">' . ($patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'Confidence' : 'Select') . '</span>',
                'status' => '<span class="badge fw-semi-bold rounded-pill status ' . (getPatientTreatmentPlanStatus($patient->status)) . '">'
                    . ($patient->status == "Waiting for Review from Advisor" ? "Waiting Advisor's Review" : ucfirst($patient->status))
                    . '</span>',
                'due_date' => checkForRequestNewPlanExpriyDate($patient->id),
                'treatment_type' => $patient->treatment_type == '2' ? '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger"> Aligners Full-Service </span>' : '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Treatment Planning Service</span>',
                'setup_type' => $patient->setup_type == '1'
                                ? '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger">Final Setup with individual staging</span>'
                                : ($patient->setup_type == '2'
                                    ? '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Quick Setup</span>'
                                    : ''),
                'setup_approval_date' => $patient->setup_approval_date ? date_formate($patient->setup_approval_date) : '',
                'case_overview' => $caseOverview,
                'continue_treatment' => $continueTreatment,
                'case_holder' => $case_holder,
                'request_new_plan' => ($patient->status == 'Shipped' && checkForRequestNewPlan($patient->id))
                    ? '<form method="POST" action="' . url('/patient/treatment-plan/request') . '" id="request-plan-' . $patient->id . '">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <input name="patient_id" value="' . $patient->id . '" type="hidden">
                                    </form>
                                    <a class="badge  badge-soft-info text-600 btn-sm btn-reveal-sm transition-none request-new-plan"
                                        href="javascript:void(0);"
                                        data-first_name="' . htmlspecialchars($patient->first_name) . '"
                                        data-last_name="' . htmlspecialchars($patient->last_name) . '"
                                        data-loop_index="' . $patient->id . '"
                                        data-aligner_steps="' . $patient->aligner_steps . '"
                                        data-boundary="viewport"
                                        aria-haspopup="true"
                                        aria-expanded="false">
                                        Request Plan ' . ($patient->phase + 1) . '
                                    </a>'
                    : 'N/A',


            ];
        }

        return $records;
    }
}
