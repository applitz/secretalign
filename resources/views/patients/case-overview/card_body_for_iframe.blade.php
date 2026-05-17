<div class="row gx-2">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body py-4" id="card-body-for-iframe">

                <p><strong>Name:</strong> {{ $patient->first_name . ' ' . $patient->last_name }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->dob }}</p>
                <p><strong>Treatment Type:</strong> {{ $patient->treatment_type == 1 ? 'Treatment Plan Service' : 'Aligners Full-Service' }}</p>
                @if ($patient->fl_upper_arch && $patient->fl_lower_arch && $patient->is_treatment_submitted == 0 && !@$patient->iframe_link)
                    <div class="container-fluid mx-0 my-3" id="hide-on-paste">
                        <div class="row mb-3">
                            <div class="col-xl-12 d-none">
                                <div class="progress mb-3" id="progress-wrapper" style="height: 30px;">
                                    <div id="loading-bar" class="progress-bar bg-success progress-bar-striped"
                                        role="progressbar" style="width: 2%" aria-valuenow="2" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="btn-group float-end view-btns" role="group"
                                    aria-label="Basic radio toggle button group">
                                    <input data-cameraz="10" data-camerax="0" data-visible="1" type="radio"
                                        class="btn-check model-control" name="btnradio" id="labial"
                                        autocomplete="off">
                                    <label class="btn btn-outline-primary btn-square" for="labial">Front</label>
                                    <input data-camerax="-10" data-visible="1" type="radio"
                                        class="btn-check model-control" name="btnradio" id="right_buccal"
                                        autocomplete="off">
                                    <label class="btn btn-outline-primary btn-square" for="right_buccal">Right
                                        Buccal</label>
                                    <input data-camerax="10" data-visible="1" type="radio"
                                        class="btn-check model-control" name="btnradio" id="left_buccal"
                                        autocomplete="off">
                                    <label class="btn btn-outline-primary btn-square" for="left_buccal">Left
                                        Buccal</label>
                                    <input data-camerax="-10" type="radio" class="btn-check model-control"
                                        name="btnradio" id="maxillary" autocomplete="off">
                                    <label class="btn btn-outline-primary btn-square btn-square" for="maxillary">Upper
                                        Occlusal</label>
                                    <input data-camerax="10" type="radio" class="btn-check model-control"
                                        name="btnradio" id="mandibular" autocomplete="off">
                                    <label class="btn btn-outline-primary btn-square" for="mandibular">Lower
                                        Occlusal</label>
                                </div>
                                <div class="p-3">
                                    <h6 class="mb-3 mt-0">Rotate Vertically</h6>
                                    <input type="range" class="form-range" id="slider">
                                </div>
                                @if (!@$patient->iframe_link)
                                    <div id="canvas" class="canvas-bg"></div>
                                @endif

                                <div class="btn-group float-end btns-steps" role="group"
                                    aria-label="Basic radio toggle button group d-block"
                                    style="display:none !important;">
                                    <?php
                                    $step = 1;
                                    ?>
                                    <input data-maxillary="<?php echo $upper_arch_stl; ?>" data-mandibular="<?php echo $lower_arch_stl; ?>"
                                        data-cameraz="10" data-camerax="0" data-visible="1" type="radio"
                                        class="btn-check step-control" name="step-trigger"
                                        id="step-{{ $step }}" autocomplete="off">
                                    <label class="btn btn-outline-primary btn-square step-trigger"
                                        for="step-<?php echo $step; ?>">
                                        <?php //if ($step !== $totalSteps){ echo $step; } else { echo 'Att'; }
                                        ?>
                                        <?php echo $step; ?>
                                    </label>

                                </div>
                                <div class="mb-3 mt-3 d-none">
                                    <!-- <label for="customRange2" class="form-label">Example range</label> -->
                                    <input value="0" type="range" class="form-range" min="0"
                                        max="<?php echo 1 - 1; ?>" id="customRange2" step="1">
                                </div>
                                <div class="btn-group d-none" aria-label="Basic example" role="group">
                                    <button id="play-button" type="button" class="btn btn-outline-primary btn-square">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!-- $patient->is_treatment_submitted == 1 -->
                @if (@$patient->iframe_link)
                    @if(@$patient->link_type == 'edit')
                    <?php $simseToken = getSimseToken($patient->first_name,$patient->last_name,$patient->dob,$patient->user_id);?>
                    <iframe onload="authenticate('{{$simseToken}}', '{{ $patient->iframe_link }}')"     id="nemoPortal" width="100%" height="700" style="min-height: 700px";     src="{{ $patient->iframe_link }}">
                    </iframe>
                    @else
                    <iframe src="{{ $patient->iframe_link }}" width="100%" height="700" style="min-height: 700px;"></iframe>
                    @endif
                    <!--<div class="row mt-5">-->
                    <!--        <div class="col-md-12">-->
                    <!--            <a href="{{ route('iframe', request()->phase) }}" class="btn btn-primary"-->
                    <!--                target="_blank">View on full screen</a>-->
                    <!--        </div>-->
                    <!--            <div class="accordion-body">-->
                    <!--                <div class="mb-3 d-flex align-items-center gap-3">-->
                                        <!--<label for="patientOption" class="me-2 mb-0 fw-semibold">-->
                                        <!--    Select Nemo Sync Option-->
                                        <!--</label>-->

                    <!--                    <select id="patientOption" name="patient_option"-->
                    <!--                        class="form-select stylish-dropdown-half fw-medium border-0 shadow-sm"-->
                    <!--                        onchange="syncNemoLink(this)">-->
                    <!--                        <option value="">Please select option</option>-->
                    <!--                        <option value="view" {{ $patient->link_type == 'view' ? 'selected' : '' }}>Advanced Viewer</option>-->
                    <!--                        <option value="edit" {{ $patient->link_type == 'edit' ? 'selected' : '' }}>Editor</option>-->
                    <!--                    </select>-->
                    <!--                </div>-->
                    <!--            </div>-->
                    <!--    </div>-->

                    <div class="row mt-5">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center gap-3">
                                <!-- Full Screen Button -->
                                <a href="{{ route('iframe', request()->phase) }}"
                                   class="btn btn-primary"
                                   target="_blank">
                                   View on Full Screen
                                </a>
                                @if($role && ($role == 'staff' || $role == 'doctor'))
                                    @if($patient->status == 'Treatment Plan Completed' || $patient->status == 'Doctor requests a Modification to Setup 1')
                                    <select id="patientOption" name="patient_option"
                                        class="form-select stylish-dropdown-half fw-medium border-0 shadow-sm"
                                        onchange="syncNemoLink(this)">
                                        <option value="">Please select option</option>
                                        <option value="view" {{ $patient->link_type == 'view' ? 'selected' : '' }}>Advanced Viewer</option>
                                        <option value="edit" {{ $patient->link_type == 'edit' ? 'selected' : '' }}>Editor</option>
                                    </select>
                                    @endif
                                @endif
                                @if($role && ($role == 'lab'))
                                    @if($patient->status == 'Treatment Plan Completed' || $patient->status == 'Doctor requests a Modification to Setup 1' || $patient->status == 'Treatment Plan Approved' )
                                    <select id="patientOption" name="patient_option"
                                            class="form-select stylish-dropdown-half fw-medium shadow-sm"
                                            onchange="syncNemoLink(this)">
                                        <option value="">Please select option</option>
                                        <option value="view" {{ $patient->link_type == 'view' ? 'selected' : '' }}>Advanced Viewer</option>
                                        <option value="edit" {{ $patient->link_type == 'edit' ? 'selected' : '' }}>Editor</option>
                                    </select>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

