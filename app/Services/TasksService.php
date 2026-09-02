<?php

namespace App\Services;

use App\Services\CommonFunction;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Hashids\Hashids;
class TasksService extends CommonFunction
{

    public function getTasks($request)
    {
        $filters = $this->DTFilters($request->all());
        $user = Auth::user();
        $search = $filters['search'] ?? '';
        $offset = $filters['offset'] ?? 0;
        $limit = $filters['limit'] ?? 10;

        // Prepare base where conditions
        $whereClauses = [
            ['t.status', '!=', 'completed'],
            ['t.type', '=', $user->role],
        ];

        // If user is doctor, lab, or advisor, limit tasks to their own
        if (in_array($user->role, ['doctor', 'lab', 'advisor'])) {
            $whereClauses[] = ['t.user_id', '=', $user->id];
        }

        // Build the query
        $query = DB::table('tasks as t')
            ->join('p_treatment_plans as tp', function ($join) {
                $join->on('t.treatment_plan_id', '=', 'tp.id')
                    ->where('tp.is_deleted', '=', 0);
            })
            ->join('patients as p', function ($join) {
                $join->on('p.id', '=', 'tp.patient_id')
                    ->where('p.is_deleted', '=', 0);
            })
            ->join('users as u', 'u.id', '=', 'p.user_id')
            ->where($whereClauses);

        // statuPlan
        $statuPlan = $request->get('statuPlan');
        if (!empty($statuPlan)) {
            $query->where('tp.phase', $statuPlan);
        }

        // Status
        $status = $request->get('status');
        if (!empty($status)) {
            $query->where('t.task', $status);
        }
        // Date range
        $date = $request->get('date');
        if (!empty($date)) {
            if (str_contains($date, 'to')) {
                [$start, $end] = explode('to', $date);
                $query->where('t.created_at', '>=', date('Y-m-d', strtotime(trim($start))) . ' 00:00:00');
                $query->where('t.created_at', '<=', date('Y-m-d', strtotime(trim($end))) . ' 23:59:59');
            } else {
                $query->where('t.created_at', '>=', date('Y-m-d', strtotime($date)) . ' 00:00:00');
                $query->where('t.created_at', '<=', date('Y-m-d', strtotime($date)) . ' 23:59:59');
            }
        }
        // Date range
        $ft_search = $request->get('ft_search');
        // Search
        if (!empty($ft_search)) {
            $ft_search = strtolower($ft_search);

            $query->where(function ($q) use ($ft_search, $user) {
                // General search (case-insensitive)
                $q->whereRaw('LOWER(t.task) LIKE ?', ["%{$ft_search}%"])
                    ->orWhereRaw('LOWER(p.first_name) LIKE ?', ["%{$ft_search}%"])
                    ->orWhereRaw('LOWER(p.last_name) LIKE ?', ["%{$ft_search}%"])
                    ->orWhereRaw("LOWER(CONCAT(p.first_name, ' ', p.last_name)) LIKE ?", ["%{$ft_search}%"]);

                // Staff-specific: search by case holder (user full name)
                if ($user->role == 'staff') {
                    $q->orWhereRaw('LOWER(u.first_name) LIKE ?', ["%{$ft_search}%"])
                    ->orWhereRaw('LOWER(u.last_name) LIKE ?', ["%{$ft_search}%"])
                    ->orWhereRaw("LOWER(CONCAT(u.first_name, ' ', u.last_name)) LIKE ?", ["%{$ft_search}%"]);
                }
            });
        }
        // Date range
        $statuDoctor = $request->get('statuDoctor');
        // Search
        if (!empty($statuDoctor)) {
            if ($user->role == 'staff') {
                $statuDoctor = strtolower($statuDoctor);
                $query->where(function ($q) use ($statuDoctor) {
                    $q->where('u.id', $statuDoctor);
                });
            }
        }
        if ($user->role == 'staff') {
            $query->where('p.staff_id', $user->id);
        }

        $total = $query->count();

        $patientsLists = $query->select([
                't.*',
                'tp.phase',
                'tp.cancellation_date',
                'tp.previous_case_holder',
                'tp.recommended_advisor',
                'tp.treatment_type',
                'u.postal_code',
                'tp.id as treatment_plan',
                'tp.request_new_scan',
                'u.city',
                'u.country',
                'p.setup_type',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_full_name"),
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as patient_full_name"),
            ])
            ->orderBy('t.created_at', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();

        $hashids = new Hashids();
        $records = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => [],
        ];

        foreach ($patientsLists as $patient) {
            $due_date = '';
            $badgeClass = 'badge-soft-info';

            if (str_contains($patient->task, 'Case Review')) {
                $badgeClass = 'badge-soft-primary';
            }

            if (str_contains($patient->task, 'Modification requested') || str_contains($patient->task, 'Modification Setup')) {
                $badgeClass = 'badge-soft-danger';
            }

            if (str_contains($patient->task, 'Setup')) {
                $badgeClass = 'badge-soft-warning';
            }

            if (str_contains($patient->task, 'Review Setup')) {
                if(Auth::user()->role == 'lab')
                $patient->task = str_replace("Review Setup", "Production", $patient->task);
                $badgeClass = 'badge-soft-secondary';
            }

            if (str_contains($patient->task, 'Production')) {
                $badgeClass = 'badge-soft-pink';
            }

            if (str_contains($patient->task, 'an old case')) {
                $badgeClass = 'badge-soft-marron';
            }

            if (str_contains($patient->task, 'Doctor Approved')) {
                $badgeClass = 'badge-soft-success';
            }



            $task = '<a class="btn btn-link '. $badgeClass .' text-600 btn-sm btn-reveal-sm transition-none"'.
                    'href="'. route('patient.case-overview', $hashids->encode($patient->treatment_plan_id)) .'"'.
                    'data-boundary="viewport" aria-haspopup="true" aria-expanded="false">'.$patient->task .'</a>';

            if ($patient->request_new_scan == 1) {
                $requestNewScan = '<div class="font-sans-serif btn-reveal-trigger"><a class="badge badge-soft-warning text-600 btn-sm btn-reveal-sm transition-none"
                            href="'. route('patient.upload-new-scan', $hashids->encode($patient->treatment_plan_id)) .'" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            Case Overview</a></div>';
            } else {
                $caseOverview = '<div class="font-sans-serif btn-reveal-trigger"><a class="badge badge-soft-primary text-600 btn-sm btn-reveal-sm transition-none"
                            href="'. route('patient.case-overview', $hashids->encode($patient->treatment_plan_id)) .'" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            Case Overview</a></div>';
            }


            if(Auth::user()->role == 'doctor'){
                if($patient->cancellation_date){
                    $due_date = date_formate(date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d", strtotime($patient->cancellation_date))))));
                }
            }

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

            $requestNewScan = '';
            if ($patient->request_new_scan == 1) {
                $requestNewScan = '<div class="font-sans-serif btn-reveal-trigger"><a class="badge badge-soft-warning text-600 btn-sm btn-reveal-sm transition-none"
                            href="'. route('patient.upload-new-scan', $hashids->encode($patient->treatment_plan_id)) .'" data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                            Update New Scan</a></div>';
            }

            $records['data'][] = [
                'user_full_name' => $patient->user_full_name,
                'country' => $patient->country,
                'patient_full_name' => $patient->patient_full_name,
                'task_name' => $task,
                'treatment_type' => $patient->treatment_type == '2' ? '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger"> Aligners Full-Service </span>' : '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Treatment Planning Service</span>',
                'setup_type' => $patient->setup_type == '1'
                                ? '<span class="badge fw-semi-bold rounded-pill status badge-soft-danger">Final Setup with individual staging</span>'
                                : ($patient->setup_type == '2'
                                    ? '<span class="badge fw-semi-bold rounded-pill status badge-soft-primary">Quick Setup</span>'
                                    : ''),
                'phase' => '<span class="badge fw-semi-bold rounded-pill status badge-soft-info">Phase '. $patient->phase .'</span>',
                'previous_case_holder' => ucfirst($patient->previous_case_holder),
                'due_date' => $due_date,
                'request_new_scan' => $requestNewScan,
                'case_overview' => $caseOverview,
                'advisor' => $advisor,
                'created_at' => date_formate($patient->created_at)."<br>".date("h:i A", strtotime($patient->created_at)),
            ];
        }

        return $records;

    }

}
