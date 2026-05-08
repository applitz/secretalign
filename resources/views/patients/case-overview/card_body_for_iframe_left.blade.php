<div class="col-md-4 ">
    @if (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
        <div class="card mb-3">
            <div class="card-body">
                <form method="POST" action="{{ url('/patient/update-links/' . $patient->id) }}">@csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Nemolink</label>
                            <input type="text" class="form-control @error('nemolink') is-invalid @enderror"
                                name="nemolink" value="{{ $patient->iframe_link }}">
                            @error('nemolink')
                                <div class="invalid-feedback d-blcok">jhgjhgjh {{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Tracking Nr.</label>
                            <input type="text" class="form-control @error('tracking_nr') is-invalid @enderror"
                                name="tracking_nr" value="{{ $patient->tracking_id }}">
                            @error('tracking_nr')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body p-0">

            <div class="accordion" id="accordionExample2">

                @if (@$comments && $patient->is_submitted != 0)
                    @if (count($comments) > 0)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingl1">
                                <button class="accordion-button collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapsel1" aria-expanded="true"
                                    aria-controls="collapsel1">Comments</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="collapsel1" aria-labelledby="headingl1"
                                data-bs-parent="#accordionExample2">
                                <div class="accordion-body">
                                    <div class="container-fluid px-0 " id="case-overview-comments">
                                        @include('patients.overview_comments')
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif


                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingl13234">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsel3" aria-expanded="true" aria-controls="collapsel3">
                            Prescription
                        </button>
                    </h2>

                    <div class="accordion-collapse collapse" id="collapsel3" aria-labelledby="headingl13234"
                        data-bs-parent="#accordionExample2">
                        <div class="accordion-body">
                            <div class="container-fluid px-0">
                                <h5 class="card-title">Prescription</h5>
                                <ul class="list-group list-group-flush">
                                    @if ($patient->treat_upper_arch == 1)
                                        <li class="list-group-item">
                                            <p class="text-muted mb-0"><i class="fas fa-check"></i> Treat Upper Arch</p>
                                        </li>
                                    @endif
                                    @if ($patient->treat_lower_arch == 1)
                                        <li class="list-group-item">
                                            <p class="text-muted mb-0"><i class="fas fa-check"></i> Treat Lower Arch</p>
                                        </li>
                                    @endif
                                </ul>

                                @if (@$patient->midline)
                                    <h5 class="card-title mt-2">Midline</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ ucfirst($patient->midline) }} Midline
                                            </p>
                                            @if (@$patient->midline_notes)
                                                <p class="text-muted mb-0">{{ $patient->midline_notes }}</p>
                                            @endif

                                        </li>
                                    </ul>
                                @endif

                                @if (@$patient->archform)
                                    <h5 class="card-title mt-2">Archform</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ ucfirst($patient->archform) }}
                                                Archform</p>
                                            @if (@$patient->archform_notes)
                                                <p class="text-muted mb-0">{{ $patient->archform_notes }}</p>
                                            @endif
                                        </li>
                                    </ul>
                                @endif

                                @if (@$patient->class)
                                    @php
                                        $additional_attachments = [];
                                        if (
                                            $patient->additional_attachments != '' &&
                                            $patient->additional_attachments != null
                                        ) {
                                            $additional_attachments = unserialize($patient->additional_attachments);
                                        }
                                    @endphp
                                    <h5 class="card-title mt-2">Class</h5>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ ucfirst($patient->class) }} Class</p>
                                            @if (@$patient->class_notes)
                                                <p class="text-muted mb-0">{{ $patient->class_notes }}</p>
                                            @endif

                                        </li>

                                        @if (in_array('Bite Keeper', $additional_attachments))
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><i class="fas fa-check"></i> Bite Keeper</p>
                                            </li>
                                        @endif

                                        @if (in_array('Secret Wings', $additional_attachments))
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><i class="fas fa-check"></i> Secret Wings</p>
                                            </li>
                                        @endif

                                        @if (in_array('Secret Blocks', $additional_attachments))
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><i class="fas fa-check"></i> Secret Blocks</p>
                                            </li>
                                        @endif
                                    </ul>
                                    <br>
                                    @if($patient->is_new == '1')
                                        @if($patient->button_outer != '' || $patient->button_inner != '' || $patient->ihook_outer != '' || $patient->ihook_inner != '' ||
                                            $patient->precision_cut_outer != '' || $patient->precision_cut_inner != '' || $patient->power_arm_attachment_outer != '' || $patient->power_arm_attachment_inner != '' ||
                                            $patient->power_ridge_outer != '' || $patient->power_ridge_inner != '' || $patient->bite_turbos != '' || $patient->bite_ramp != '')
                                            @include('patients.case-overview.section1')
                                        @endif
                                    @endif
                                @endif

                                <h5 class="card-title mt-2">Resolutions</h5>
                                <ul class="list-group list-group-flush">
                                    @if (@$patient->tooth_size_issues)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ $patient->tooth_size_issues }}</p>

                                        </li>
                                    @endif
                                    @if ($patient->tooth_size_issues === 'IPR')
                                        @if (@$patient->location_upper)
                                            <li class="list-group-item">

                                                <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                    {{ @$patient->location_upper }} Location
                                                    Upper
                                                </p>

                                            </li>
                                        @endif
                                        @if (@$patient->location_lower)
                                            <li class="list-group-item">

                                                <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                    {{ @$patient->location_lower }} Location
                                                    Lower
                                                </p>

                                            </li>
                                        @endif
                                        @if (@$patient->limits)
                                            <li class="list-group-item">

                                                <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                    {{ $patient->limits }}<small>mm</small>
                                                    IPR/Contact</p>

                                            </li>
                                        @endif
                                    @endif
                                    @if (@$patient->resolutions_notes)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0">{{ $patient->resolutions_notes }}</p>

                                        </li>
                                    @endif
                                </ul>

                                @if($patient->is_new == '1')
                                    @if($patient->unerupted_teeth != '' || $patient->extracted_teeth != '' || $patient->tooth_movement_restrictions != '' || $patient->coil != '' || $patient->pontic != '' || $patient->bridge != '')
                                         @include('patients.case-overview.section2')
                                    @endif
                                @endif

                                @if($patient->is_new == '0')
                                    @php
                                        $pcp_ur = [];
                                        if ($patient->pcp_ur != '' && $patient->pcp_ur != null) {
                                            $pcp_ur = unserialize($patient->pcp_ur);
                                        }
                                        $pcp_ul = [];
                                        if ($patient->pcp_ul != '' && $patient->pcp_ul != null) {
                                            $pcp_ul = unserialize($patient->pcp_ul);
                                        }
                                        $pcp_lr = [];
                                        if ($patient->pcp_lr != '' && $patient->pcp_lr != null) {
                                            $pcp_lr = unserialize($patient->pcp_lr);
                                        }
                                        $pcp_ll = [];
                                        if ($patient->pcp_ll != '' && $patient->pcp_ll != null) {
                                            $pcp_ll = unserialize($patient->pcp_ll);
                                        }
                                    @endphp
                                    @if (count($pcp_ur) > 0 || count($pcp_ul) > 0 || count($pcp_lr) > 0 || count($pcp_ll) > 0)
                                        <h5 class="mb-3 mt-2 card-title">Precision Cuts Placement</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">
                                                                    <input type="checkbox" class="tooth" data-number="8" name="pcp_ur" id="pcp_ur8" @if (in_array(8, $pcp_ur)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="7" name="pcp_ur" id="pcp_ur7" @if (in_array(7, $pcp_ur)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="6" name="pcp_ur" id="pcp_ur6" @if (in_array(6, $pcp_ur)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="5" name="pcp_ur" id="pcp_ur5" @if (in_array(5, $pcp_ur)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="4" name="pcp_ur" id="pcp_ur4" @if (in_array(4, $pcp_ur)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="3" name="pcp_ur" id="pcp_ur3" @if (in_array(3, $pcp_ur)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="2" name="pcp_ur" id="pcp_ur2" @if (in_array(2, $pcp_ur)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="1" name="pcp_ur" id="pcp_ur1" @if (in_array(1, $pcp_ur)) checked @endif disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="pcp_ul" id="pcp_ul1"
                                                                        @if (in_array(1, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="pcp_ul" id="pcp_ul2"
                                                                        @if (in_array(2, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="pcp_ul" id="pcp_ul3"
                                                                        @if (in_array(3, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="pcp_ul" id="pcp_ul4"
                                                                        @if (in_array(4, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="pcp_ul" id="pcp_ul5"
                                                                        @if (in_array(5, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="pcp_ul" id="pcp_ul6"
                                                                        @if (in_array(6, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="pcp_ul" id="pcp_ul7"
                                                                        @if (in_array(7, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="pcp_ul" id="pcp_ul8"
                                                                        @if (in_array(8, $pcp_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="pcp_lr" id="pcp_lr8"
                                                                        @if (in_array(8, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="pcp_lr" id="pcp_lr7"
                                                                        @if (in_array(7, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="pcp_lr" id="pcp_lr6"
                                                                        @if (in_array(6, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="pcp_lr" id="pcp_lr5"
                                                                        @if (in_array(5, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="pcp_lr" id="pcp_lr4"
                                                                        @if (in_array(4, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="pcp_lr" id="pcp_lr3"
                                                                        @if (in_array(3, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="pcp_lr" id="pcp_lr2"
                                                                        @if (in_array(2, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="pcp_lr" id="pcp_lr1"
                                                                        @if (in_array(1, $pcp_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">
                                                                    <input type="checkbox" class="tooth" data-number="1" name="pcp_ll" id="pcp_ll1" @if (in_array(1, $pcp_ll)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="2" name="pcp_ll" id="pcp_ll2" @if (in_array(2, $pcp_ll)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="3" name="pcp_ll" id="pcp_ll3" @if (in_array(3, $pcp_ll)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="4" name="pcp_ll" id="pcp_ll4" @if (in_array(4, $pcp_ll)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="5" name="pcp_ll" id="pcp_ll5" @if (in_array(5, $pcp_ll)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="6" name="pcp_ll" id="pcp_ll6" @if (in_array(6, $pcp_ll)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="7" name="pcp_ll" id="pcp_ll7" @if (in_array(7, $pcp_ll)) checked @endif disabled>
                                                                    <input type="checkbox" class="tooth" data-number="8" name="pcp_ll" id="pcp_ll8" @if (in_array(8, $pcp_ll)) checked @endif disabled>
                                                                </div>
                                                                <div class="card-footer text-end"> Left Lower </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $ctp_ur = [];
                                        if ($patient->ctp_ur != '' && $patient->ctp_ur != null) {
                                            $ctp_ur = unserialize($patient->ctp_ur);
                                        }
                                        $ctp_ul = [];
                                        if ($patient->ctp_ul != '' && $patient->ctp_ul != null) {
                                            $ctp_ul = unserialize($patient->ctp_ul);
                                        }
                                        $ctp_lr = [];
                                        if ($patient->ctp_lr != '' && $patient->ctp_lr != null) {
                                            $ctp_lr = unserialize($patient->ctp_lr);
                                        }
                                        $ctp_ll = [];
                                        if ($patient->ctp_ll != '' && $patient->ctp_ll != null) {
                                            $ctp_ll = unserialize($patient->ctp_ll);
                                        }
                                    @endphp
                                    @if (count($ctp_ur) > 0 || count($ctp_ul) > 0 || count($ctp_lr) > 0 || count($ctp_ll) > 0)
                                        <h5 class="mb-3 mt-2 card-title">Cutouts Placement</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ctp_ur" id="ctp_ur8"
                                                                        @if (in_array(8, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ctp_ur" id="ctp_ur7"
                                                                        @if (in_array(7, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ctp_ur" id="ctp_ur6"
                                                                        @if (in_array(6, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ctp_ur" id="ctp_ur5"
                                                                        @if (in_array(5, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ctp_ur" id="ctp_ur4"
                                                                        @if (in_array(4, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ctp_ur" id="ctp_ur3"
                                                                        @if (in_array(3, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ctp_ur" id="ctp_ur2"
                                                                        @if (in_array(2, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ctp_ur" id="ctp_ur1"
                                                                        @if (in_array(1, $ctp_ur)) checked @endif
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ctp_ul" id="ctp_ul1"
                                                                        @if (in_array(1, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ctp_ul" id="ctp_ul2"
                                                                        @if (in_array(2, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ctp_ul" id="ctp_ul3"
                                                                        @if (in_array(3, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ctp_ul" id="ctp_ul4"
                                                                        @if (in_array(4, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ctp_ul" id="ctp_ul5"
                                                                        @if (in_array(5, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ctp_ul" id="ctp_ul6"
                                                                        @if (in_array(6, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ctp_ul" id="ctp_ul7"
                                                                        @if (in_array(7, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ctp_ul" id="ctp_ul8"
                                                                        @if (in_array(8, $ctp_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ctp_lr" id="ctp_lr8"
                                                                        @if (in_array(8, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ctp_lr" id="ctp_lr7"
                                                                        @if (in_array(7, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ctp_lr" id="ctp_lr6"
                                                                        @if (in_array(6, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ctp_lr" id="ctp_lr5"
                                                                        @if (in_array(5, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ctp_lr" id="ctp_lr4"
                                                                        @if (in_array(4, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ctp_lr" id="ctp_lr3"
                                                                        @if (in_array(3, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ctp_lr" id="ctp_lr2"
                                                                        @if (in_array(2, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ctp_lr" id="ctp_lr1"
                                                                        @if (in_array(1, $ctp_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ctp_ll" id="ctp_ll1"
                                                                        @if (in_array(1, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ctp_ll" id="ctp_ll2"
                                                                        @if (in_array(2, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ctp_ll" id="ctp_ll3"
                                                                        @if (in_array(3, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ctp_ll" id="ctp_ll4"
                                                                        @if (in_array(4, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ctp_ll" id="ctp_ll5"
                                                                        @if (in_array(5, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ctp_ll" id="ctp_ll6"
                                                                        @if (in_array(6, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ctp_ll" id="ctp_ll7"
                                                                        @if (in_array(7, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ctp_ll" id="ctp_ll8"
                                                                        @if (in_array(8, $ctp_ll)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $ihook_ur = [];
                                        if (!empty($patient->ihook_ur)) {
                                            $ihook_ur = @unserialize($patient->ihook_ur) ?: [];
                                        }
                                        $ihook_ul = [];
                                        if (!empty($patient->ihook_ul)) {
                                            $ihook_ul = @unserialize($patient->ihook_ul) ?: [];
                                        }
                                        $ihook_lr = [];
                                        if (!empty($patient->ihook_lr)) {
                                            $ihook_lr = @unserialize($patient->ihook_lr) ?: [];
                                        }
                                        $ihook_ll = [];
                                        if (!empty($patient->ihook_ll)) {
                                            $ihook_ll = @unserialize($patient->ihook_ll) ?: [];
                                        }
                                    @endphp

                                    @if (count($ihook_ur) > 0 || count($ihook_ul) > 0 || count($ihook_lr) > 0 || count($ihook_ll) > 0)
                                        <h5 class="mb-3 mt-2 card-title">I-Hook</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ihook_ur"
                                                                        id="ihook_ur8"
                                                                        @if (in_array(8, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ihook_ur"
                                                                        id="ihook_ur7"
                                                                        @if (in_array(7, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ihook_ur"
                                                                        id="ihook_ur6"
                                                                        @if (in_array(6, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ihook_ur"
                                                                        id="ihook_ur5"
                                                                        @if (in_array(5, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ihook_ur"
                                                                        id="ihook_ur4"
                                                                        @if (in_array(4, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ihook_ur"
                                                                        id="ihook_ur3"
                                                                        @if (in_array(3, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ihook_ur"
                                                                        id="ihook_ur2"
                                                                        @if (in_array(2, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ihook_ur"
                                                                        id="ihook_ur1"
                                                                        @if (in_array(1, $ihook_ur)) checked @endif
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ihook_ul"
                                                                        id="ihook_ul1"
                                                                        @if (in_array(1, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ihook_ul"
                                                                        id="ihook_ul2"
                                                                        @if (in_array(2, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ihook_ul"
                                                                        id="ihook_ul3"
                                                                        @if (in_array(3, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ihook_ul"
                                                                        id="ihook_ul4"
                                                                        @if (in_array(4, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ihook_ul"
                                                                        id="ihook_ul5"
                                                                        @if (in_array(5, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ihook_ul"
                                                                        id="ihook_ul6"
                                                                        @if (in_array(6, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ihook_ul"
                                                                        id="ihook_ul7"
                                                                        @if (in_array(7, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ihook_ul"
                                                                        id="ihook_ul8"
                                                                        @if (in_array(8, $ihook_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ihook_lr"
                                                                        id="ihook_lr8"
                                                                        @if (in_array(8, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ihook_lr"
                                                                        id="ihook_lr7"
                                                                        @if (in_array(7, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ihook_lr"
                                                                        id="ihook_lr6"
                                                                        @if (in_array(6, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ihook_lr"
                                                                        id="ihook_lr5"
                                                                        @if (in_array(5, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ihook_lr"
                                                                        id="ihook_lr4"
                                                                        @if (in_array(4, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ihook_lr"
                                                                        id="ihook_lr3"
                                                                        @if (in_array(3, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ihook_lr"
                                                                        id="ihook_lr2"
                                                                        @if (in_array(2, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ihook_lr"
                                                                        id="ihook_lr1"
                                                                        @if (in_array(1, $ihook_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ihook_ll"
                                                                        id="ihook_ll1"
                                                                        @if (in_array(1, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ihook_ll"
                                                                        id="ihook_ll2"
                                                                        @if (in_array(2, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ihook_ll"
                                                                        id="ihook_ll3"
                                                                        @if (in_array(3, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ihook_ll"
                                                                        id="ihook_ll4"
                                                                        @if (in_array(4, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ihook_ll"
                                                                        id="ihook_ll5"
                                                                        @if (in_array(5, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ihook_ll"
                                                                        id="ihook_ll6"
                                                                        @if (in_array(6, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ihook_ll"
                                                                        id="ihook_ll7"
                                                                        @if (in_array(7, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ihook_ll"
                                                                        id="ihook_ll8"
                                                                        @if (in_array(8, $ihook_ll)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $ofp_ur = [];
                                        if ($patient->ofp_ur != '' && $patient->ofp_ur != null) {
                                            $ofp_ur = unserialize($patient->ofp_ur);
                                        }
                                        $ofp_ul = [];
                                        if ($patient->ofp_ul != '' && $patient->ofp_ul != null) {
                                            $ofp_ul = unserialize($patient->ofp_ul);
                                        }
                                        $ofp_lr = [];
                                        if ($patient->ofp_lr != '' && $patient->ofp_lr != null) {
                                            $ofp_lr = unserialize($patient->ofp_lr);
                                        }
                                        $ofp_ll = [];
                                        if ($patient->ofp_ll != '' && $patient->ofp_ll != null) {
                                            $ofp_ll = unserialize($patient->ofp_ll);
                                        }
                                    @endphp

                                    @if (count($ofp_ur) > 0 || count($ofp_ul) > 0 || count($ofp_lr) > 0 || count($ofp_ll) > 0)
                                        <h5 class="mb-3 mt-2 card-title">Open space for future Prosthesis</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ofp_ur"
                                                                        id="ofp_ur8"
                                                                        @if (in_array(8, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ofp_ur"
                                                                        id="ofp_ur7"
                                                                        @if (in_array(7, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ofp_ur"
                                                                        id="ofp_ur6"
                                                                        @if (in_array(6, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ofp_ur"
                                                                        id="ofp_ur5"
                                                                        @if (in_array(5, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ofp_ur"
                                                                        id="ofp_ur4"
                                                                        @if (in_array(4, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ofp_ur"
                                                                        id="ofp_ur3"
                                                                        @if (in_array(3, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ofp_ur"
                                                                        id="ofp_ur2"
                                                                        @if (in_array(2, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ofp_ur"
                                                                        id="ofp_ur1"
                                                                        @if (in_array(1, $ofp_ur)) checked @endif
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ofp_ul"
                                                                        id="ofp_ul1"
                                                                        @if (in_array(1, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ofp_ul"
                                                                        id="ofp_ul2"
                                                                        @if (in_array(2, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ofp_ul"
                                                                        id="ofp_ul3"
                                                                        @if (in_array(3, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ofp_ul"
                                                                        id="ofp_ul4"
                                                                        @if (in_array(4, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ofp_ul"
                                                                        id="ofp_ul5"
                                                                        @if (in_array(5, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ofp_ul"
                                                                        id="ofp_ul6"
                                                                        @if (in_array(6, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ofp_ul"
                                                                        id="ofp_ul7"
                                                                        @if (in_array(7, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ofp_ul"
                                                                        id="ofp_ul8"
                                                                        @if (in_array(8, $ofp_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ofp_lr"
                                                                        id="ofp_lr8"
                                                                        @if (in_array(8, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ofp_lr"
                                                                        id="ofp_lr7"
                                                                        @if (in_array(7, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ofp_lr"
                                                                        id="ofp_lr6"
                                                                        @if (in_array(6, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ofp_lr"
                                                                        id="ofp_lr5"
                                                                        @if (in_array(5, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ofp_lr"
                                                                        id="ofp_lr4"
                                                                        @if (in_array(4, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ofp_lr"
                                                                        id="ofp_lr3"
                                                                        @if (in_array(3, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ofp_lr"
                                                                        id="ofp_lr2"
                                                                        @if (in_array(2, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ofp_lr"
                                                                        id="ofp_lr1"
                                                                        @if (in_array(1, $ofp_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="ofp_ll"
                                                                        id="ofp_ll1"
                                                                        @if (in_array(1, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="ofp_ll"
                                                                        id="ofp_ll2"
                                                                        @if (in_array(2, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="ofp_ll"
                                                                        id="ofp_ll3"
                                                                        @if (in_array(3, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="ofp_ll"
                                                                        id="ofp_ll4"
                                                                        @if (in_array(4, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="ofp_ll"
                                                                        id="ofp_ll5"
                                                                        @if (in_array(5, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="ofp_ll"
                                                                        id="ofp_ll6"
                                                                        @if (in_array(6, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="ofp_ll"
                                                                        id="ofp_ll7"
                                                                        @if (in_array(7, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="ofp_ll"
                                                                        id="ofp_ll8"
                                                                        @if (in_array(8, $ofp_ll)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $tmr_ur = [];
                                        if ($patient->tmr_ur != '' && $patient->tmr_ur != null) {
                                            $tmr_ur = unserialize($patient->tmr_ur);
                                        }
                                        $tmr_ul = [];
                                        if ($patient->tmr_ul != '' && $patient->tmr_ul != null) {
                                            $tmr_ul = unserialize($patient->tmr_ul);
                                        }
                                        $tmr_lr = [];
                                        if ($patient->tmr_lr != '' && $patient->tmr_lr != null) {
                                            $tmr_lr = unserialize($patient->tmr_lr);
                                        }
                                        $tmr_ll = [];
                                        if ($patient->tmr_ll != '' && $patient->tmr_ll != null) {
                                            $tmr_ll = unserialize($patient->tmr_ll);
                                        }
                                    @endphp
                                    @if (count($tmr_ur) > 0 || count($tmr_ul) > 0 || count($tmr_lr) > 0 || count($tmr_ll) > 0)
                                        <h5 class="mb-3 mt-2 card-title">Tooth Movement Restrictions</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tmr_ur"
                                                                        id="tmr_ur8"
                                                                        @if (in_array(8, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tmr_ur"
                                                                        id="tmr_ur7"
                                                                        @if (in_array(7, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tmr_ur"
                                                                        id="tmr_ur6"
                                                                        @if (in_array(6, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tmr_ur"
                                                                        id="tmr_ur5"
                                                                        @if (in_array(5, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tmr_ur"
                                                                        id="tmr_ur4"
                                                                        @if (in_array(4, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tmr_ur"
                                                                        id="tmr_ur3"
                                                                        @if (in_array(3, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tmr_ur"
                                                                        id="tmr_ur2"
                                                                        @if (in_array(2, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tmr_ur"
                                                                        id="tmr_ur1"
                                                                        @if (in_array(1, $tmr_ur)) checked @endif
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tmr_ul"
                                                                        id="tmr_ul1"
                                                                        @if (in_array(1, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tmr_ul"
                                                                        id="tmr_ul2"
                                                                        @if (in_array(2, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tmr_ul"
                                                                        id="tmr_ul3"
                                                                        @if (in_array(3, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tmr_ul"
                                                                        id="tmr_ul4"
                                                                        @if (in_array(4, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tmr_ul"
                                                                        id="tmr_ul5"
                                                                        @if (in_array(5, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tmr_ul"
                                                                        id="tmr_ul6"
                                                                        @if (in_array(6, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tmr_ul"
                                                                        id="tmr_ul7"
                                                                        @if (in_array(7, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tmr_ul"
                                                                        id="tmr_ul8"
                                                                        @if (in_array(8, $tmr_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tmr_lr"
                                                                        id="tmr_lr8"
                                                                        @if (in_array(8, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tmr_lr"
                                                                        id="tmr_lr7"
                                                                        @if (in_array(7, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tmr_lr"
                                                                        id="tmr_lr6"
                                                                        @if (in_array(6, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tmr_lr"
                                                                        id="tmr_lr5"
                                                                        @if (in_array(5, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tmr_lr"
                                                                        id="tmr_lr4"
                                                                        @if (in_array(4, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tmr_lr"
                                                                        id="tmr_lr3"
                                                                        @if (in_array(3, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tmr_lr"
                                                                        id="tmr_lr2"
                                                                        @if (in_array(2, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tmr_lr"
                                                                        id="tmr_lr1"
                                                                        @if (in_array(1, $tmr_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tmr_ll"
                                                                        id="tmr_ll1"
                                                                        @if (in_array(1, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tmr_ll"
                                                                        id="tmr_ll2"
                                                                        @if (in_array(2, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tmr_ll"
                                                                        id="tmr_ll3"
                                                                        @if (in_array(3, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tmr_ll"
                                                                        id="tmr_ll4"
                                                                        @if (in_array(4, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tmr_ll"
                                                                        id="tmr_ll5"
                                                                        @if (in_array(5, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tmr_ll"
                                                                        id="tmr_ll6"
                                                                        @if (in_array(6, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tmr_ll"
                                                                        id="tmr_ll7"
                                                                        @if (in_array(7, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tmr_ll"
                                                                        id="tmr_ll8"
                                                                        @if (in_array(8, $tmr_ll)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $mut_ur = [];
                                        if ($patient->mut_ur != '' && $patient->mut_ur != null) {
                                            $mut_ur = unserialize($patient->mut_ur);
                                        }
                                        $mut_ul = [];
                                        if ($patient->mut_ul != '' && $patient->mut_ul != null) {
                                            $mut_ul = unserialize($patient->mut_ul);
                                        }
                                        $mut_lr = [];
                                        if ($patient->mut_lr != '' && $patient->mut_lr != null) {
                                            $mut_lr = unserialize($patient->mut_lr);
                                        }
                                        $mut_ll = [];
                                        if ($patient->mut_ll != '' && $patient->mut_ll != null) {
                                            $mut_ll = unserialize($patient->mut_ll);
                                        }
                                    @endphp
                                    @if (count($mut_ur) > 0 || count($mut_ul) > 0 || count($mut_lr) > 0 || count($mut_ll) > 0)
                                        <h5 class=" my-3 mt-2 card-title">Missing or Unerupted teeth</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="mut_ur"
                                                                        id="mut_ur8"
                                                                        @if (in_array(8, $mut_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="mut_ur"
                                                                        id="mut_ur7"
                                                                        @if (in_array(7, $mut_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="mut_ur"
                                                                        id="mut_ur6"
                                                                        @if (in_array(6, $mut_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="mut_ur"
                                                                        id="mut_ur5"
                                                                        @if (in_array(5, $mut_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="mut_ur"
                                                                        id="mut_ur4"
                                                                        @if (in_array(4, $mut_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="mut_ur"
                                                                        id="mut_ur3"
                                                                        @if (in_array(3, $mut_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="mut_ur"
                                                                        id="mut_ur2"
                                                                        @if (in_array(2, $mut_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="mut_ur"
                                                                        id="mut_ur1"
                                                                        @if (in_array(1, $mut_ur)) checked @endif
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">


                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="mut_ul"
                                                                        id="mut_ul1"
                                                                        @if (in_array(1, $mut_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="mut_ul"
                                                                        id="mut_ul2"
                                                                        @if (in_array(2, $mut_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="mut_ul"
                                                                        id="mut_ul3"
                                                                        @if (in_array(3, $mut_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="mut_ul"
                                                                        id="mut_ul4"
                                                                        @if (in_array(4, $mut_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="mut_ul"
                                                                        id="mut_ul5"
                                                                        @if (in_array(5, $mut_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="mut_ul"
                                                                        id="mut_ul6"
                                                                        @if (in_array(6, $mut_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="mut_ul"
                                                                        id="mut_ul7"
                                                                        @if (in_array(7, $mut_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="mut_ul"
                                                                        id="mut_ul8"
                                                                        @if (in_array(8, $mut_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="mut_lr"
                                                                        id="mut_lr8"
                                                                        @if (in_array(8, $mut_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="mut_lr"
                                                                        id="mut_lr7"
                                                                        @if (in_array(7, $mut_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="mut_lr"
                                                                        id="mut_lr6"
                                                                        @if (in_array(6, $mut_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="mut_lr"
                                                                        id="mut_lr5"
                                                                        @if (in_array(5, $mut_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="mut_lr"
                                                                        id="mut_lr4"
                                                                        @if (in_array(4, $mut_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="mut_lr"
                                                                        id="mut_lr3"
                                                                        @if (in_array(3, $mut_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="mut_lr"
                                                                        id="mut_lr2"
                                                                        @if (in_array(2, $mut_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="mut_lr"
                                                                        id="mut_lr1"
                                                                        @if (in_array(1, $mut_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="mut_ll"
                                                                        id="mut_ll1"
                                                                        @if (in_array(1, $mut_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="mut_ll"
                                                                        id="mut_ll2"
                                                                        @if (in_array(2, $mut_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="mut_ll"
                                                                        id="mut_ll3"
                                                                        @if (in_array(3, $mut_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="mut_ll"
                                                                        id="mut_ll4"
                                                                        @if (in_array(4, $mut_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="mut_ll"
                                                                        id="mut_ll5"
                                                                        @if (in_array(5, $mut_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="mut_ll"
                                                                        id="mut_ll6"
                                                                        @if (in_array(6, $mut_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="mut_ll"
                                                                        id="mut_ll7"
                                                                        @if (in_array(7, $mut_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="mut_ll"
                                                                        id="mut_ll8"
                                                                        @if (in_array(8, $mut_ll)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $tbe_ur = [];
                                        if ($patient->tbe_ur != '' && $patient->tbe_ur != null) {
                                            $tbe_ur = unserialize($patient->tbe_ur);
                                        }

                                        $tbe_ul = [];
                                        if ($patient->tbe_ul != '' && $patient->tbe_ul != null) {
                                            $tbe_ul = unserialize($patient->tbe_ul);
                                        }
                                        $tbe_lr = [];
                                        if ($patient->tbe_lr != '' && $patient->tbe_lr != null) {
                                            $tbe_lr = unserialize($patient->tbe_lr);
                                        }
                                        $tbe_ll = [];
                                        if ($patient->tbe_ll != '' && $patient->tbe_ll != null) {
                                            $tbe_ll = unserialize($patient->tbe_ll);
                                        }
                                    @endphp
                                    @if (count($tbe_ur) > 0 || count($tbe_ul) > 0 || count($tbe_lr) > 0 || count($tbe_ll) > 0)
                                        <h5 class=" my-3 mt-2 card-title">To be Extracted</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tbe_ur"
                                                                        id="tbe_ur8"
                                                                        @if (in_array(8, $tbe_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tbe_ur"
                                                                        id="tbe_ur7"
                                                                        @if (in_array(7, $tbe_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tbe_ur"
                                                                        id="tbe_ur6"
                                                                        @if (in_array(6, $tbe_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tbe_ur"
                                                                        id="tbe_ur5"
                                                                        @if (in_array(5, $tbe_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tbe_ur"
                                                                        id="tbe_ur4"
                                                                        @if (in_array(4, $tbe_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tbe_ur"
                                                                        id="tbe_ur3"
                                                                        @if (in_array(3, $tbe_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tbe_ur"
                                                                        id="tbe_ur2"
                                                                        @if (in_array(2, $tbe_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tbe_ur"
                                                                        id="tbe_ur1"
                                                                        @if (in_array(1, $tbe_ur)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 tw top right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tbe_ul"
                                                                        id="tbe_ul1"
                                                                        @if (in_array(1, $tbe_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tbe_ul"
                                                                        id="tbe_ul2"
                                                                        @if (in_array(2, $tbe_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tbe_ul"
                                                                        id="tbe_ul3"
                                                                        @if (in_array(3, $tbe_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tbe_ul"
                                                                        id="tbe_ul4"
                                                                        @if (in_array(4, $tbe_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tbe_ul"
                                                                        id="tbe_ul5"
                                                                        @if (in_array(5, $tbe_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tbe_ul"
                                                                        id="tbe_ul6"
                                                                        @if (in_array(6, $tbe_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tbe_ul"
                                                                        id="tbe_ul7"
                                                                        @if (in_array(7, $tbe_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tbe_ul"
                                                                        id="tbe_ul8"
                                                                        @if (in_array(8, $tbe_ul)) checked @endif>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tbe_lr"
                                                                        id="tbe_lr8"
                                                                        @if (in_array(8, $tbe_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tbe_lr"
                                                                        id="tbe_lr7"
                                                                        @if (in_array(7, $tbe_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tbe_lr"
                                                                        id="tbe_lr6"
                                                                        @if (in_array(6, $tbe_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tbe_lr"
                                                                        id="tbe_lr5"
                                                                        @if (in_array(5, $tbe_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tbe_lr"
                                                                        id="tbe_lr4"
                                                                        @if (in_array(4, $tbe_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tbe_lr"
                                                                        id="tbe_lr3"
                                                                        @if (in_array(3, $tbe_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tbe_lr"
                                                                        id="tbe_lr2"
                                                                        @if (in_array(2, $tbe_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tbe_lr"
                                                                        id="tbe_lr1"
                                                                        @if (in_array(1, $tbe_lr)) checked @endif>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tbe_ll"
                                                                        id="tbe_ll1"
                                                                        @if (in_array(1, $tbe_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tbe_ll"
                                                                        id="tbe_ll2"
                                                                        @if (in_array(2, $tbe_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tbe_ll"
                                                                        id="tbe_ll3"
                                                                        @if (in_array(3, $tbe_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tbe_ll"
                                                                        id="tbe_ll4"
                                                                        @if (in_array(4, $tbe_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tbe_ll"
                                                                        id="tbe_ll5"
                                                                        @if (in_array(5, $tbe_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tbe_ll"
                                                                        id="tbe_ll6"
                                                                        @if (in_array(6, $tbe_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tbe_ll"
                                                                        id="tbe_ll7"
                                                                        @if (in_array(7, $tbe_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tbe_ll"
                                                                        id="tbe_ll8"
                                                                        @if (in_array(8, $tbe_ll)) checked @endif>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                @endif

                                <h5 class="card-title mt-2">Occlusal Plane</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">

                                        <p class="text-muted"><i class="fas fa-check"></i>
                                            {{ ucfirst($patient->occlusal_plane) }} Occlusal Plane</p>
                                        @if (@$patient->occlusal_plane_notes)
                                            <p class="text-muted">{{ $patient->occlusal_plane_notes }}</p>
                                        @endif

                                    </li>
                                </ul>

                                <h5 class="card-title mt-2">Special Instructions</h5>
                                <div class="row">
                                    @if ($patient->fl_posterior_bite_turbos)
                                        <div class="col-xl-6 mb-3">
                                            <div class="card overflow-hidden"
                                                style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_posterior_bite_turbos, PATHINFO_EXTENSION) != 'pdf')
                                                    <div class="card-img-top text-center"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_posterior_bite_turbos) }}"
                                                            data-gallery="gallery-1"><img style="width: 100%;"
                                                                class="img-fluid"
                                                                src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_posterior_bite_turbos) }}"
                                                                alt="General Upload" /></a>
                                                    </div>
                                                @else
                                                    <p class="mb-0 ps-3"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_posterior_bite_turbos) }}"
                                                            download="">Download</a>
                                                    </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Posterior Bite Turbos
                                                        @if (pathinfo($patient->fl_posterior_bite_turbos, PATHINFO_EXTENSION) != 'pdf')
                                                            <a class="float-end text-dark"
                                                                href="{{ url('/patient/picture/print/' . $hashids->encode($patient->patient_id) . '/' . $patient->fl_posterior_bite_turbos) }}"><i
                                                                    class="fa fa-print text-dark"></i></a>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_anterior_bite_turbos)
                                        <div class="col-xl-6 mb-3">
                                            <div class="card overflow-hidden"
                                                style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_anterior_bite_turbos, PATHINFO_EXTENSION) != 'pdf')
                                                    <div class="card-img-top text-center"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_anterior_bite_turbos) }}"
                                                            data-gallery="gallery-1"><img style="width: 100%;"
                                                                class="img-fluid"
                                                                src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_anterior_bite_turbos) }}"
                                                                alt="General Upload" /></a>
                                                    </div>
                                                @else
                                                    <p class="mb-0 ps-3"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_anterior_bite_turbos) }}"
                                                            download="">Download</a>
                                                    </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Anterior Bite Turbos
                                                        @if (pathinfo($patient->fl_anterior_bite_turbos, PATHINFO_EXTENSION) != 'pdf')
                                                            <a class="float-end text-dark"
                                                                href="{{ url('/patient/picture/print/' . $hashids->encode($patient->patient_id) . '/' . $patient->fl_anterior_bite_turbos) }}"><i
                                                                    class="fa fa-print text-dark"></i></a>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_bite_keeper)
                                        <div class="col-xl-6 mb-3">
                                            <div class="card overflow-hidden"
                                                style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_bite_keeper, PATHINFO_EXTENSION) != 'pdf')
                                                    <div class="card-img-top text-center"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_bite_keeper) }}"
                                                            data-gallery="gallery-1"><img style="width: 100%;"
                                                                class="img-fluid"
                                                                src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_bite_keeper) }}"
                                                                alt="General Upload" /></a>
                                                    </div>
                                                @else
                                                    <p class="mb-0 ps-3"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_bite_keeper) }}"
                                                            download="">Download</a>
                                                    </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Bite Keeper
                                                        @if (pathinfo($patient->fl_bite_keeper, PATHINFO_EXTENSION) != 'pdf')
                                                            <a class="float-end text-dark"
                                                                href="{{ url('/patient/picture/print/' . $hashids->encode($patient->patient_id) . '/' . $patient->fl_bite_keeper) }}"><i
                                                                    class="fa fa-print text-dark"></i></a>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_notes)
                                        <div class="col-xl-6 mb-3">
                                            <div class="card overflow-hidden"
                                                style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_notes, PATHINFO_EXTENSION) != 'pdf')
                                                    <div class="card-img-top text-center"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_notes) }}"
                                                            data-gallery="gallery-1"><img style="width: 100%;"
                                                                class="img-fluid"
                                                                src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_notes) }}"
                                                                alt="General Upload" /></a>
                                                    </div>
                                                @else
                                                    <p class="mb-0 ps-3"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_notes) }}"
                                                            download="">Download</a>
                                                    </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Notes @if (pathinfo($patient->fl_notes, PATHINFO_EXTENSION) != 'pdf')
                                                            <a class="float-end text-dark"
                                                                href="{{ url('/patient/picture/print/' . $hashids->encode($patient->patient_id) . '/' . $patient->fl_notes) }}"><i
                                                                    class="fa fa-print text-dark"></i></a>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <ul class="list-group list-group-flush mb-2">
                                    @php
                                        $additional_attachments = [];
                                        if (
                                            $patient->additional_attachments != '' &&
                                            $patient->additional_attachments != null
                                        ) {
                                            $additional_attachments = unserialize($patient->additional_attachments);
                                        }
                                    @endphp
                                    @if (in_array('Posterior Bite Turbos', $additional_attachments))
                                        <li class="list-group-item">

                                            <p class="text-muted"><i class="fas fa-check"></i> Posterior Bite
                                                Turbos</p>

                                        </li>
                                    @endif
                                    @if (in_array('Anterior Bite Turbos', $additional_attachments))
                                        <li class="list-group-item">

                                            <p class="text-muted"><i class="fas fa-check"></i> Anterior Bite
                                                Turbos</p>

                                        </li>
                                    @endif

                                    @php
                                        $add_pontic_ur = [];
                                        if ($patient->add_pontic_ur != '' && $patient->add_pontic_ur != null) {
                                            $add_pontic_ur = unserialize($patient->add_pontic_ur);
                                        }
                                        $add_pontic_ul = [];
                                        if ($patient->add_pontic_ul != '' && $patient->add_pontic_ul != null) {
                                            $add_pontic_ul = unserialize($patient->add_pontic_ul);
                                        }
                                        $add_pontic_lr = [];
                                        if ($patient->add_pontic_lr != '' && $patient->add_pontic_lr != null) {
                                            $add_pontic_lr = unserialize($patient->add_pontic_lr);
                                        }
                                        $add_pontic_ll = [];
                                        if ($patient->add_pontic_ll != '' && $patient->add_pontic_ll != null) {
                                            $add_pontic_ll = unserialize($patient->add_pontic_ll);
                                        }
                                    @endphp
                                    @if (count($add_pontic_ur) > 0 || count($add_pontic_ul) > 0 || count($add_pontic_lr) > 0 || count($add_pontic_ll) > 0)
                                        <h5 class="mb-3 mt-2 card-title">Add Pontic</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_pontic_ur" id="add_pontic_ur8"
                                                                        @if (in_array(8, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_pontic_ur" id="add_pontic_ur7"
                                                                        @if (in_array(7, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_pontic_ur" id="add_pontic_ur6"
                                                                        @if (in_array(6, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_pontic_ur" id="add_pontic_ur5"
                                                                        @if (in_array(5, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_pontic_ur" id="add_pontic_ur4"
                                                                        @if (in_array(4, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_pontic_ur" id="add_pontic_ur3"
                                                                        @if (in_array(3, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_pontic_ur" id="add_pontic_ur2"
                                                                        @if (in_array(2, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_pontic_ur" id="add_pontic_ur1"
                                                                        @if (in_array(1, $add_pontic_ur)) checked @endif
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_pontic_ul" id="add_pontic_ul1"
                                                                        @if (in_array(1, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_pontic_ul" id="add_pontic_ul2"
                                                                        @if (in_array(2, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_pontic_ul" id="add_pontic_ul3"
                                                                        @if (in_array(3, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_pontic_ul" id="add_pontic_ul4"
                                                                        @if (in_array(4, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_pontic_ul" id="add_pontic_ul5"
                                                                        @if (in_array(5, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_pontic_ul" id="add_pontic_ul6"
                                                                        @if (in_array(6, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_pontic_ul" id="add_pontic_ul7"
                                                                        @if (in_array(7, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_pontic_ul" id="add_pontic_ul8"
                                                                        @if (in_array(8, $add_pontic_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_pontic_lr" id="add_pontic_lr8"
                                                                        @if (in_array(8, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_pontic_lr" id="add_pontic_lr7"
                                                                        @if (in_array(7, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_pontic_lr" id="add_pontic_lr6"
                                                                        @if (in_array(6, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_pontic_lr" id="add_pontic_lr5"
                                                                        @if (in_array(5, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_pontic_lr" id="add_pontic_lr4"
                                                                        @if (in_array(4, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_pontic_lr" id="add_pontic_lr3"
                                                                        @if (in_array(3, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_pontic_lr" id="add_pontic_lr2"
                                                                        @if (in_array(2, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_pontic_lr" id="add_pontic_lr1"
                                                                        @if (in_array(1, $add_pontic_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_pontic_ll" id="add_pontic_ll1"
                                                                        @if (in_array(1, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_pontic_ll" id="add_pontic_ll2"
                                                                        @if (in_array(2, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_pontic_ll" id="add_pontic_ll3"
                                                                        @if (in_array(3, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_pontic_ll" id="add_pontic_ll4"
                                                                        @if (in_array(4, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_pontic_ll" id="add_pontic_ll5"
                                                                        @if (in_array(5, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_pontic_ll" id="add_pontic_ll6"
                                                                        @if (in_array(6, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_pontic_ll" id="add_pontic_ll7"
                                                                        @if (in_array(7, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_pontic_ll" id="add_pontic_ll8"
                                                                        @if (in_array(8, $add_pontic_ll)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $add_bite_turbos_ur = [];
                                        if ($patient->add_bite_turbos_ur != '' && $patient->add_bite_turbos_ur != null) {
                                            $add_bite_turbos_ur = unserialize($patient->add_bite_turbos_ur);
                                        }
                                        $add_bite_turbos_ul = [];
                                        if ($patient->add_bite_turbos_ul != '' && $patient->add_bite_turbos_ul != null) {
                                            $add_bite_turbos_ul = unserialize($patient->add_bite_turbos_ul);
                                        }
                                        $add_bite_turbos_lr = [];
                                        if ($patient->add_bite_turbos_lr != '' && $patient->add_bite_turbos_lr != null) {
                                            $add_bite_turbos_lr = unserialize($patient->add_bite_turbos_lr);
                                        }
                                        $add_bite_turbos_ll = [];
                                        if ($patient->add_bite_turbos_ll != '' && $patient->add_bite_turbos_ll != null) {
                                            $add_bite_turbos_ll = unserialize($patient->add_bite_turbos_ll);
                                        }
                                    @endphp
                                    @if (count($add_bite_turbos_ur) > 0 || count($add_bite_turbos_ul) > 0 || count($add_bite_turbos_lr) > 0 || count($add_bite_turbos_ll) > 0)
                                        <h5 class="mb-3 mt-2 card-title">Add Bite Turbos</h5>
                                        <div class="row ">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_bite_turbos_ur" id="add_bite_turbos_ur8"
                                                                        @if (in_array(8, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_bite_turbos_ur" id="add_bite_turbos_ur7"
                                                                        @if (in_array(7, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_bite_turbos_ur" id="add_bite_turbos_ur6"
                                                                        @if (in_array(6, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_bite_turbos_ur" id="add_bite_turbos_ur5"
                                                                        @if (in_array(5, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_bite_turbos_ur" id="add_bite_turbos_ur4"
                                                                        @if (in_array(4, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_bite_turbos_ur" id="add_bite_turbos_ur3"
                                                                        @if (in_array(3, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_bite_turbos_ur" id="add_bite_turbos_ur2"
                                                                        @if (in_array(2, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_bite_turbos_ur" id="add_bite_turbos_ur1"
                                                                        @if (in_array(1, $add_bite_turbos_ur)) checked @endif
                                                                        disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_bite_turbos_ul" id="add_bite_turbos_ul1"
                                                                        @if (in_array(1, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_bite_turbos_ul" id="add_bite_turbos_ul2"
                                                                        @if (in_array(2, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_bite_turbos_ul" id="add_bite_turbos_ul3"
                                                                        @if (in_array(3, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_bite_turbos_ul" id="add_bite_turbos_ul4"
                                                                        @if (in_array(4, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_bite_turbos_ul" id="add_bite_turbos_ul5"
                                                                        @if (in_array(5, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_bite_turbos_ul" id="add_bite_turbos_ul6"
                                                                        @if (in_array(6, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_bite_turbos_ul" id="add_bite_turbos_ul7"
                                                                        @if (in_array(7, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_bite_turbos_ul" id="add_bite_turbos_ul8"
                                                                        @if (in_array(8, $add_bite_turbos_ul)) checked @endif
                                                                        disabled>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">

                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_bite_turbos_lr" id="add_bite_turbos_lr8"
                                                                        @if (in_array(8, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_bite_turbos_lr" id="add_bite_turbos_lr7"
                                                                        @if (in_array(7, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_bite_turbos_lr" id="add_bite_turbos_lr6"
                                                                        @if (in_array(6, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_bite_turbos_lr" id="add_bite_turbos_lr5"
                                                                        @if (in_array(5, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_bite_turbos_lr" id="add_bite_turbos_lr4"
                                                                        @if (in_array(4, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_bite_turbos_lr" id="add_bite_turbos_lr3"
                                                                        @if (in_array(3, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_bite_turbos_lr" id="add_bite_turbos_lr2"
                                                                        @if (in_array(2, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_bite_turbos_lr" id="add_bite_turbos_lr1"
                                                                        @if (in_array(1, $add_bite_turbos_lr)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="add_bite_turbos_ll" id="add_bite_turbos_ll1"
                                                                        @if (in_array(1, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="add_bite_turbos_ll" id="add_bite_turbos_ll2"
                                                                        @if (in_array(2, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="add_bite_turbos_ll" id="add_bite_turbos_ll3"
                                                                        @if (in_array(3, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="add_bite_turbos_ll" id="add_bite_turbos_ll4"
                                                                        @if (in_array(4, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="add_bite_turbos_ll" id="add_bite_turbos_ll5"
                                                                        @if (in_array(5, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="add_bite_turbos_ll" id="add_bite_turbos_ll6"
                                                                        @if (in_array(6, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="add_bite_turbos_ll" id="add_bite_turbos_ll7"
                                                                        @if (in_array(7, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="add_bite_turbos_ll" id="add_bite_turbos_ll8"
                                                                        @if (in_array(8, $add_bite_turbos_ll)) checked @endif
                                                                        disabled>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if (@$patient->additional_attachments_notes != null && @$patient->additional_attachments_notes != '')
                                        <li class="list-group-item">

                                            <p class="text-muted">{{ $patient->additional_attachments_notes }}
                                            </p>

                                        </li>
                                    @endif
                                </ul>
                                <ul class="list-group list-group-flush">

                                    @if (@$patient->keep_already_placed_attachments == 1)
                                        <li class="list-group-item">

                                            <p class="text-muted"><i class="fas fa-check"></i> Keep Already
                                                Placed
                                                Attachments</p>

                                        </li>
                                    @endif

                                    @if (@$patient->aesthetic_start != null)
                                        <li class="list-group-item">
                                            <p class="text-muted"><strong> Aesthetic start:</strong>
                                                {{ $patient->aesthetic_start == '0' ? 'No' : 'Yes' }}
                                            </p>
                                        </li>
                                    @endif

                                    @if (@$patient->anterior_leveling != null)
                                        <li class="list-group-item">
                                            <p class="text-muted">
                                                <strong> Primary Esthetic Objective for Anterior Leveling</strong><br>
                                                @if($patient->anterior_leveling == '0')
                                                    <strong> Incisal Edge Harmony: </strong>Prioritize a consistent smile arc and incisal symmetry (potential gingival discrepancies will be managed post-treatment).
                                                @else
                                                    <strong> Gingival Margin Symmetry: </strong>Prioritize level gingival zeniths (incisal edge discrepancies will be managed via restorative bonding/enameloplasty).
                                                @endif
                                            </p>
                                        </li>
                                    @endif

                                    <li class="list-group-item">
                                        <p class="text-muted">
                                            <strong> Trim Upper:</strong>
                                            {{ $patient->trim_type_upper }}
                                        </p>
                                        @if($patient->trim_type_upper == 'Straight' && $patient->trim_type_upper_straight_upper != null)
                                        <p class="text-muted">
                                            {{ $patient->trim_type_upper_straight_upper == '0' ? 'Standard (1-1.5mm beyond the gingival margins)' : 'High Trim Line (2.5-3mm beyond the gingival margins)'  }}
                                        </p>
                                        @endif
                                    </li>

                                    <li class="list-group-item">

                                        <p class="text-muted">
                                            <strong>Trim Lower:</strong>
                                            {{ $patient->trim_type_lower }}
                                        </p>

                                        @if($patient->trim_type_lower == 'Straight' && $patient->trim_type_upper_straight_upper != null)
                                        <p class="text-muted">
                                            {{ $patient->trim_type_lower_straight_lower == '0' ? 'Standard (1-1.5mm beyond the gingival margins)' : 'High Trim Line (2.5-3mm beyond the gingival margins)'  }}
                                        </p>
                                        @endif
                                    </li>
                                </ul>

                                @php
                                    $tla_ur = [];
                                    if ($patient->tla_ur != '' && $patient->tla_ur != null) {
                                        $tla_ur = unserialize($patient->tla_ur);
                                    }

                                    $tla_ul = [];
                                    if ($patient->tla_ul != '' && $patient->tla_ul != null) {
                                        $tla_ul = unserialize($patient->tla_ul);
                                    }
                                    $tla_lr = [];
                                    if ($patient->tla_lr != '' && $patient->tla_lr != null) {
                                        $tla_lr = unserialize($patient->tla_lr);
                                    }
                                    $tla_ll = [];
                                    if ($patient->tla_ll != '' && $patient->tla_ll != null) {
                                        $tla_ll = unserialize($patient->tla_ll);
                                    }
                                @endphp

                                @if (count($tla_ur) > 0 || count($tla_ul) > 0 || count($tla_lr) > 0 || count($tla_ll) > 0)
                                    <h5 class=" my-3 mt-2 card-title">Last tooth to cover</h5>
                                    <div class="row ">
                                        <div class="col-12">
                                            @if($patient->is_new  == '0')
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header">
                                                                    Right Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tla_ur"
                                                                        id="tla_ur8"
                                                                        @if (in_array(8, $tla_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tla_ur"
                                                                        id="tla_ur7"
                                                                        @if (in_array(7, $tla_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tla_ur"
                                                                        id="tla_ur6"
                                                                        @if (in_array(6, $tla_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tla_ur"
                                                                        id="tla_ur5"
                                                                        @if (in_array(5, $tla_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tla_ur"
                                                                        id="tla_ur4"
                                                                        @if (in_array(4, $tla_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tla_ur"
                                                                        id="tla_ur3"
                                                                        @if (in_array(3, $tla_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tla_ur"
                                                                        id="tla_ur2"
                                                                        @if (in_array(2, $tla_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tla_ur"
                                                                        id="tla_ur1"
                                                                        @if (in_array(1, $tla_ur)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 tw top right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div class="card-header text-end">
                                                                    Left Upper
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tla_ul"
                                                                        id="tla_ul1"
                                                                        @if (in_array(1, $tla_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tla_ul"
                                                                        id="tla_ul2"
                                                                        @if (in_array(2, $tla_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tla_ul"
                                                                        id="tla_ul3"
                                                                        @if (in_array(3, $tla_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tla_ul"
                                                                        id="tla_ul4"
                                                                        @if (in_array(4, $tla_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tla_ul"
                                                                        id="tla_ul5"
                                                                        @if (in_array(5, $tla_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tla_ul"
                                                                        id="tla_ul6"
                                                                        @if (in_array(6, $tla_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tla_ul"
                                                                        id="tla_ul7"
                                                                        @if (in_array(7, $tla_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tla_ul"
                                                                        id="tla_ul8"
                                                                        @if (in_array(8, $tla_ul)) checked @endif>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tla_lr"
                                                                        id="tla_lr8"
                                                                        @if (in_array(8, $tla_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tla_lr"
                                                                        id="tla_lr7"
                                                                        @if (in_array(7, $tla_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tla_lr"
                                                                        id="tla_lr6"
                                                                        @if (in_array(6, $tla_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tla_lr"
                                                                        id="tla_lr5"
                                                                        @if (in_array(5, $tla_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tla_lr"
                                                                        id="tla_lr4"
                                                                        @if (in_array(4, $tla_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tla_lr"
                                                                        id="tla_lr3"
                                                                        @if (in_array(3, $tla_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tla_lr"
                                                                        id="tla_lr2"
                                                                        @if (in_array(2, $tla_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tla_lr"
                                                                        id="tla_lr1"
                                                                        @if (in_array(1, $tla_lr)) checked @endif>
                                                                </div>
                                                                <div class="card-footer">
                                                                    Right Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 px-1 tw bottom right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card shadow-none border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw px-0 px-md-2">

                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="1" name="tla_ll"
                                                                        id="tla_ll1"
                                                                        @if (in_array(1, $tla_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="2" name="tla_ll"
                                                                        id="tla_ll2"
                                                                        @if (in_array(2, $tla_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="3" name="tla_ll"
                                                                        id="tla_ll3"
                                                                        @if (in_array(3, $tla_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="4" name="tla_ll"
                                                                        id="tla_ll4"
                                                                        @if (in_array(4, $tla_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="5" name="tla_ll"
                                                                        id="tla_ll5"
                                                                        @if (in_array(5, $tla_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="6" name="tla_ll"
                                                                        id="tla_ll6"
                                                                        @if (in_array(6, $tla_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="7" name="tla_ll"
                                                                        id="tla_ll7"
                                                                        @if (in_array(7, $tla_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth"
                                                                        data-number="8" name="tla_ll"
                                                                        id="tla_ll8"
                                                                        @if (in_array(8, $tla_ll)) checked @endif>
                                                                </div>
                                                                <div class="card-footer text-end">
                                                                    Left Lower
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="teeth-layout-wrapper" style="max-width: 1200px; margin: 0 auto;">
                                                        <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:5px;" id="classIIUpperArcNew">
                                                            <img id="1" class="choose-tooth" src="{{ in_array(8, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-8.webp') : asset('public/assets/tooth/png/UR-8.webp') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="2" class="choose-tooth" src="{{ in_array(7, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-7.webp') : asset('public/assets/tooth/png/UR-7.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="3" class="choose-tooth" src="{{ in_array(6, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-6.webp') : asset('public/assets/tooth/png/UR-6.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="4" class="choose-tooth" src="{{ in_array(5, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-5.webp') : asset('public/assets/tooth/png/UR-5.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="5" class="choose-tooth" src="{{ in_array(4, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-4.webp') : asset('public/assets/tooth/png/UR-4.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="6" class="choose-tooth" src="{{ in_array(3, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-3.webp') : asset('public/assets/tooth/png/UR-3.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="7" class="choose-tooth" src="{{ in_array(2, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-2.webp') : asset('public/assets/tooth/png/UR-2.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="8" class="choose-tooth" src="{{ in_array(1, $tla_ur) ?  asset('public/assets/tooth/coloured/UR-1.webp') : asset('public/assets/tooth/png/UR-1.webp') }}" style="vertical-align: baseline;width: 1.6vw; height: 1.6vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="9" class="choose-tooth" src="{{ in_array(1, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-1.webp') : asset('public/assets/tooth/png/UL-1.webp') }}" style="vertical-align: baseline;width: 1.6vw; height: 1.6vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="10" class="choose-tooth" src="{{ in_array(2, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-2.webp') : asset('public/assets/tooth/png/UL-2.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="11" class="choose-tooth" src="{{ in_array(3, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-3.webp') : asset('public/assets/tooth/png/UL-3.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="12" class="choose-tooth" src="{{ in_array(4, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-4.webp') : asset('public/assets/tooth/png/UR-4.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="13" class="choose-tooth" src="{{ in_array(5, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-5.webp') : asset('public/assets/tooth/png/UR-5.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="14" class="choose-tooth" src="{{ in_array(6, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-6.webp') : asset('public/assets/tooth/png/UR-6.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="15" class="choose-tooth" src="{{ in_array(7, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-7.webp') : asset('public/assets/tooth/png/UR-7.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px; margin-bottom: 3px;">
                                                            <img id="16" class="choose-tooth" src="{{ in_array(8, $tla_ul) ?  asset('public/assets/tooth/coloured/UL-8.webp') : asset('public/assets/tooth/png/UR-8.webp') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px; margin-bottom: 3px;">
                                                        </div>
                                                        <div class="teeth-divider" style="display:flex; align-items:center; justify-content:center; gap:1rem;">
                                                            <span style="font-weight:bold;">R</span>
                                                            <span style="flex:1; height:1px; background: rgba(177, 175, 175, 0.70);"></span>
                                                            <span style="font-weight:bold;">L</span>
                                                        </div>
                                                        <div class="media img-responsive input-group" style="display:flex; flex-wrap: wrap; justify-content:center; gap:5px; position:relative; padding:0.5rem 0 25px;" id="classIILowerArc">
                                                            <img id="17" class="choose-tooth"  src="{{ in_array(8, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-8.webp') :  asset('public/assets/tooth/png/LR-8.webp') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
                                                            <img id="18" class="choose-tooth"  src="{{ in_array(7, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-7.webp') :  asset('public/assets/tooth/png/LR-7.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
                                                            <img id="19" class="choose-tooth"  src="{{ in_array(6, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-6.webp') :  asset('public/assets/tooth/png/LR-6.webp') }}" style="vertical-align: baseline;width: 1.5vw; height: 1.5vw; margin-top: 5px;">
                                                            <img id="20" class="choose-tooth"  src="{{ in_array(5, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-5.webp') :  asset('public/assets/tooth/png/LR-5.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
                                                            <img id="21" class="choose-tooth"  src="{{ in_array(4, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-4.webp') :  asset('public/assets/tooth/png/LR-4.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
                                                            <img id="22" class="choose-tooth"  src="{{ in_array(3, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-3.webp') :  asset('public/assets/tooth/png/LR-3.webp') }}" style="vertical-align: baseline;width: 1.35vw; height: 1.35vw; margin-top: 5px;">
                                                            <img id="23" class="choose-tooth"  src="{{ in_array(2, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-2.webp') :  asset('public/assets/tooth/png/LR-2.webp') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
                                                            <img id="24" class="choose-tooth"  src="{{ in_array(1, $tla_lr) ?  asset('public/assets/tooth/coloured/LR-1.webp') :  asset('public/assets/tooth/png/LR-1.webp') }}" style="vertical-align: baseline;width: 1.15vw; height: 1.15vw; margin-top: 5px;">
                                                            <img id="25" class="choose-tooth"  src="{{ in_array(1, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-1.webp') :  asset('public/assets/tooth/png/LL-1.webp') }}" style="vertical-align: baseline;width: 1.15vw; height: 1.15vw; margin-top: 5px;">
                                                            <img id="26" class="choose-tooth"  src="{{ in_array(2, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-2.webp') :  asset('public/assets/tooth/png/LL-2.webp') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
                                                            <img id="27" class="choose-tooth"  src="{{ in_array(3, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-3.webp') :  asset('public/assets/tooth/png/LL-3.webp') }}" style="vertical-align: baseline;width: 1.35vw; height: 1.35vw; margin-top: 5px;">
                                                            <img id="28" class="choose-tooth"  src="{{ in_array(4, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-4.webp') :  asset('public/assets/tooth/png/LL-4.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
                                                            <img id="29" class="choose-tooth"  src="{{ in_array(5, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-5.webp') :  asset('public/assets/tooth/png/LL-5.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
                                                            <img id="30" class="choose-tooth"  src="{{ in_array(6, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-6.webp') :  asset('public/assets/tooth/png/LL-6.webp') }}" style="vertical-align: baseline;width: 1.5vw; height: 1.5vw; margin-top: 5px;">
                                                            <img id="31" class="choose-tooth"  src="{{ in_array(7, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-7.webp') :  asset('public/assets/tooth/png/LL-7.webp') }}" style="vertical-align: baseline;width: 1.3vw; height: 1.3vw; margin-top: 5px;">
                                                            <img id="32" class="choose-tooth"  src="{{ in_array(8, $tla_ll) ?  asset('public/assets/tooth/coloured/LL-8.webp') :  asset('public/assets/tooth/png/LL-8.webp') }}" style="vertical-align: baseline;width: 1.2vw; height: 1.2vw; margin-top: 5px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>

                @if(@$clinicalPreference)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingClinicalPrefs">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseClinicalPrefs" aria-expanded="false" aria-controls="collapseClinicalPrefs">
                                Clinical Preferences
                            </button>
                        </h2>
                        <div class="accordion-collapse collapse" id="collapseClinicalPrefs" aria-labelledby="headingClinicalPrefs" data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <div class="container-fluid px-0">
                                    <h5 class="card-title">Clinical Preferences</h5>
                                    <ul class="list-group list-group-flush">
                                        @if(@$clinicalPreference->anterior_teeth_leveling)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Anterior Teeth Leveling:</strong> {{ $clinicalPreference->anterior_teeth_leveling }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->pontics_selection)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Pontics Selection:</strong> {{ $clinicalPreference->pontics_selection }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->arch_expansion)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Arch Expansion:</strong> {{ $clinicalPreference->arch_expansion }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->derotation)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Derotation:</strong> {{ $clinicalPreference->derotation }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->long_axis)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Long Axis:</strong> {{ $clinicalPreference->long_axis }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->crossbite)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Crossbite:</strong> {{ $clinicalPreference->crossbite }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->intrusion)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Intrusion:</strong> {{ $clinicalPreference->intrusion }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->extrusion)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Extrusion:</strong> {{ $clinicalPreference->extrusion }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->rotation_aligner)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Rotation per Aligner:</strong> {{ $clinicalPreference->rotation_aligner }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->translation_aligner)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Translation per Aligner:</strong> {{ $clinicalPreference->translation_aligner }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->intrusion_extrusion_aligner)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Intrusion/Extrusion per Aligner:</strong> {{ $clinicalPreference->intrusion_extrusion_aligner }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->sequential_distalization_mesialisation)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Sequential Distalization/Mesialisation:</strong> {{ $clinicalPreference->sequential_distalization_mesialisation }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->same_number_aligners_for_both_arches)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Same Number of Aligners for Both Arches:</strong> {{ $clinicalPreference->same_number_aligners_for_both_arches }}</p>
                                                @if(@$clinicalPreference->same_number_aligners_type)
                                                    <p class="text-muted mb-0 ms-3">Type: {{ $clinicalPreference->same_number_aligners_type }}</p>
                                                @endif
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->en_masse_distalization)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>En Masse Distalization:</strong> {{ $clinicalPreference->en_masse_distalization }}</p>
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->ipr_preference)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>IPR Preference:</strong> {{ $clinicalPreference->ipr_preference }}</p>
                                                @if(@$clinicalPreference->ipr_max_limit)
                                                    <p class="text-muted mb-0 ms-3">Max Limit: {{ $clinicalPreference->ipr_max_limit }} mm</p>
                                                @endif
                                            </li>
                                        @endif
                                        @if(@$clinicalPreference->additional_comments)
                                            <li class="list-group-item">
                                                <p class="text-muted mb-0"><strong>Additional Comments:</strong></p>
                                                <p class="text-muted mb-0">{{ $clinicalPreference->additional_comments }}</p>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if ($patient->is_submitted != 0 && Auth::user()->role == $patient->case_holder && (Auth::user()->role != 'lab' || DB::table('lab_requests')->where('treatment_plan_id', @$patient->id)->where('user_id', Auth::user()->id)->where('is_canceled', 0)->exists()))
        {{-- @dd($patient); --}}
        @if ($patient->is_rejected == 1 || $patient->is_cancelled == 1)
            @if ($patient->is_cancelled == 1)
                <div class="card">
                    <div class="card-body py-4">
                        <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                            <div class="bg-danger me-3 icon-item"><span
                                    class="fas fa-times-circle text-white fs-3"></span>
                            </div>
                            <p class="mb-0 flex-1">Treatment plan has been <strong>cancelled</strong>! The setup
                                is not
                                confirmed within 30 days after setup confirmation request.</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body py-4">
                        <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                            <div class="bg-danger me-3 icon-item"><span
                                    class="fas fa-times-circle text-white fs-3"></span>
                            </div>
                            <p class="mb-0 flex-1">Treatment plan has been <strong>rejected</strong> by staff!</p>
                        </div>
                    </div>
                </div>
            @endif
        @else
            {{-- 532 --}}
            @if (($patient->is_completed == 0 || Auth::user()->role == 'staff' || Auth::user()->role == 'lab') && ($patient->is_submitted == 0 || $patient->is_editable == 0))
                <div class="card" id="panel">
                    <div class="card-body py-4">
                        <div class="mb-3">
                            <label>Comment</label>
                            <textarea class="form-control" name="comment" id="comment" placeholder="Write the comment here"></textarea>
                        </div>

                        <div class="mb-3">
                            <label>Attachments (Optional)</label>
                            <input type="file" class="form-control" name="attachments[]" id="attachments"
                                multiple>
                        </div>

                        @if (Auth::user()->role == 'doctor')
                            @if ($patient->is_treatment_submitted == 1 && $patient->is_completed == 0)
                                @php
                                    $calculation = new \App\Http\Services\PriceCalculation();
                                    $final_deposit = $calculation->calc(Auth::user()->tier, $patient);

                                @endphp
                                @if ($final_deposit != 0)
                                    <div class="alert alert-success border-2 d-flex align-items-center"
                                        role="alert">
                                        <div class="bg-success me-3 icon-item"><span
                                                class="fas fa-check-circle text-white fs-3"></span>
                                        </div>
                                        <p class="mb-0 flex-1">You have to pay final amount of
                                            <strong>€{{ number_format($final_deposit, 2) }}</strong>. Click
                                            "Approve" to
                                            complete case.
                                        </p>

                                    </div>
                                @endif
                                <div class="mb-3 ps-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="terms2" type="checkbox"
                                            name="terms2" value="1" />
                                        <label class="form-check-label" for="terms2">I did not change the
                                            current set up. Please click on (<b class="text-danger">Request
                                                Modification</b>), if you apply any modifications to the current
                                            setup.</label>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if (Auth::user()->role == 'lab' && $patient->case_holder == 'lab')
                            <div class="mb-3">
                                <label>Files Link</label>
                                <input class="form-control hyperlink" placeholder="https://"
                                    value="{{ $patient->treatment_link }}" name="treatment_link"
                                    id="treatment_link">
                            </div>
                            <div class="mb-3">
                                <label>Doctor's Nemo Link</label>
                                <input class="form-control hyperlink" placeholder="https://"
                                    value="{{ $patient->iframe_link }}" name="iframe_link" id="iframe_link">
                            </div>
                            <div class="mb-3">
                                <label>Patient's Nemo Link</label>
                                <input class="form-control hyperlink patient_link" placeholder="https://"
                                    value="{{ $patient->patient_link }}" name="patient_link"
                                    id="patient_link">
                            </div>
                        <!--   <div class="mb-3 d-flex align-items-center gap-3">-->
                        <!--    <label for="patientOption" class="me-2 mb-0">Select Option:</label>-->

                        <!--    <select id="patientOption" name="patient_option" class="form-select w-auto">-->
                        <!--        <option value="view" {{ $patient->link_type == 'view' ? 'selected' : '' }}>Advanced Viewer</option>-->
                        <!--        <option value="edit" {{ $patient->link_type == 'edit' ? 'selected' : '' }}>Editor</option>-->
                        <!--    </select>-->

                        <!--    <a href="{{ route('patient.nemo.link', $hashids->encode($patient->patient_id)) }}"-->
                        <!--       class="btn btn-primary rounded-pill px-2 py-2 shadow-sm"-->
                        <!--       id="patientNemoBtn">-->
                        <!--       Sync Nemo Link-->
                        <!--    </a>-->
                        <!--</div>-->
                       <div class="mb-3 d-flex align-items-center gap-3">
                            <label for="patientOption" class="me-2 mb-0 fw-semibold">
                                Select Nemo Sync Option
                            </label>

                            <select id="patientOption" name="patient_option"
                                class="form-select stylish-dropdown-half fw-medium border-0 shadow-sm"
                                onchange="syncNemoLink(this)">
                                <option value="">Please select option</option>
                                <option value="view" {{ $patient->link_type == 'view' ? 'selected' : '' }}>Advanced Viewer</option>
                                <option value="edit" {{ $patient->link_type == 'edit' ? 'selected' : '' }}>Editor</option>
                            </select>
                        </div>



                        @endif

                        @if (Auth::user()->role == 'staff' && $patient->case_holder == 'staff')
                            @if ($patient->treatment_link != null)
                                <div class="mb-3">
                                    <label>Files Link</label>
                                    <input class="form-control hyperlink" placeholder="https://"
                                        value="{{ $patient->treatment_link }}" name="treatment_link"
                                        id="treatment_link">
                                </div>
                            @endif
                            @if ($patient->is_treatment_submitted == 0 && $patient->is_continue == 0)
                                <div class="mb-3">
                                    <label>Lab</label>
                                    <select class="form-select" name="lab" id="lab">
                                        <option value="" disabled selected>Select Lab</option>
                                        @foreach ($labs as $lab)
                                            <option value="{{ $lab->id }}">{{ $lab->first_name }}
                                                {{ $lab->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if ($patient->is_sent_to_lab == 1 && $patient->is_treatment_submitted == 1 )
                                <div class="mb-3">
                                    <label>No. of Steps (Aligner)</label>
                                    <input type="number" name="no_of_steps" id="no_of_steps"
                                        @if ($patient->aligner_steps != 0) value="{{ $patient->aligner_steps }}" @endif
                                        class="form-control" placeholder="No. of Steps">
                                </div>
                            {{-- @else
                                <div class="mb-3" style="display: none">
                                    <label>No. of Steps (Aligner)</label>
                                    <input type="number" name="no_of_steps" id="no_of_steps"
                                        @if ($patient->aligner_steps != 0) value="{{ $patient->aligner_steps }}" @endif
                                        class="form-control" placeholder="No. of Steps">
                                </div> --}}
                            @endif

                            @if ($patient->is_completed == 1 || $patient->is_continue == 1)
                                <div class="mb-3">
                                    <label>Tracking Nr.</label>
                                    <input type="text" name="tracking_id" id="tracking_id"
                                        value="{{ @$patient->tracking_id }}" placeholder="https://"
                                        class="form-control hyper link">
                                </div>
                            @endif

                        @endif


                        <div class="btn-group" style="flex-wrap: wrap; gap: 6px; ">
                            {{-- doctor button start --}}
                            @if (Auth::user()->role == 'doctor' && $patient->case_holder == 'doctor')
                                @if ($patient->is_completed == 0)
                                    @if ($patient->is_treatment_submitted == 1 && $patient->is_sent_to_lab == 1)
                                        <button class="btn btn-success rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                            id="approve">
                                            <span class="fas fa-check-circle me-1"
                                                data-fa-transform="shrink-3"></span>
                                            Approve Treatment Plan
                                        </button>
                                    @endif
                                    {{-- Done By Parth --}}
                                    @if($patient->send_for_approval == 0)
                                        <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action case-overview-btn" type="button" id="doctor-send-to-staff">
                                            <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send for Modification
                                        </button>
                                    @else
                                        <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action case-overview-btn" type="button" id="doctor-send-to-staff-request-modification">
                                            <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Request Modification
                                        </button>
                                    @endif

                                    @if (Auth::user()->role == 'doctor' && $patient->is_editable == 0 && $patient->is_submitted != 0)
                                        @if (($patient->is_treatment_submitted == 0) ||
                                                ($patient->is_treatment_submitted == 1))
                                                <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action case-overview-btn" data-bs-toggle="modal" data-bs-target="#send-to-Advisor-Modal" type="button" id="send-to-advisor">
                                                    <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to Advisor
                                                </button>
                                        @endif
                                    @endif

                                @endif
                            @endif

                            {{-- doctor button end --}}
                            {{-- staff button start --}}

                            @if (Auth::user()->role == 'staff' && $patient->case_holder == 'staff')
                                @if ($patient->is_treatment_submitted == 1 && $patient->is_completed == 0 && $patient->is_continue == 0)
                                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action case-overview-btn" data-send_back_to_doctor_status="0"
                                        type="button" id="staff-send-to-doctor-for-approval">
                                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>
                                        Send to the Doctor for Approval
                                    </button>
                                @endif

                                @if ($patient->recommended_advisor != null && $patient->is_completed == 0 && $patient->is_continue == 0)
                                    @php
                                        $advisorDetails = DB::table('users')->where('id', $patient->recommended_advisor)->first();
                                    @endphp
                                    @if ($patient->advisor_id == null)
                                        <button class="btn btn-info rounded-pill me-1 mb-1 btn-action case-overview-btn" id="send-to-advisor" >
                                            <span class="fas fa-cube me-2"></span>SEND TO {{ $advisorDetails->first_name }} {{ $advisorDetails->last_name }}
                                            (€{{ $advisorDetails->advisor_price }})
                                        </button>

                                        <!-- Advisor Modal Start -->
                                    @endif
                                    @if ($patient->advisor_id != null)
                                        <button class="btn btn-info rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                            data-bs-toggle="modal" data-bs-target="#advisorModal">
                                            <span class="fas fa-cube me-2"></span>SEND MOD. TO1 ➡ {{ $advisorDetails->first_name }} {{ $advisorDetails->last_name }}
                                            (€{{ $advisorDetails->advisor_price }})
                                        </button>
                                    @endif
                                    <div class="modal fade" id="advisorModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Send to
                                                        Advisor</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                                <select class="form-contorl form-select"
                                                                    name="advisor" required>
                                                                    {{-- <option value="{{ $advisor->id }}"
                                                                        selected>{{ $advisor->first_name }}
                                                                        {{ $advisor->last_name }}
                                                                        (€{{ $advisor->advisor_price }})</option> --}}
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
                                                    <button type="submit" class="btn btn-primary">Send to
                                                        Advisor</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($patient->is_treatment_submitted == 0 || ($patient->is_continue == 1 || $patient->patient_link == null))
                                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action case-overview-btn" data-staff-send-to-doctor-for-approval="0"
                                        type="button" id="staff-send-to-doctor">
                                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to the Doctor for Modification
                                    </button>
                                @endif

                                @if ($patient->is_treatment_submitted == 0 && $patient->is_continue == 0)
                                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="request-treatment">
                                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to Lab
                                    </button>
                                @endif

                                @if ($patient->is_treatment_submitted == 1 &&
                                        $patient->is_approved == 0 &&
                                        $patient->is_completed == 0 &&
                                        $patient->is_continue == 0)
                                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="send-to-lab-for-modification">
                                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to Lab for modification
                                    </button>
                                @endif

                                @if (($patient->is_completed == 1) && $patient->tracking_id == null)
                                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action case-overview-btn" data-send_back_to_doctor_status="0"
                                        type="button" id="staff-send-to-doctor-for-approval">
                                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>
                                        Send to the Doctor for Approval
                                    </button>
                                @endif

                                @if (($patient->is_completed == 1 || $patient->is_continue == 1) && $patient->tracking_id == null)
                                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="staff-submit-tracking-id">
                                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>
                                        Submit Tracking Nr.
                                    </button>
                                @endif



                                @if ($patient->is_continue == 1 || $patient->is_completed == 1)
                                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="staff-send-to-lab">
                                        <span class="fas fa-share me-1"
                                            data-fa-transform="shrink-3"></span>Request Files
                                    </button>
                                @endif

                                @if (($patient->is_completed == 1) && $patient->tracking_id == null)
                                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="staff-reject-treatment">
                                        <span class="fas fa-tint-slash me-1"
                                            data-fa-transform="shrink-3"></span>Reject Treatment
                                    </button>
                                @endif

                                @if ($patient->is_completed == 0)
                                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="staff-reject-treatment">
                                        <span class="fas fa-tint-slash me-1"
                                            data-fa-transform="shrink-3"></span>Reject Treatment
                                    </button>
                                @endif
                            @endif
                            {{-- staff button end --}}

                            {{-- lab button start --}}
                            @if (Auth::user()->role == 'lab' && $patient->case_holder == 'lab')
                                @if ($patient->is_treatment_submitted == 0 && $patient->is_continue == 0)
                                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="submit-treatment">
                                        <span class="fas fa-share me-1"
                                            data-fa-transform="shrink-3"></span>Submit
                                        Treatment
                                    </button>
                                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="lab-cancel-request">
                                        <span class="fas fa-tint-slash" data-fa-transform="shrink-3"></span> Cancel Request
                                    </button>
                                @endif
                                @if ($patient->is_treatment_submitted == 1 || $patient->is_continue == 1)
                                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="submit-files">
                                        <span class="fas fa-share me-1"
                                            data-fa-transform="shrink-3"></span>Submit Files
                                    </button>
                                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action case-overview-btn"
                                        type="button" id="lab-cancel-request">
                                        <span class="fas fa-tint-slash"
                                            data-fa-transform="shrink-3"></span> Cancel Request
                                    </button>
                                @endif

                            @endif

                            {{-- lab button end --}}
                            {{-- advisor button start --}}
                            @if (Auth::user()->role == 'advisor' && $patient->recommended_advisor == Auth::id() && $patient->case_holder == 'advisor')
                                <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action case-overview-btn" type="button"
                                    id="advisor-send-to-doctor">
                                    <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send for
                                    Review
                                </button>
                            @endif
                            {{-- advisor button end --}}
                        </div>
                    </div>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    @if (Auth::user()->role == 'doctor' && $patient->is_editable == 0 && $patient->is_submitted != 0)
                        @if (($patient->is_treatment_submitted == 0) ||
                                ($patient->is_treatment_submitted == 1))

                                <div class="modal fade" id="send-to-Advisor-Modal" tabindex="-1" aria-labelledby="sendToAdvisorModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sendToAdvisorModalLabel">Send to Advisor</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form id="sendToAdvisor" method="POST" action="{{ url('/patient/case-overview/send-from-doctor-to-staff-for-advisor') }}"> @csrf

                                                <div class="modal-body">
                                                    <input type="hidden" name="treatment_plan_id" value="{{ $patient->id }}" />
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label>Choose Advisor</label>
                                                            <select class="form-contorl form-select" name="advisor"
                                                                id="advisor_doc" required>
                                                                <option value="">Select Advisor</option>
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
                                                                <textarea class="form-control" name="comment" id="comment_advisor" placeholder="Write the comment here"></textarea>
                                                            </div>
                                                        </div>

                                                        <div id="additionalDivs" class="">
                                                            <div class="mb-3 ps-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" id="consultant_agreement"
                                                                        type="checkbox" name="consultant_agreement"
                                                                        value="3" required />
                                                                    <label class="form-check-label" for="consultant_agreement">
                                                                        Please note that this consultation incurs an additional fee.
                                                                        You will be billed directly by the selected advisory bureau.
                                                                        Ordering an additional consultation may delay the delivery
                                                                        of your treatment plan by up to 7 days, depending on the
                                                                        selected advisory bureau.
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary " id="doctor-advisor-submit-btn">Send to Advisor</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            {{-- <label><strong>Send to Advisor</strong></label>
                            <hr> --}}

                        @endif
                    @endif

                    @if ($patient->patient_link != null && Auth::user()->role == 'doctor')
                        <button class="btn btn-info rounded-pill me-1 mb-1" data-bs-toggle="modal" data-bs-target="#docSendModal">
                            Send Treatment Plan to Patient
                        </button>
                    @endif
                </div>
            </div>
        @endif
    @endif

    @if (
    Auth::user()->role == 'doctor' &&
    in_array($patient->case_holder, ['lab', 'staff', 'advisor']) &&
    $patient->is_editable == 0 &&
    $patient->is_submitted != 0
)
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                @if (is_null($patient->recommended_advisor) &&  in_array($patient->is_treatment_submitted, [0, 1]))
                    <label><strong>Send to Advisor</strong></label>
                    <hr>
                    <form id="sendToAdvisor" method="POST" action="{{ url('/patient/case-overview/send-from-doctor-to-staff-for-advisor') }}">
                        @csrf
                        <input type="hidden" name="treatment_plan_id" value="{{ $patient->id }}" />

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label>Choose Advisor</label>
                                <select class="form-control form-select" name="advisor" id="advisor_doc" required>
                                    <option value="">Select Advisor</option>
                                    @foreach ($advisors as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->first_name }} {{ $item->last_name }} (€{{ $item->advisor_price }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label>Comment for Advisor</label>
                                    <textarea class="form-control" name="comment" id="comment_advisor" placeholder="Write the comment here"></textarea>
                                </div>
                            </div>

                            <div id="additionalDivs">
                                <div class="mb-3 ps-2">
                                    <div class="form-check">
                                        <input class="form-check-input" id="consultant_agreement" type="checkbox" name="consultant_agreement" value="3" required />
                                        <label class="form-check-label" for="consultant_agreement">
                                            Please note that this consultation incurs an additional fee. You will be billed directly by the selected advisory bureau.
                                            Ordering an additional consultation may delay the delivery of your treatment plan by up to 7 days, depending on the selected advisory bureau.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <button type="submit" id="doctor-advisor-submit-btn" class="btn btn-primary rounded-pill me-1 mb-1">
                                    Send to Advisor
                                </button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>

            @if ($patient->patient_link && Auth::user()->role == 'doctor')
                <div class="col-md-8">
                    <button class="btn btn-info rounded-pill me-1 mb-1" data-bs-toggle="modal" data-bs-target="#docSendModal">
                        Send Treatment Plan to Patient
                    </button>
                </div>
            @endif
        </div>
    </div>
@endif
</div>


