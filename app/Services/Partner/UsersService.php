<?php

namespace App\Services\Partner;

use App\Services\CommonFunction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class UsersService extends CommonFunction
{
    public function getUsers($request)
    {
        $filters = $this->DTFilters($request->all());
        $offset = $filters['offset'] ?? 0;
        $limit = $filters['limit'] ?? 10;
        $search = $filters['search'] ?? null;

        $query = DB::table('users as u')
            ->leftJoin('tiers as t', function ($join) {
                $join->on('u.tier', '=', 't.id')
                    ->where('u.role', '=', 'doctor');
            })
            ->where([
                ['u.id', '!=', Auth::id()],
                ['u.role', '=', 'doctor'],
                ['u.registered_by', '=', Auth::id()],
            ]);

            // search
        $ft_search = $request->get('ft_search');
        // Search
        if (!empty($ft_search)) {

            $query->where(function ($q) use ($ft_search) {
                $q->where('u.first_name', 'like', "%{$ft_search}%")
                ->orWhere('u.last_name', 'like', "%{$ft_search}%")
                ->orWhere('u.email', 'like', "%{$ft_search}%")
                ->orWhere(DB::raw("CONCAT(u.first_name, ' ', u.last_name)"), 'like', "%{$ft_search}%");
            });

        }
        $total = $query->count();

        $users = $query
            ->select(
                'u.id',
                'u.role',
                'u.tier',
                'u.email',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_full_name"),
                't.tier_name',
                DB::raw("(CASE WHEN u.role='lab' THEN (SELECT COUNT(*) FROM lab_requests WHERE user_id = u.id) ELSE NULL END) as lab_request_count"),
                DB::raw("(CASE WHEN u.role='doctor' THEN (SELECT COUNT(*) FROM patients WHERE user_id = u.id AND is_deleted=0 AND first_name IS NOT NULL AND last_name IS NOT NULL AND dob IS NOT NULL) ELSE NULL END) as patient_count"),
                DB::raw("(CASE WHEN u.role='rep' THEN (SELECT COUNT(*) FROM users WHERE registered_by = u.id AND role='doctor') ELSE NULL END) as doctors_count"),
            )
            ->orderBy('u.id', 'desc')
            ->offset($offset)
            ->limit($limit)
            ->get();


        $records = [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => [],
        ];

        foreach ($users as $user) {
            // Tier Badge
            $tierBadge = '';
            if ($user->role === 'doctor') {
                switch ($user->tier) {
                    case 2:
                        $tierBadge = '<span class="badge rounded-pill badge-soft-dark">' . $user->tier_name . '</span>';
                        break;
                    case 3:
                        $tierBadge = '<span class="badge rounded-pill badge-soft-warning">' . $user->tier_name . '</span>';
                        break;
                    case 4:
                        $tierBadge = '<span class="badge rounded-pill badge-soft-secondary">' . $user->tier_name . '</span>';
                        break;
                    case 5:
                        $tierBadge = '<span class="badge rounded-pill badge-soft-info">' . $user->tier_name . '</span>';
                        break;
                    case 6:
                        $tierBadge = '<span class="badge rounded-pill badge-soft-success">' . $user->tier_name . '</span>';
                        break;
                    default:
                        $tierBadge = $user->tier_name;
                        break;
                }
            }

            // Name with extra info block
            $nameHtml = '<span class="mb-1 fw-semi-bold text-dark">'
                    . htmlspecialchars($user->user_full_name)
                    . '</span>';

            if ($user->role === 'lab') {
                $nameHtml .= '<p class="fw-semi-bold mb-0 text-500">Lab Request (' . $user->lab_request_count . ')</p>';
            } elseif ($user->role === 'doctor') {
                $nameHtml .= '<p class="fw-semi-bold mb-0 text-500">Patients (' . $user->patient_count . ')</p>';
            } elseif ($user->role === 'rep') {
                $nameHtml .= '<p class="fw-semi-bold mb-0 text-500">Registered Doctors (' . $user->doctors_count . ')</p>';
            }

            $records['data'][] = [

                'name'  => $nameHtml,
                'email' => $user->email,
                'tier'  => $tierBadge,
            ];
        }

        return $records;
    }




}
?>
