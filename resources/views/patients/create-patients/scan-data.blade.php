{{-- scan Data Start --}}

<style>
    /* Responsive auto-fit styling for Scan Data Tab */
    #pill-tab-div2 {
        --scan-dz-size: 225px;
    }
    #pill-tab-div2 .scan-dz-col {
        width: calc(var(--scan-dz-size, 225px) + 24px) !important;
        min-width: calc(var(--scan-dz-size, 225px) + 24px) !important;
        flex: 0 0 auto;
    }
    #pill-tab-div2 ._dropzone {
        width: var(--scan-dz-size, 225px) !important;
        height: var(--scan-dz-size, 225px) !important;
        min-height: var(--scan-dz-size, 225px) !important;
        max-height: var(--scan-dz-size, 225px) !important;
        background-position: center !important;
        background-size: contain !important;
        background-repeat: no-repeat !important;
        border-radius: 8px;
        margin: 0 auto 2px auto !important;
        transition: height 0.15s ease;
    }
    #pill-tab-div2 ._dropzone_added,
    #pill-tab-div2 ._dropzone_hover,
    #pill-tab-div2 ._dropzone_loading,
    #pill-tab-div2 ._dropzone_remove {
        width: 100% !important;
        height: 100% !important;
        border-radius: 6px;
    }
    #pill-tab-div2 ._dropzone img {
        width: clamp(28px, calc(var(--scan-dz-size, 225px) * 0.25), 44px) !important;
        height: clamp(28px, calc(var(--scan-dz-size, 225px) * 0.25), 44px) !important;
    }
    #pill-tab-div2 ._dropzone span {
        font-size: clamp(10px, calc(var(--scan-dz-size, 225px) * 0.075), 13px);
    }
    #pill-tab-div2 .scan-arch-label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 2px;
        text-align: center;
        display: block;
    }
    #pill-tab-div2 .scan-progress-wrap {
        width: 100%;
        margin-bottom: 2px;
    }
    #pill-tab-div2 .scan-progress-wrap .progress {
        height: 12px;
        font-size: 10px;
    }
    #pill-tab-div2 .scan-preview-box {
        width: 100%;
        margin-top: 10px;
        margin-bottom: 2px;
        overflow: hidden;
        text-align: center;
    }
    #pill-tab-div2 .scan-preview-box:empty {
        display: none;
        margin: 0;
    }
    #pill-tab-div2 .scan-preview-box canvas {
        display: block;
        margin: 0 auto;
        border-radius: 6px;
        max-width: 100% !important;
        height: auto !important;
    }
    #pill-tab-div2 .scan-quick-notes {
        font-size: 12px;
        line-height: 1.45;
        margin-top: 14px !important;
        margin-bottom: 8px !important;
    }
    #pill-tab-div2 .scan-quick-notes-box {
        background-color: #f0f7ff;
        border: 1px solid #cce3ff;
        border-left: 4px solid #1C8484;
        border-radius: 6px;
        padding: 8px 14px;
    }
    #pill-tab-div2 .scan-quick-notes-box span {
        display: block;
    }
    #pill-tab-div2 .order-from-button {
        width: auto !important;
        min-width: 160px;
        max-width: 225px;
        margin: 2px 0 !important;
    }
    #pill-tab-div2 .scan-footer-buttons {
        margin-top: 8px !important;
        margin-bottom: 0 !important;
    }
</style>

<div class="tab-pane fade {{ (isset($activeTab) ? $activeTab == 'pill-tab-div2' : ($baseUrl !== null && $code !== null)) ? 'show active' : '' }} " id="pill-tab-div2" role="tabpanel">

    @if($patient->dm_order_status !== null)
        <div class="alert alert-warning border-2 d-flex align-items-center mb-2" role="alert">
            <div class="bg-warning me-3 icon-item">
                <span class="fas fa-exclamation-circle text-white fs-3"></span>
            </div>
            <p class="mb-0 flex-1">
                @if ($patient->phase <= 1)
                    You must upload the scan data!
                @elseif ($patient->phase > 1)

                    @if (in_array($patient->dm_order_status, [ 'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect',  'OrderStatusChangedToWaitingForNewFilesStageFileUnusable',  'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted' ]))
                        @switch($patient->dm_order_status)
                            @case('OrderStatusChangedToWaitingForNewFilesStageFileIncorrect')
                                The stage file you uploaded is incorrect. Please re-upload the correct stage file.
                                @break

                            @case('OrderStatusChangedToWaitingForNewFilesStageFileUnusable')
                                The stage file you uploaded is unusable. Please re-upload a valid stage STL file.
                                @break

                            @case('OrderStatusChangedToWaitingForNewFilesStageFileCorrupted')
                                The stage file you uploaded is corrupted. Please re-upload the stage file.
                                @break
                        @endswitch

                    @elseif (in_array($patient->dm_order_status, [
                        'OrderStatusChangedToWaitingForNewFilesIOSIncorrect', 'OrderStatusChangedToWaitingForNewFilesIOSCorrupted', 'OrderStatusChangedToWaitingForNewFilesIOSUnusable',
                        'OrderStatusChangedToOrderRejectedAnatomicalChanges', 'OrderStatusChangedToOrderRejectedAdditionalTeeth'
                    ]))
                        {{-- IOS or Rejection Issues --}}
                        @switch($patient->dm_order_status)
                            @case('OrderStatusChangedToWaitingForNewFilesIOSIncorrect')
                                The IOS file you uploaded is incorrect. Please re-upload the correct IOS file.
                                @break

                            @case('OrderStatusChangedToWaitingForNewFilesIOSUnusable')
                                The IOS file you uploaded is unusable. Please re-upload a valid IOS STL file.
                                @break

                            @case('OrderStatusChangedToWaitingForNewFilesIOSCorrupted')
                                The IOS file you uploaded is corrupted. Please re-upload the IOS file.
                                @break

                            @case('OrderStatusChangedToOrderRejectedAnatomicalChanges')
                                Your order was rejected due to anatomical changes. Please re-upload updated IOS and stage files.
                                @break

                            @case('OrderStatusChangedToOrderRejectedAdditionalTeeth')
                                Your order was rejected due to additional teeth detected. Please re-upload updated IOS and stage files.
                                @break
                        @endswitch

                    @elseif (in_array($patient->dm_order_status, [
                                'OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect'
                            ]))
                                {{-- Aligner Number Issues --}}
                            The stage file you uploaded has an incorrect aligner number. Please re-upload the correct stage file.
                    @elseif ($patient->dm_order_status == 'OrderStatusChangedToOrderCompleted')
                            <strong>🎉 Congratulations!</strong> Your order has been successfully completed.
                            Your treatment plan is now ready and you can proceed with the next steps.
                    @else
                        {{-- Default Message --}}
                        Your order is under processing in Dental Monitoring.
                        If you want to update scan data manually, you need to cancel the order first.
                    @endif
                @endif
            </p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Section Title --}}
    <div class="mb-1 fw-medium font-sans-serif text-900">
        Original bite registration STL File:
    </div>

    {{-- Dropzones row: each dropzone col perfectly matches dropzone width for seamless alignment --}}
    <div class="row g-3 mb-1 scan-dz-row">
        <!-- Upper Arch -->
        <div class="col-auto scan-dz-col _dropzone_template" template-key="1">
            <input class="d-none" name="file1" id="key1" file="{{ @$patient->fl_upper_arch }}" data-field="1" type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="upper-jaw-box" key="1" style="background-image: url('{{asset('public/assets/vector/upper-jaw.webp')}}')">
                <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text></span>
                    <img src="{{asset('public/assets')}}/check-mark.webp" style="width: 40px;height: 40px;">
                </div>
                <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                    <img src="{{asset('public/assets')}}/download-circular-button.webp" style="width: 40px;height: 40px;">
                </div>
                <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Uploading...</span>
                    <img src="{{asset('public/assets')}}/circle-loading.webp" class="_dropzone_loading_animation" style="width: 40px;height: 40px;">
                </div>
                <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Delete file</span>
                    <img src="{{asset('public/assets')}}/x-mark.webp" style="width: 40px; height: 40px;">
                </div>
            </div>
            <label class="scan-arch-label" for="fl_upper_arch">Upper Arch</label>
            <div class="scan-progress-wrap">
                <div class="progress animated-progress">
                    <div class="progress-bar bg-primary" id="upper-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="scan-preview-box" id="stl-upper-arch-preview"></div>
        </div>

        <!-- Lower Arch -->
        <div class="col-auto scan-dz-col _dropzone_template" template-key="2">
            <input class="d-none" name="file2" id="key2" file="{{ @$patient->fl_lower_arch }}" data-field="2" type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="lower-jaw-box" key="2" style="background-image: url('{{asset('public/assets/vector/down-jaw.webp')}}')">
                <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text></span>
                    <img src="{{asset('public/assets')}}/check-mark.webp" style="width: 40px;height: 40px;">
                </div>
                <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                    <img src="{{asset('public/assets')}}/download-circular-button.webp" style="width: 40px;height: 40px;">
                </div>
                <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Uploading...</span>
                    <img src="{{asset('public/assets')}}/circle-loading.webp" class="_dropzone_loading_animation" style="width: 40px;height: 40px;">
                </div>
                <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Delete file</span>
                    <img src="{{asset('public/assets')}}/x-mark.webp" style="width: 40px; height: 40px;">
                </div>
            </div>
            <label class="scan-arch-label" for="fl_lower_arch">Lower Arch</label>
            <div class="scan-progress-wrap">
                <div class="progress animated-progress">
                    <div class="progress-bar bg-primary" id="lower-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </div>
            <div class="scan-preview-box" id="stl-lower-arch-preview"></div>
        </div>
    </div>

    {{-- Quick Upload Notes in original position below dropzones with highlight --}}
    <div class="row scan-quick-notes mb-2">
        <div class="col-12">
            <div class="scan-quick-notes-box">
                <span class="fw-semibold font-sans-serif text-primary mb-1">
                    <i class="fas fa-info-circle me-1"></i> Quick Upload Notes:
                </span>
                <span class="text-secondary">
                    &bull; Only STL files are accepted.
                </span>
                <span class="text-secondary">
                    &bull; No separate bite registration file needed! Just ensure it was completed during the scan; the data is already embedded in your Upper and Lower STL files.
                </span>
            </div>
        </div>
    </div>

    {{-- Import Buttons Bar --}}
    <div class="scan-import-bar d-flex flex-wrap align-items-center gap-2 mb-2">
        @if(Auth::user()->three_shape_access_token != null)
            <button type="button" class="btn btn-primary order-from-button" id="select-from-3shape">
        @else
            <a class="btn btn-primary order-from-button" href="{{ url('/integration-3shape/obtain-authorization-code') }}">
        @endif
            <div class="d-flex align-items-center justify-content-center">
                <span>Import From</span>
                <img src="{{ asset('public/assets/communicate-logo-white.png') }}" width="80px" style="padding-left: 8px">
            </div>
        @if(Auth::user()->three_shape_access_token != null)
            </button>
        @else
            </a>
        @endif

        <a class="btn btn-primary order-from-button"
            @if(Auth::user()->medit_link_access_token != null)
                href="javascript:void(0);" id="select-from-medit-link"
            @else
                href="{{url('/integration-medit-link/obtain-authorization-code')}}"
            @endif
        >
            <div class="d-flex align-items-center justify-content-center">
                <span>Import From </span>
                <img class="ms-1" style="padding-top: 4px; padding-bottom: 4px;" src="{{asset('public/assets/medit-link-logo.svg')}}" width="46px">
            </div>
        </a>

        @if(Auth::user()->shining3d_org_name == null )
            <a class="btn btn-primary order-from-button" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#shining3d-org-name-modal">
                <div class="d-flex align-items-center justify-content-center">
                    <span>Import From</span>&nbsp;<span style="color:#1C8484; font-weight: bold;">SHINING 3D</span>
                </div>
            </a>
        @else
            <a class="btn btn-primary order-from-button" href="javascript:void(0);" data-mode="{{ $mode }}" data-hash-code="{{ $hashCode ? trim($hashCode, '"') : '' }}" id="select-from-shining3d-link" data-shining3d-user-id="{{ Auth::user()->shining3d_user_id }}" data-shining3d-access-token="{{ Auth::user()->shining3d_access_token }}">
                <div class="d-flex align-items-center justify-content-center">
                    <span>Import From</span>&nbsp;<span style="color:#1C8484; font-weight: bold;">SHINING 3D</span>
                </div>
            </a>
        @endif

        @if($patient->phase > 1)
            @if ($patient->dm_order_details == null || $patient->dm_order_details == '')
                <button class="btn btn-primary order-from-dental-monitoring-btn order-from-button" data-bs-toggle="modal" data-bs-target="#order-from-dental-monitoring-modal" data-patient-treatment-plans-id="{{ $patient->id }}" data-patient-id="{{ $patient->patient_id }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <span>Order From</span>
                        <img class="ms-2" style="padding-top: 4px; padding-bottom: 4px;" src="{{asset('public/assets/dm-logo.png')}}" width="80px">
                    </div>
                </button>
            @else
                @php
                    $reuploadStatuses = [
                        'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect',
                        'OrderStatusChangedToWaitingForNewFilesStageFileUnusable',
                        'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted',
                        'OrderStatusChangedToWaitingForNewFilesIOSUnusable',
                        'OrderStatusChangedToWaitingForNewFilesIOSIncorrect',
                        'OrderStatusChangedToWaitingForNewFilesIOSCorrupted',
                        'OrderStatusChangedToOrderRejectedAnatomicalChanges',
                        'OrderStatusChangedToOrderRejectedAdditionalTeeth',
                    ];
                @endphp
                @if (in_array($patient->dm_order_status, $reuploadStatuses))
                    <button class="btn btn-warning reupload-files-from-dental-monitoring-btn order-from-button" data-bs-toggle="modal" data-bs-target="#reupload-from-dental-monitoring-modal" data-patient-treatment-plans-id="{{ $patient->id }}" data-patient-id="{{ $patient->patient_id }}">
                        <div class="d-flex align-items-center justify-content-center">
                            <span>Update Order From</span>
                            <img class="ms-2" style="padding-top: 4px; padding-bottom: 4px;" src="{{ asset('public/assets/dm-logo.png') }}" width="80px" alt="DM Logo">
                        </div>
                    </button>
                @endif
                @if ($patient->dm_order_status != 'OrderStatusChangedToOrderCompleted')
                    <button class="btn btn-danger cancel-order-from-dental-monitoring-btn order-from-button" data-bs-toggle="modal" data-bs-target="#cancel-order-from-dental-monitoring-modal" data-patient-treatment-plans-id="{{ $patient->id }}" data-patient-id="{{ $patient->patient_id }}">
                        <div class="d-flex align-items-center justify-content-center">
                            <span>Cancel Order</span>
                            <img class="ms-2" style="padding-top: 4px; padding-bottom: 4px;" src="{{asset('public/assets/dm-logo.png')}}" width="80px">
                        </div>
                    </button>
                @endif
            @endif
        @endif
    </div>

    <!-- Toggle Button for Additional Scans on its own row -->
    <div class="mb-2">
        <button type="button" class="btn btn-outline-primary" id="toggleAdditionalScans">
            Add Mandibular Repositioning STL Files (Optional)
        </button>
    </div>

    <!-- Confirmation Modal: 3Shape -->
    <div class="modal fade" id="optional-3shape-section-Modal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">3Shape communicate Scan data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="card-title-desc">Search with case id or by patient. Click on case to download stl files.</p>
                    @csrf
                    <input type="hidden" name="additional_patient_id" value="{{ $patient->patient_id }}">
                    <input type="hidden" name="additional_case_id" value="{{ $patient->id }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Case ID: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input type="text" class="form-control" id="additional_three_shape_case_id" name="additional_three_shape_case_id">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Search for case: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input type="text" class="form-control" id="additional_three_shape_search_for_case" name="additional_three_shape_search_for_case">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="btn-group">
                                <button class="btn btn-primary waves-effect waves-light" type="button" id="additional-3shape-search">Search</button>
                                <button type="button" class="btn btn-warning waves-effect waves-light" id="optional-cancel-3shape-select">Cancel</button>
                            </div>
                            @if(Auth::user()->three_shape_access_token != null)
                                <a class="btn btn-danger float-end" href="{{url('/integrations/3shape-disable')}}">
                                    <div class="d-flex align-items-center justify-content-center ">
                                        <span>Logout From</span>
                                        <img class="ms-1" src="{{asset('public/assets/communicate-logo-white.png')}}" width="75px">
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0">
                            <table id="3shape-search-result-additional" class="table table-striped"></table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal: Medit Link -->
    <div class="modal fade" id="medit-link-additional-Modal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Medit Link Scan data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="card-title-desc">Search with case registration/modification dates and case name. Click on case to download stl files.</p>
                    @csrf
                    <input type="hidden" name="additional_medit_link_patient_id" value="{{ $patient->patient_id }}">
                    <input type="hidden" name="additional_medit_link_case_id" value="{{ $patient->id }}">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Start Date: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input type="text" class="form-control pickr" name="additional_medit_link_medit_link_start_date" autocomplete="off" value="{{date("Y-m-d", strtotime("-1 month"))}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">End Date: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input type="text" class="form-control pickr" name="additional_medit_link_medit_link_end_date" autocomplete="off" value="{{date("Y-m-d")}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">Search for case: </h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <input type="text" class="form-control" name="additional_medit_link_medit_link_search_for_case">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="btn-group">
                                <button class="btn btn-primary waves-effect waves-light" id="medit-link-search-additional-button" type="button">Search</button>
                                <a class="btn btn-warning waves-effect waves-light" href="javascript:void(0);" id="cancel-medit-link-select">Cancel</a>
                            </div>
                            @if(Auth::user()->medit_link_access_token != null)
                                <a class="btn btn-danger float-end" href="{{url('/integrations/medit-link-disable')}}">
                                    <div class="d-flex align-items-center justify-content-center ">
                                        <span>Logout From</span>
                                        <img class="ms-2" src="{{asset('public/assets/medit-link-logo.svg')}}" width="52px">
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0">
                            <table id="medit-link-search-result-additional" class="table table-striped"></table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Scans Optional Portion (Hidden by default; opens on toggle) -->
    <div id="additional-scans-optional" class="d-none mt-2 pt-2 border-top">
        <div class="mb-1 fw-medium font-sans-serif text-900">
            Mandibular Repositioning STL Files (Optional)
        </div>

        <div class="row g-3 mb-1 scan-dz-row">
            {{-- Posterior Bite Turbos --}}
            <div class="col-auto scan-dz-col _dropzone_template" template-key="18">
                <input class="d-none" name="file18" id="key18" file="{{ @$patient->optional_fl_upper_arch }}" data-field="18" type="file">
                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="posterior-bite-turbos-box" key="18" style="background-image: url('{{asset('public/assets/vector/upper-jaw.webp')}}')">
                    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text></span>
                        <img src="{{asset('public/assets')}}/check-mark.webp" style="width: 40px;height: 40px;">
                    </div>
                    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                        <img src="{{asset('public/assets')}}/download-circular-button.webp" style="width: 40px;height: 40px;">
                    </div>
                    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Uploading...</span>
                        <img src="{{asset('public/assets')}}/circle-loading.webp" class="_dropzone_loading_animation" style="width: 40px;height: 40px;">
                    </div>
                    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Delete file</span>
                        <img src="{{asset('public/assets')}}/x-mark.webp" style="width: 40px; height: 40px;">
                    </div>
                </div>
                <label class="scan-arch-label" for="optional_fl_upper_arch">Upper Arch</label>
                <div class="scan-progress-wrap">
                    <div class="progress animated-progress">
                        <div class="progress-bar bg-primary" id="optional-upper-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
                <div class="scan-preview-box" id="optional-stl-upper-arch-preview"></div>
            </div>

            {{-- Anterior Bite Turbos --}}
            <div class="col-auto scan-dz-col _dropzone_template" template-key="19">
                <input class="d-none" name="file19" id="key19" file="{{ @$patient->optional_fl_lower_arch }}" data-field="19" type="file">
                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="anterior-bite-turbos-box" key="19" style="background-image: url('{{asset('public/assets/vector/down-jaw.webp')}}')">
                    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text></span>
                        <img src="{{asset('public/assets')}}/check-mark.webp" style="width: 40px;height: 40px;">
                    </div>
                    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                        <img src="{{asset('public/assets')}}/download-circular-button.webp" style="width: 40px;height: 40px;">
                    </div>
                    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Uploading...</span>
                        <img src="{{asset('public/assets')}}/circle-loading.webp" class="_dropzone_loading_animation" style="width: 40px;height: 40px;">
                    </div>
                    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Delete file</span>
                        <img src="{{asset('public/assets')}}/x-mark.webp" style="width: 40px; height: 40px;">
                    </div>
                </div>
                <label class="scan-arch-label" for="optional_fl_lower_arch">Lower Arch</label>
                <div class="scan-progress-wrap">
                    <div class="progress animated-progress">
                        <div class="progress-bar bg-primary" id="optional-lower-arch-progress-bar" role="progressbar" style="width: 0%;" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
                <div class="scan-preview-box" id="optional-stl-lower-arch-preview"></div>
            </div>
        </div>

        {{-- Quick Upload Notes for optional section in original position below dropzones with highlight --}}
        <div class="row scan-quick-notes mb-2">
            <div class="col-12">
                <div class="scan-quick-notes-box">
                    <span class="fw-semibold font-sans-serif text-primary mb-1">
                        <i class="fas fa-info-circle me-1"></i> Quick Upload Notes:
                    </span>
                    <span class="text-secondary">
                        &bull; STL file with bite registration for mandibular repositioning is required.
                    </span>
                </div>
            </div>
        </div>

        <!-- Additional Import Buttons -->
        <div class="scan-import-bar d-flex flex-wrap align-items-center gap-2 mb-2">
            <a class="btn btn-primary order-from-button"
                @if(Auth::user()->three_shape_access_token != null)
                    href="javascript:void(0);" id="optional-select-from-3shape"
                @else
                    href="{{url('/integration-3shape/obtain-authorization-code')}}"
                @endif
            >
                <div class="d-flex align-items-center justify-content-center">
                    <span>Import From</span>
                    <img src="{{asset('public/assets/communicate-logo-white.png')}}" width="80px" style="padding-left: 8px">
                </div>
            </a>

            <a class="btn btn-primary order-from-button"
                @if(Auth::user()->medit_link_access_token != null)
                    href="javascript:void(0);" id="select-from-medit-link-additional"
                @else
                    href="{{url('/integration-medit-link/obtain-authorization-code')}}"
                @endif
            >
                <div class="d-flex align-items-center justify-content-center">
                    <span>Import From </span>
                    <img class="ms-1" style="padding-top: 4px; padding-bottom: 4px;" src="{{asset('public/assets/medit-link-logo.svg')}}" width="46px">
                </div>
            </a>

            @if(Auth::user()->shining3d_org_name == null )
                <a class="btn btn-primary order-from-button" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#shining3d-org-name-modal">
                    <div class="d-flex align-items-center justify-content-center">
                        <span>Import From</span>&nbsp;<span style="color:#1C8484; font-weight: bold;">SHINING 3D</span>
                    </div>
                </a>
            @else
                <a class="btn btn-primary order-from-button" href="javascript:void(0);" data-mode="{{ $mode }}" data-hash-code="{{ $hashCode ? trim($hashCode, '"') : '' }}" id="select-from-shining3d-link" data-shining3d-user-id="{{ Auth::user()->shining3d_user_id }}" data-shining3d-access-token="{{ Auth::user()->shining3d_access_token }}">
                    <div class="d-flex align-items-center justify-content-center">
                        <span>Import From</span>&nbsp;<span style="color:#1C8484; font-weight: bold;">SHINING 3D</span>
                    </div>
                </a>
            @endif
        </div>
    </div>

    {{-- Bottom Navigation Buttons --}}
    <div class="scan-footer-buttons text-end mt-2 mb-0">
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li-treatment-type">Previous</button>
        <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-scan-data" @if (@$patient->fl_upper_arch && @$patient->fl_lower_arch) fn="1" @else fn="0" @endif>Next</button>
    </div>
</div>
{{-- scan Data End --}}

<script>
    (function () {
        function autoAdjustScanDataHeight() {
            const tabPane = document.getElementById('pill-tab-div2');
            if (!tabPane) return;

            const additionalSection = document.getElementById('additional-scans-optional');
            const isAdditionalOpen = additionalSection && !additionalSection.classList.contains('d-none');

            if (isAdditionalOpen) {
                tabPane.classList.add('additional-scans-open');
                // When additional scans portion is open, keep the existing dropzone size
                // so previews never shift or collide, and allow natural vertical scrolling as requested.
                if (!tabPane.style.getPropertyValue('--scan-dz-size')) {
                    tabPane.style.setProperty('--scan-dz-size', '225px');
                }
                return;
            }

            tabPane.classList.remove('additional-scans-open');

            // If 3D preview canvases are already rendered, keep the dropzone size stable
            // so Three.js canvases do not get distorted or misaligned.
            const hasExistingCanvas = tabPane.querySelector('#stl-upper-arch-preview canvas, #stl-lower-arch-preview canvas');
            if (hasExistingCanvas && tabPane.style.getPropertyValue('--scan-dz-size')) {
                return;
            }

            // Viewport height
            const vh = window.innerHeight || document.documentElement.clientHeight;

            // Find top offset of tab pane
            const tabRect = tabPane.getBoundingClientRect();
            let topOffset = tabRect.top;
            if (topOffset <= 0) {
                const cardBody = tabPane.closest('.card-body');
                if (cardBody) {
                    topOffset = cardBody.getBoundingClientRect().top + 65;
                } else {
                    topOffset = 230;
                }
            }

            // Reserved height for non-dropzone elements inside tabPane:
            // Section title (~22px) + Arch labels (~18px) + Progress bars (~16px) +
            // Quick Upload Notes box (~68px) + Import buttons (~46px) +
            // Toggle button (~44px) + Footer buttons (~36px) + margins/paddings (~20px)
            let nonDzHeight = 280;
            const alertEl = tabPane.querySelector('.alert');
            if (alertEl && alertEl.offsetHeight > 0) {
                nonDzHeight += alertEl.offsetHeight + 10;
            }

            // Bottom safety margin to prevent vertical scrollbar trigger
            const bottomSafetyMargin = 30;
            const availableForDz = vh - topOffset - nonDzHeight - bottomSafetyMargin;

            // Clamp between 100px and 225px
            const targetDz = Math.max(100, Math.min(225, Math.floor(availableForDz)));

            tabPane.style.setProperty('--scan-dz-size', targetDz + 'px');
        }

        // Event listeners
        window.addEventListener('resize', autoAdjustScanDataHeight);
        window.addEventListener('load', autoAdjustScanDataHeight);

        document.addEventListener('DOMContentLoaded', function () {
            autoAdjustScanDataHeight();

            // When toggle button is clicked
            const toggleBtn = document.getElementById('toggleAdditionalScans');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    setTimeout(autoAdjustScanDataHeight, 50);
                });
            }

            // When switching to this tab
            if (window.jQuery) {
                window.jQuery('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                    if (window.jQuery(e.target).attr('href') === '#pill-tab-div2') {
                        setTimeout(autoAdjustScanDataHeight, 20);
                    }
                });
            }
        });

        // Run immediately
        autoAdjustScanDataHeight();
        setTimeout(autoAdjustScanDataHeight, 150);
    })();
</script>
