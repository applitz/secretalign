{{-- If the patient is not in the iFrame mode --}}
@if (@$_GET['i'] != 'true')
    <div class="card">
        <div class="card-body">
            <div class="row gx-0 kanban-header rounded-2 px-card py-2 ">
                @if (Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
                    @php
                        $pending_nemo_sync = DB::table('sync_queues')
                            ->where('treatment_plan_id', $patient->id)
                            ->where('is_synced', 0)
                            ->where('is_cancelled', 0)
                        ->first();
                    @endphp
                    @if (@$pending_nemo_sync)
                        @php
                            $nemo_files_synced = 0;
                            if ($pending_nemo_sync->is_fl_upper_arch_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->is_fl_lower_arch_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_front_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_smile_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_profile_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_frontal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_right_buccal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_left_buccal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_upper_occlusal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_lower_occlusal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_panorex_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_lateral_ceph_synced == 1) {
                                $nemo_files_synced++;
                            }
                        @endphp
                        <div class="col d-flex align-items-center">
                            <p class="mb-0 text-info">Sync in progress ({{ $nemo_files_synced }}/12) files synced.</p>
                        </div>
                    @endif
                @endif

                @php
                    $advisor = DB::table('users')->where('id', $patient->recommended_advisor)->first();
                @endphp
                <div class="col d-flex align-items-center">

                    @if (Auth::user()->role == 'doctor' && $patient->status == 'Shipped')
                        <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-primary text-uppercase me-2 d-none d-md-block doctor-reminder-modal" data-bs-toggle="modal" data-bs-target="#doctor-reminder-modal">
                            <i class="fas fa-solid fa-bell fa-2x"></i>
                        </a>
                    @endif

                    <div class="vertical-line vertical-line-400 position-relative h-100 mx-3"></div>
                    @if (@$patient->is_completed == 1 && @$patient->tracking_id && Auth::user()->role != 'lab')
                        <a class="text-success" href="{{ $patient->tracking_id }}" target="_blank">Tracking Nr.</a>
                    @endif
                </div>

                <div class="col-auto d-flex align-items-center">
                    @if (Auth::user()->role == 'superadmin')
                        @if (!DB::table('p_treatment_plans')->where('patient_id', $patient->patient_id)->where('phase', '>', $patient->phase)->exists())
                            @if ($patient->phase > 1)
                                <a href="javascript:void(0);"
                                    class="btn btn-sm btn-falcon-default text-danger text-uppercase me-2 d-none d-md-block "
                                    data-bs-toggle="modal" data-bs-target="#cancelPlan"><span
                                        class="fas fa-times-circle me-2"></span>Cancel Requested Plan</a>
                            @endif
                            @if ($patient->is_completed == 1 && $patient->status == 'Production')
                                <a href="javascript:void(0);"
                                    class="btn btn-sm btn-falcon-default text-danger text-uppercase me-2 d-none d-md-block reopen-case"><span
                                        class="fas fa-book-open me-2"></span>Reopen the case</a>
                            @endif
                            @if ($patient->status == 'Cancelled')
                                <a href="javascript:void(0);"
                                    class="btn btn-sm btn-falcon-default text-danger text-uppercase me-2 d-none d-md-block reopen-case"><span
                                        class="fas fa-book-open me-2"></span>Reopen the case</a>
                            @endif
                        @endif
                    @endif

                    @if (Auth::user()->role == 'doctor')
                        @if (@$patient->is_submitted == 1 && @$patient->is_completed == 0)
                            @if (!DB::table('p_treatment_plans')->where('patient_id', $patient->patient_id)->where('phase', '>', $patient->phase)->exists())
                                {{-- <a href="javascript:void(0);"
                                    class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block update-package"
                                    data-current="{{ $patient->pricing_package }}"><span
                                        class="fas fa-cube me-2"></span>{{ $patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT' }}</a> --}}
                                <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block">
                                    <span class="fas fa-cube me-2"></span>{{ $patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT' }}
                                </a>
                            @endif
                        @endif
                    @endif

                    @if (Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                        @if ($patient->recommended_advisor != null && $patient->advisor_id == null)
                            @if ($patient->advisor_id == null)
                                <a class="btn btn-sm btn-falcon-default text-info me-2 d-none d-md-block"
                                    data-bs-toggle="modal" data-bs-target="#advisorModal">
                                    <span class="fas fa-cube me-2"></span>SEND TO ➡ {{ $advisor->first_name }}
                                    {{ $advisor->last_name }} (€{{ $advisor->advisor_price }})
                                </a>

                                <!-- Advisor Modal Start -->
                                <div class="modal fade" id="advisorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Send to Advisor</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ url('/patient/case-overview/send-from-staff-to-advisor') }}">
                                                    @csrf
                                                    <input type="hidden" name="treatment_plan_id"
                                                        value="{{ $patient->id }}" />
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label>Choose Advisor</label>
                                                            <select class="form-contorl form-select" name="advisor"
                                                                required>
                                                                <option value="{{ $advisor->id }}" selected>
                                                                    {{ $advisor->first_name }}
                                                                    {{ $advisor->last_name }}
                                                                    (€{{ $advisor->advisor_price }})</option>
                                                                @foreach ($advisors as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->first_name }}
                                                                        {{ $item->last_name }}
                                                                        (€{{ $item->advisor_price }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label>Comment for Advisor</label>
                                                                <textarea class="form-control" name="comment" id="" placeholder="Write the comment here"></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Send to Advisor</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($patient->advisor_id != null)
                                <a class="btn btn-sm btn-falcon-default text-info me-2 d-none d-md-block">
                                    <span class="fas fa-cube me-2"></span>SENT TO ➡ {{ $advisor->first_name }}
                                    {{ $advisor->last_name }} (€{{ $advisor->advisor_price }})
                                </a>
                            @endif
                        @endif

                        @if (Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
                            {{-- Advisor Modal End --}}
                        @endif

                        @if ( $patient->status != 'Shipped' && (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'))
                            <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block update-package-admin" data-current="{{ $patient->pricing_package }}">
                                <span class="fas fa-cube me-2"></span>
                                {{ $patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT' }}
                            </a>
                        @else
                            <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block">
                                <span class="fas fa-cube me-2"></span>{{ $patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT' }}
                            </a>
                        @endif

                    @endif

                    @if (@$patient->fl_profile && @$patient->fl_front && @$patient->fl_smile && @$patient->fl_upper_occlusal && @$patient->fl_lower_occlusal &&
                            @$patient->fl_right_buccal && @$patient->fl_frontal && @$patient->fl_left_buccal)
                        <a href="{{ url('/patient/print/images/' . $hashids->encode($patient->id)) }}" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block ">
                            <span class="fas fas fa-print me-2"></span>Images
                        </a>
                    @endif

                    @if ($patient->is_editable == 1 && Auth::user()->role == 'doctor')
                        <a href="{{ url('/patient/edit/' . $hashids->encode($patient->id)) }}" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block">
                            <span class="fas fas fa-edit me-2"></span>Edit
                        </a>
                    @endif

                    @if ($patient->is_submitted == 0 && Auth::user()->role == 'doctor')
                        <a href="{{ url('/patient/edit/' . $hashids->encode($patient->id)) }}" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block">
                            <span class="fas fas fa-edit me-2"></span>Submit Case
                        </a>
                    @endif

                    @if (Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin')
                        @if ($patient->is_editable == 1)
                            <a href="javascript:void(0);" id="block-edit" data="{{ $patient->is_editable }}"
                                class="btn btn-sm btn-falcon-default me-2 d-none d-md-block"><span
                                    class="fas fas fa-edit me-2"></span>Disable Edit</a>
                        @else
                            <a href="javascript:void(0);" id="block-edit" data="{{ $patient->is_editable }}"
                                class="btn btn-sm btn-falcon-default me-2 d-none d-md-block "><span
                                    class="fas fas fa-edit me-2"></span>Allow Edit</a>
                        @endif
                    @endif

                    @if (Auth::user()->role == 'doctor')
                        <a href="{{ url('/patient/documentation/' . $hashids->encode($patient->id)) }}" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block">
                            <span class="fas fa-folder-open me-2"></span>Documentation
                        </a>
                    @endif

                    <div class="dropdown font-sans-serif">
                        <a class="btn btn-sm btn-falcon-default me-2 d-none d-md-block dropdown-toggle"
                            id="dropdownMenuLink" href="#" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Treatment Plan {{ $patient->phase }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="dropdownMenuLink">
                            @foreach ($plans as $plan)
                                @if ($plan->id != $patient->id)
                                    <a class="dropdown-item" href="{{ url('/patient/case-overview/' . $hashids->encode($plan->id)) }}">
                                        Treatment Plan {{ $plan->phase }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endif
