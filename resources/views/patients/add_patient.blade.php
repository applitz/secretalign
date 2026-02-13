@extends('layouts.app_base_horizontal')

@section('css')

<script src="{{ asset('public/assets/three/build/three.js') }}"></script>
 <script type="importmap">
{
    "imports": {
        "three": "{{asset('public/assets/three/build/three.module.js')}}",
        "OrbitControls": "{{asset('public/assets/three/examples/jsm/controls/OrbitControls.js')}}"
    }
}
</script>
<link rel="stylesheet" href="{{ asset('public/assets') }}/restrictions.css">
<link rel="stylesheet" href="{{asset('public/css/cropper.css')}}">
<style>
    ._dropzone {
        width: 225px;
        min-height: 225px;
        background-position: center;
        position: relative;
        background-size: contain;
        background-repeat: no-repeat;
        cursor: pointer;
    }
    ._dropzone_added, ._dropzone_hover, ._dropzone_loading, ._dropzone_remove {
        position: absolute;
        left: 0;
        top: 0;
        background: rgba(33, 37, 39, 0.975);
        width: 225px;
        height: 225px;
    }
    ._dropzone_added_hidden, ._dropzone_hover_hidden, ._dropzone_loading_hidden, ._dropzone_remove_hidden {
        visibility: hidden;
    }

    ._dropzone_loading_animation {
        animation: rotation 6s infinite linear;
    }

    @keyframes rotation {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    div#canvas canvas {
        margin: 0 auto;
    }
    .canvas-bg {
        background: #aaaaaa;
    }

    .order-from-button {

        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border: none;
        width: 250px !important;
    }


</style>
@stop
@php
    $change_plan = 'true';
    if ($changePlan){
        $change_plan = $changePlan;
    }
@endphp


@section('content')
<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/patients')}}">Patients</a></li>
                        <li class="breadcrumb-item active">Create New Patient</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

     @php
        //sections completed
        $fn1 = 0;
        $fn2 = 0;
        $fn3 = 0;
        $fn4 = 0;
        if ($patient->first_name && $patient->last_name && $patient->dob) {
            $fn1 = 1;
        }
        if ($patient->fl_upper_arch && $patient->fl_lower_arch) {
            $fn2 = 1;
        }
        if ($patient->phase > 1 || ($patient->fl_front && $patient->fl_smile && $patient->fl_profile && $patient->fl_frontal &&
            $patient->fl_right_buccal && $patient->fl_left_buccal && $patient->fl_upper_occlusal && $patient->fl_lower_occlusal &&
            $patient->fl_panorex && $patient->fl_lateral_ceph)) {
            $fn3 = 1;
        }
        if (($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1) {
            $fn4 = 1;
        }
    @endphp


<div class="row gx-0 d-none" id="3shape-section">
    <div class="col-12 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">3Shape communicate Scan data</h4>
                <p class="card-title-desc">Search with case id or by patient. Click on case to download stl files.</p>
                <form class="mt-2" method="GET" id="3shape-search">
                    <input type="hidden" name="_patient_id" value="{{ $patient->patient_id }}">
                    <input type="hidden" name="_case_id" value="{{ $patient->id }}">
                    <div class="row">
                      <div class="col-md-3 mb-3">
                        <div class="row align-items-center g-3">
                          <div class="col-12">
                            <h6 class="text-700 mb-0">Case ID: </h6>
                          </div>
                          <div class="col-12 position-relative">
                            <input type="text" class="form-control" name="_three_shape_case_id">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 mb-3">
                        <div class="row align-items-center g-3">
                          <div class="col-12">
                            <h6 class="text-700 mb-0">Search for case: </h6>
                          </div>
                          <div class="col-12 position-relative">
                            <input type="text" class="form-control" name="_three_shape_search_for_case">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <div class="btn-group">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Search</button>
                            <a class="btn btn-warning waves-effect waves-light" href="javascript:void(0);" id="cancel-3shape-select">Cancel</a>
                        </div>
                        @if(Auth::user()->three_shape_access_token != null)
                            <a class="btn btn-danger float-end" href="{{url('/integrations/3shape-disable')}}">
                               <div class="d-flex align-items-center justify-content-center ">
                                <span>Logout From</span>
                                <img class="ms- 1" src="{{asset('public/assets/communicate-logo-white.png')}}" width="75px">
                               </div>
                            </a>
                         @endif
                      </div>
                    </div>
                  </form>

                  <div class="table-rep-plugin">
                    <div class="table-responsive mb-0">
                        <table id="3shape-search-result" class="table table-striped">

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row gx-0 d-none" id="medit-link-section">
    <div class="col-12 ">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Medit Link Scan data</h4>
                <p class="card-title-desc">Search with case registration/modification dates and case name. Click on case to download stl files.</p>
                <form class="mt-2" method="GET" id="medit-link-search">
                    <input type="hidden" name="_patient_id" value="{{ $patient->patient_id }}">
                    <input type="hidden" name="_case_id" value="{{ $patient->id }}">
                    <div class="row">
                      <div class="col-md-3 mb-3">
                        <div class="row align-items-center g-3">
                          <div class="col-12">
                            <h6 class="text-700 mb-0">Start Date: </h6>
                          </div>
                          <div class="col-12 position-relative">
                            <input type="text" class="form-control pickr" name="_medit_link_start_date" value="{{date("Y-m-d", strtotime("-1 month"))}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 mb-3">
                        <div class="row align-items-center g-3">
                          <div class="col-12">
                            <h6 class="text-700 mb-0">End Date: </h6>
                          </div>
                          <div class="col-12 position-relative">
                            <input type="text" class="form-control pickr" name="_medit_link_end_date" value="{{date("Y-m-d")}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-3 mb-3">
                        <div class="row align-items-center g-3">
                          <div class="col-12">
                            <h6 class="text-700 mb-0">Search for case: </h6>
                          </div>
                          <div class="col-12 position-relative">
                            <input type="text" class="form-control" name="_medit_link_search_for_case">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 mb-3">
                        <div class="btn-group">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Search</button>
                            <a class="btn btn-warning waves-effect waves-light" href="javascript:void(0);" id="cancel-medit-link-select">Cancel</a>
                        </div>
                        @if(Auth::user()->medit_link_access_token != null)
                            <a class="btn btn-danger float-end" href="{{url('/integrations/medit-link-disable')}}">
                               <div class="d-flex align-items-center justify-content-center ">
                                <span>Logout From</span>
                                <img class="ms-2"  src="{{asset('public/assets/medit-link-logo.svg')}}" width="52px">
                               </div>
                            </a>
                         @endif
                      </div>
                    </div>
                  </form>

                  <div class="table-rep-plugin">
                    <div class="table-responsive mb-0">
                        <table id="medit-link-search-result" class="table table-striped">

                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row gx-0" id="patient-wizard">
    <div class="col-12 ">
        <div class="card">

            <div class="card-body">
                <h4 class="card-title">Add Your Patient Information</h4>
                <p class="card-title-desc">You must complete all steps</p>

                <ul class="nav nav-pills gap-3" id="pill-myTab" role="tablist">
                    <li class="nav-item flex-grow-1">
                        <a class="nav-link text-900 active" id="pill-tab-li1" data-bs-toggle="tab"
                        href="#pill-tab-div1" role="tab" aria-controls="pill-tab-div1" aria-selected="true">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">1</span>
                            Patient Info
                        </a>
                    </li>
                    <li class="nav-item flex-grow-1">
                        <a class="nav-link text-900" id="pill-tab-li-treatment-type" data-bs-toggle="tab"
                        href="#pill-tab-li-treatment-type-div" role="tab" aria-controls="pill-tab-li-treatment-type-div" aria-selected="false">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">2</span>
                            Treatment Type
                        </a>
                    </li>
                    <li class="nav-item flex-grow-1">
                        <a class="nav-link text-900" id="pill-tab-li2" data-bs-toggle="tab"
                        href="#pill-tab-div2" role="tab" aria-controls="pill-tab-div2" aria-selected="false">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">3</span>
                            Scan Data
                        </a>
                    </li>
                    <li class="nav-item flex-grow-1">
                        <a class="nav-link text-900" id="pill-tab-li3" data-bs-toggle="tab"
                        href="#pill-tab-div3" role="tab" aria-controls="pill-tab-div3" aria-selected="false">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">4</span>
                            Images / X-Rays
                        </a>
                    </li>
                    <li class="nav-item flex-grow-1">
                        <a class="nav-link text-900" id="pill-tab-li4" data-bs-toggle="tab"
                        href="#pill-tab-div4" role="tab" aria-controls="pill-tab-div4" aria-selected="false">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">5</span>
                            Prescription
                        </a>
                    </li>
                    <li class="nav-item flex-grow-1">
                        <a class="nav-link text-900" id="pill-tab-li5" data-bs-toggle="tab"
                        href="#pill-tab-div5" role="tab" aria-controls="pill-tab-div5" aria-selected="false">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;" >6</span>
                            Case Overview
                        </a>
                    </li>
                    <li class="nav-item flex-grow-1">
                        <a class="nav-link text-900" id="pill-tab-li6" data-bs-toggle="tab"
                        href="#pill-tab-div6" role="tab" aria-controls="pill-tab-div6" aria-selected="false">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;" >7</span>
                            Confirm &amp; Submit
                        </a>
                    </li>
                </ul>

                <div class="tab-content p-3 mt-3" id="pill-myTabContent">
                    @include('patients.create-patients.patient-info')

                    @include('patients.create-patients.treatment-type')

                    @include('patients.create-patients.scan-data')

                    @include('patients.create-patients.images-xray')

                    @include('patients.create-patients.prescription')

                    @include('patients.create-patients.case-overview')

                    @include('patients.create-patients.confirm-submit')
                </div>
            </div>
        </div>
    </div>
</div>



<form method="POST" action="{{ url('/patient/submit') }}" id="final-submit-form">
    @csrf
    <input type="hidden" name="client_preferred_package" value="select">
    <input type="hidden" name="treatment_plan_id" value="{{ $patient->id }}">
    <input type="hidden" name="patient_id" value="{{ $patient->patient_id }}">
</form>




<div class="modal fade bs-example-modal-center confirm"  role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0">Confirm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <h5 id="confirmMessage"></h5>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-bs-dismiss="modal" id="confirmYes">Yes</button>
                <button class="btn btn-secondary" data-bs-dismiss="modal" id="confirmNo">No</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@if($patient->phase > 1)
    <!-- Cancel Order From Dental-Monitoring Modal Start -->
    <div class="modal fade" id="cancel-order-from-dental-monitoring-modal" tabindex="-1" aria-labelledby="cancelOrderFromDentalMonitoringLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="cancelOrderFromDentalMonitoringLabel">
                        Cancel Dental Monitoring Order
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p id="cancel-order-from-dental-monitoring-modal-message">
                    Are you sure you want to cancel this Dental Monitoring order? This action cannot be undone.
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No, Keep Order</button>
                    <button type="submit" class="btn btn-danger" id="cancel-order-from-dental-sure">Yes, Cancel Order</button>
                </div>

            </div>
        </div>

    </div>
    <!-- Cancel Order From Dental-Monitoring Modal End -->

    <!-- Order From Dental-Monitoring Modal Start -->
    <div class="modal fade" id="order-from-dental-monitoring-modal" tabindex="-1" aria-labelledby="order-from-dental-monitoring" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="order-from-dental-monitoring">Order From Dental Monitoring</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <form id="order-from-dental-monitoring-form" method="POST" action="{{url('/order-from-dental-monitoring')}}" enctype="multipart/form-data"> --}}
                    <div class="modal-body">
                        @if(empty(Auth::user()->doctor_id) || is_null(Auth::user()->doctor_id))
                            <p>Please update your Dental Monitoring Doctor ID in Profile Settings. Without a Doctor ID, you cannot place an order.</p>
                        @else
                            <div class="alert alert-danger border-2 d-flex align-items-center d-none" role="alert" id="dental-monitoring-alert" >
                                <p class="mb-0 flex-1">Please wait while we place your order with Dental Monitoring. Don't close this page or navigate away until the process is complete.</p>
                            </div>
                            <p>The Patient ID is required and should match the Dental Monitoring Patient ID.</p>
                            @if (checkFileisStlOrNot($priviousPatientDetails->fl_upper_arch) === false || checkFileisStlOrNot($priviousPatientDetails->fl_lower_arch === false) )
                                <div class="alert alert-warning border-2 d-flex align-items-center" role="alert">
                                    <p class="mb-0 flex-1">
                                        In your previous treatment plan, you uploaded scan files that were not STL files.For orders with Dental Monitoring, you need to upload them manually.
                                        Scan files must be in STL format.
                                    </p>
                                </div>
                            @endif
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="patient_id">Patient ID<span class="text-danger">*</span></label>
                                    <input class="form-control " id="dental_patient_id" type="text" placeholder="Enter Patient ID" name="dental_patient_id" value="">
                                    <input class="form-control " id="p_treatment_plans_id_input" type="hidden" placeholder="Enter Patient ID" name="p_treatment_plans_id" value="">
                                    <input class="form-control " id="patient_id_input" type="hidden" placeholder="Enter Patient ID" name="patient_id" value="">
                                    <input class="form-control " id="manullay_upload" type="hidden" placeholder="Enter Patient ID" name="patient_id" value="{{ checkFileisStlOrNot($priviousPatientDetails->fl_upper_arch) === false || checkFileisStlOrNot($priviousPatientDetails->fl_lower_arch === false) ? 'yes' : 'no' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">Attachments Option</label>
                                    <div class="form-check">
                                        <input class="form-check-input attachments" type="radio" id="keep_attachments" name="attachments_option" value="keep_all" checked="checked">
                                        <label class="form-check-label" for="keep_attachments">
                                            Keep already placed attachments.
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input attachments" type="radio" id="remove_attachments" name="attachments_option" value="remove_all">
                                        <label class="form-check-label" for="remove_attachments">
                                            Remove already placed attachments.
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @if (checkFileisStlOrNot($priviousPatientDetails->fl_upper_arch) === false || checkFileisStlOrNot($priviousPatientDetails->fl_lower_arch === false) )
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="upper_arch_scan">Upper Arch Scan<span class="text-danger">*</span></label>
                                        <input class="form-control " id="upper_arch_scan" type="file" placeholder="Enter Patient ID" name="upper_arch_scan" value="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="lower_arch_scan">Lower Arch Scan<span class="text-danger">*</span></label>
                                        <input class="form-control " id="lower_arch_scan" type="file" placeholder="Enter Patient ID" name="lower_arch_scan" value="">
                                    </div>
                                </div>
                            @endif

                        @endif

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        @if(empty(Auth::user()->doctor_id) || is_null(Auth::user()->doctor_id))
                            <a href="{{ route('profile-settings') }}" target="_blank" class="btn btn-primary" id="update-profile">
                                Go to Update Profile
                            </a>
                        @else
                            <button type="button" class="btn btn-primary " id="confirm-order-from-dental-monitoring">Order Now</button>
                        @endif

                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
    <!-- Order From Dental-Monitoring Modal End -->
    <!-- Order From Dental-Monitoring Modal Start -->
    <div class="modal fade" id="reupload-from-dental-monitoring-modal" tabindex="-1" aria-labelledby="reupload-from-dental-monitoring" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="reupload-from-dental-monitoring">Reupload files for Update Order From Dental Monitoring </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <form id="order-from-dental-monitoring-form" method="POST" action="{{url('/order-from-dental-monitoring')}}" enctype="multipart/form-data"> --}}
                    <div class="modal-body">

                            <div class="alert alert-danger border-2 d-flex align-items-center d-none" role="alert" id="dental-monitoring-alert" >
                                <p class="mb-0 flex-1">Please wait while we place your order with Dental Monitoring. Don't close this page or navigate away until the process is complete.</p>
                            </div>
                            @php
                                $message = '';

                                switch ($patient->dm_order_status) {
                                    case "OrderStatusChangedToWaitingForNewFilesStageFileIncorrect":
                                        $message = "The uploaded stage file is incorrect. Doctor has been notified to re-upload a new one.";
                                        break;

                                    case "OrderStatusChangedToWaitingForNewFilesStageFileCorrupted":
                                        $message = "The uploaded stage file is corrupted and cannot be processed. Doctor has been notified to provide a new file.";
                                        break;

                                    case "OrderStatusChangedToWaitingForNewFilesStageFileUnusable":
                                        $message = "The uploaded stage file is unusable for the treatment process. Doctor has been requested to re-upload a valid file.";
                                        break;

                                    case "OrderStatusChangedToWaitingForNewFilesIOSIncorrect":
                                        $message = "The uploaded IOS (Intraoral Scan) file is incorrect. Doctor has been informed to re-upload the correct file.";
                                        break;

                                    case "OrderStatusChangedToWaitingForNewFilesIOSCorrupted":
                                        $message = "The uploaded IOS (Intraoral Scan) file is corrupted and cannot be used. Doctor has been notified to provide a new one.";
                                        break;

                                    case "OrderStatusChangedToWaitingForNewFilesIOSUnusable":
                                        $message = "The uploaded IOS (Intraoral Scan) file is unusable. Doctor has been requested to upload a new valid file.";
                                        break;

                                    case "OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect":
                                        $message = "The aligner number information appears to be incorrect. Doctor has been asked to update it.";
                                        break;

                                    case "OrderStatusChangedToOrderRejectedAnatomicalChanges":
                                        $message = "The order was rejected due to anatomical changes detected in the patient's scan. Doctor has been notified to re-upload the IOS (Intraoral Scan) file.";
                                        break;

                                    case "OrderStatusChangedToOrderRejectedAdditionalTeeth":
                                        $message = "The order was rejected because additional teeth were detected in the scan. Doctor has been informed to upload a new IOS (Intraoral Scan) file.";
                                        break;
                                }
                            @endphp
                            @if (!empty($message))
                                <p>{{ $message }}</p>
                            @endif
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label" for="patient_id">Patient ID<span class="text-danger">*</span></label>
                                    <input class="form-control " id="dental_patient_id" type="text" placeholder="Enter Patient ID" name="dental_patient_id" value="{{ $patient->dm_patient_id }}">
                                    <input class="form-control " id="p_treatment_plans_id_input" type="hidden" placeholder="Enter Patient ID" name="p_treatment_plans_id" value="">
                                    <input class="form-control " id="patient_id_input" type="hidden" placeholder="Enter Patient ID" name="patient_id" value="">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="keep_attachments_stl" name="keep_attachments_stl" value="1">
                                        <label class="form-check-label" for="keep_attachments_stl">keep the attachments in stl files</label>
                                    </div>
                                </div>
                            </div>

                            {{-- IOS FIles Reupload Start --}}
                            @if ($patient->dm_order_status == 'OrderStatusChangedToWaitingForNewFilesIOSIncorrect' || $patient->dm_order_status == 'OrderStatusChangedToWaitingForNewFilesIOSCorrupted' || $patient->dm_order_status == 'OrderStatusChangedToWaitingForNewFilesIOSUnusable' ||
                                $patient->dm_order_status == 'OrderStatusChangedToOrderRejectedAnatomicalChanges' || $patient->dm_order_status == 'OrderStatusChangedToOrderRejectedAdditionalTeeth')
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="upper_arch_scan">Upper Arch Scan<span class="text-danger">*</span></label>
                                        <input class="form-control " id="update_upper_arch_scan" type="file" placeholder="Enter Patient ID" name="upper_arch_scan" value="">
                                        <span class="text-danger upper_arch_scan_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="lower_arch_scan">Lower Arch Scan<span class="text-danger">*</span></label>
                                        <input class="form-control " id="update_lower_arch_scan" type="file" placeholder="Enter Patient ID" name="lower_arch_scan" value="">
                                        <span class="text-danger lower_arch_scan_error"></span>
                                    </div>
                                </div>
                            @endif
                            {{-- IOS FIles Reupload End --}}

                            {{-- Stage FIles Reupload Start --}}
                            @if ($patient->dm_order_status == 'OrderStatusChangedToWaitingForNewFilesStageFileIncorrect' || $patient->dm_order_status == 'OrderStatusChangedToWaitingForNewFilesStageFileCorrupted' || $patient->dm_order_status == 'OrderStatusChangedToWaitingForNewFilesStageFileUnusable' ||
                                $patient->dm_order_status == 'OrderStatusChangedToWaitingForNewFilesAlignerNumberIncorrect')
                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="upper_arch_scan">Stage Upper Arch Scan<span class="text-danger">*</span></label>
                                        <input class="form-control " id="update_upper_arch_stage_file" type="file" placeholder="Enter Patient ID" name="upper_arch_stage_file" value="">
                                        <span class="text-danger upper_arch_stage_file_error"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3">
                                        <label class="form-label" for="lower_arch_scan">Stage Lower Arch Scan<span class="text-danger">*</span></label>
                                        <input class="form-control " id="update_lower_arch_stage_file" type="file" placeholder="Enter Patient ID" name="lower_arch_stage_file" value="">
                                        <span class="text-danger lower_arch_stage_file_error"></span>
                                    </div>
                                </div>
                            @endif
                            {{-- Stage FIles Reupload End --}}

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary " id="update-order-from-dental-monitoring" data-dm-order-id="{{ $patient->dm_order_id }}" data-dm-order-status="{{ $patient->dm_order_status }}">Update Order Now</button>
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
    <!-- Order From Dental-Monitoring Modal End -->


@endif

    @if( request()->get('code') && request()->get('matchNode') && request()->get('codeChallenge') && request()->get('domain'))
    <!--  Order From shining3d Modal Start -->
        <div class="modal fade" id="order-from-shining3d-modal" tabindex="-1" aria-labelledby="orderFromShining3dLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="orderFromShining3dLabel">
                            Import From Shining3d
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div id="shining3d-error" class="alert alert-danger py-1" style="display:none; font-size: 14px;"></div>
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="scanType" class="form-label">Select Region</label>
                                        <select id="scanRegion" class="form-select">

                                            <option value="https://ffapi.shining3d.com" {{ $dataShining3d['baseUrl'] == 'https://ffapi.shining3d.com' ? 'selected="selected"' : '' }}> Europe (Frankfurt) – Recommended for EU countries </option>
                                            <option value="https://hzapi.shining3d.com" {{ $dataShining3d['baseUrl'] == 'https://hzapi.shining3d.com' ? 'selected="selected"' : '' }}>China (Hangzhou) – Mainland China users</option>
                                            <option value="https://ruapi.shining3d.com" {{ $dataShining3d['baseUrl'] == 'https://ruapi.shining3d.com' ? 'selected="selected"' : '' }}>Russia – Users located in Russia</option>
                                            <option value="https://sapi.shining3d.com" {{ $dataShining3d['baseUrl'] == 'https://sapi.shining3d.com' ? 'selected="selected"' : '' }}>USA (Silicon Valley) – North America users</option>
                                            <option value="https://tkapi.shining3d.com" {{ $dataShining3d['baseUrl'] == 'https://tkapi.shining3d.com' ? 'selected="selected"' : '' }}>Japan (Tokyo) – Japan & East Asia users</option>


                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="startDate" class="form-label">Start Date</label>
                                        <input type="text" id="startDate" class="form-control pickr flatpickr-input" value="{{ $dataShining3d['startDate'] ? date('d-m-Y', strtotime($dataShining3d['startDate'])) : '' }}" placeholder="Select start date">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="endDate" class="form-label">End Date</label>
                                        <input type="text" id="endDate" class="form-control pickr flatpickr-input" value="{{ $dataShining3d['endDate'] ? date('d-m-Y', strtotime($dataShining3d['endDate'])) : '' }}" placeholder="Select end date">
                                        <input type="hidden" id="order-from-shining3d-label-model-shining3d-doctor-id" value="{{ $dataShining3d['doctorId'] }}">
                                        <input type="hidden" id="order-from-shining3d-label-model-shining3d-auth-token" value="{{ $dataShining3d['authToken'] }}">
                                        <input type="hidden" id="order-from-shining3d-label-model-shining3d-org-type" value="{{ $dataShining3d['orgType'] }}">
                                        <input type="hidden" id="order-from-shining3d-label-model-shining3d-org-code" value="{{ $dataShining3d['orgCode'] }}">
                                        <input type="hidden" id="order-from-shining3d-label-model-shining3d-csrf-token" value="{{ $dataShining3d['csrfToken'] }}">
                                        <input type="hidden" id="order-from-shining3d-label-model-shining3d-base-url" value="{{ $dataShining3d['baseUrl'] }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3" id="caseSearchRow" >
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Patient Name</th>
                                                    <th>Phone</th>
                                                    <th>Sex</th>
                                                    <th>Lab Name</th>
                                                     <th>Status</th>
                                                    <th>Created At</th>
                                                    <th>Scan Files</th>
                                                </tr>
                                            </thead>
                                            <tbody id="shining3dOrderTable">
                                                @if(!empty($dataShining3d['orderList']['result']) && count($dataShining3d['orderList']['result']) > 0)
                                                    @foreach($dataShining3d['orderList']['result'] as $order)

                                                        @php
                                                            // -------------------------
                                                            // Patient details
                                                            // -------------------------
                                                            $patientName = $order['patient']['name'] ?? '-';

                                                            if (!empty($order['patient']['phone'])) {
                                                                $phone = '+' . ($order['patient']['phoneArea'] ?? '') . ' ' . $order['patient']['phone'];
                                                            } else {
                                                                $phone = '-';
                                                            }

                                                            $sex     = $order['patient']['sex'] ?? '-';
                                                            $labName = $order['lab']['name'] ?? '-';

                                                            // -------------------------
                                                            // Created date
                                                            // -------------------------
                                                            $createdAt = !empty($order['createOn'])
                                                                ? \Carbon\Carbon::parse($order['createOn'])->format('d-m-Y')
                                                                : '-';

                                                            // -------------------------
                                                            // Status mapping
                                                            // -------------------------
                                                            $statusText  = $order['status'] ?? 'unknown';
                                                            $statusClass = 'secondary';

                                                            switch ($statusText) {
                                                                case 'waitDelivery':
                                                                    $statusText  = 'Waiting for Delivery';
                                                                    $statusClass = 'warning';
                                                                    break;

                                                                case 'delivered':
                                                                    $statusText  = 'Delivered';
                                                                    $statusClass = 'info';
                                                                    break;

                                                                case 'completed':
                                                                    $statusText  = 'Completed';
                                                                    $statusClass = 'success';
                                                                    break;

                                                                case 'cancelled':
                                                                    $statusText  = 'Cancelled';
                                                                    $statusClass = 'danger';
                                                                    break;
                                                            }
                                                        @endphp

                                                        <tr>
                                                            <td>{{ $patientName }}</td>
                                                            <td>{{ $phone }}</td>
                                                            <td>{{ $sex }}</td>
                                                            <td>{{ $labName }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $statusClass }}">
                                                                    {{ $statusText }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $createdAt }}</td>
                                                            <td>
                                                                <button class="btn btn-sm btn-primary view-scan get-scan-btn"
                                                                        data-id="{{ $order['id'] }}">
                                                                    Get Scan
                                                                </button>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted">
                                                            No orders found for selected date range.
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                        {{-- <button type="button" class="btn btn-danger" data-base-url="{{ $dataShining3d['baseUrl']}}" data-csrf-token="{{ $dataShining3d['csrfToken']}}"  data-org-type="{{ $dataShining3d['orgType']}}" data-org-code="{{ $dataShining3d['orgCode']}}" data-doctor-id="{{ $dataShining3d['doctorId']}}" data-auth-token="{{ $dataShining3d['authToken']}}" id="order-from-shining3d">Get Sacn</button> --}}
                        <button type="button" class="btn btn-danger" id="order-from-shining3d">Get Sacn</button>
                    </div>

                </div>
            </div>

        </div>
    <!-- Order From shining3d Modal End -->
    @endif
    {{-- <!--  Order From shining3d Modal Start -->
        <div class="modal fade" id="order-from-shining3d-modal" tabindex="-1" aria-labelledby="orderFromShining3dLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="orderFromShining3dLabel">
                            Order From Shining3d
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div id="shining3d-error" class="alert alert-danger py-1" style="display:none; font-size: 14px;"></div>
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="scanType" class="form-label">Select Region</label>
                                        <select id="scanRegion" class="form-select">
                                            <option value="">-- Select Region Based on Your Location --</option>

                                            <option value="frankfurt">
                                                Europe (Frankfurt) – Recommended for EU countries
                                            </option>

                                            <option value="hz">
                                                China (Hangzhou) – Mainland China users
                                            </option>

                                            <option value="ru">
                                                Russia – Users located in Russia
                                            </option>

                                            <option value="silicon">
                                                USA (Silicon Valley) – North America users
                                            </option>

                                            <option value="tokyo">
                                                Japan (Tokyo) – Japan & East Asia users
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="startDate" class="form-label">Start Date</label>
                                        <input type="text" id="startDate" class="form-control pickr flatpickr-input" placeholder="Select start date">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="endDate" class="form-label">End Date</label>
                                        <input type="text" id="endDate" class="form-control pickr flatpickr-input" placeholder="Select end date">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3" id="caseSearchRow" style="display:none;">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Patient Name</th>
                                                    <th>Phone</th>
                                                    <th>Sex</th>
                                                    <th>Lab Name</th>
                                                     <th>Status</th>
                                                    <th>Created At</th>
                                                    <th>Scan Files</th>
                                                </tr>
                                            </thead>
                                            <tbody id="shining3dOrderTable">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                        <button type="button" class="btn btn-danger" id="order-from-shining3d">Get Sacn</button>
                    </div>

                </div>
            </div>

        </div>
    <!-- Order From shining3d Modal End --> --}}
@stop

@section('javascript')



<script type="module">
    import { STLLoader } from "{{asset('public/assets/three/examples/jsm/loaders/STLLoader.js')}}";
    import { PLYLoader } from "{{asset('public/assets/three/examples/jsm/loaders/PLYLoader.js')}}";
    import { OrbitControls } from '{{asset("public/assets/three/examples/jsm/controls/OrbitControls.js")}}';




    var container1, scene1, camera1, renderer1, material1, controls1,
    container2, scene2, camera2, renderer2, material2, controls2;
    const stl_loader1 = new STLLoader()
    const stl_loader2 = new STLLoader()
    const ply_loader1 = new PLYLoader()
    const ply_loader2 = new PLYLoader()

    function animate1() {
        requestAnimationFrame( animate1 );
        container1.appendChild( renderer1.domElement );
        controls1.update();
        renderer1.render( scene1, camera1 );

    };
    function animate2() {
        requestAnimationFrame( animate2 );
        container2.appendChild( renderer2.domElement );
        controls2.update();
        renderer2.render( scene2, camera2 );

    };
    function destroyPreview1() {
        container1.removeChild(renderer1.domElement);
        scene1.traverse((object) => {
            if (object.isMesh) {
                object.geometry.dispose();
                object.material.dispose();
            }
        });

        controls1.dispose();
        container1 = null;
        scene1 = null;
        camera1 = null;
        renderer1 = null;
        material1 = null;
        controls1 = null;
    }

window.destroyPreview1 = destroyPreview1;

function destroyPreview2() {
    container2.removeChild(renderer2.domElement);

    scene2.traverse((object) => {
        if (object.isMesh) {
            object.geometry.dispose();
            object.material.dispose();
        }
    });

    controls2.dispose();

    container2 = null;
    scene2 = null;
    camera2 = null;
    renderer2 = null;
    material2 = null;
    controls2 = null;
}

window.destroyPreview2 = destroyPreview2;


async function loadSTLUpper(url) {
    const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Failed to fetch ${url}: ${response.statusText}`);
            }
            const reader = response.body.getReader();
            const contentLength = response.headers.get('Content-Length');
            const total = contentLength ? parseInt(contentLength, 10) : null;
            let loaded = 0;

            const chunks = [];
            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                chunks.push(value);
                loaded += value.length;
                if (total) {
                    const percentComplete = (loaded / total * 100).toFixed(2);
                    $("#upper-arch-progress-bar").css({width: `${percentComplete}%`})
                    $("#upper-arch-progress-bar").html(`%${parseInt(percentComplete)} Loaded`)
                }
            }
            const arrayBuffer = new Uint8Array(loaded);
            let offset = 0;
            for (let chunk of chunks) {
                arrayBuffer.set(chunk, offset);
                offset += chunk.length;
            }

            const geometry = stl_loader1.parse(arrayBuffer.buffer);
            return geometry;
}

async function loadSTLLower(url) {
    const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Failed to fetch ${url}: ${response.statusText}`);
            }
            const reader = response.body.getReader();
            const contentLength = response.headers.get('Content-Length');
            const total = contentLength ? parseInt(contentLength, 10) : null;
            let loaded = 0;

            const chunks = [];
            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                chunks.push(value);
                loaded += value.length;
                if (total) {
                    const percentComplete = (loaded / total * 100).toFixed(2);
                    $("#lower-arch-progress-bar").css({width: `${percentComplete}%`})
                    $("#lower-arch-progress-bar").html(`%${parseInt(percentComplete)} Loaded`)
                    // document.getElementById('progress-bar').style.width = `${percentComplete}%`;
                    // document.getElementById('progress-bar').textContent = `${percentComplete}%`;
                }
            }
            const arrayBuffer = new Uint8Array(loaded);
            let offset = 0;
            for (let chunk of chunks) {
                arrayBuffer.set(chunk, offset);
                offset += chunk.length;
            }

            const geometry = stl_loader2.parse(arrayBuffer.buffer);
            return geometry;
}

async function loadPLYUpper(url) {
    const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Failed to fetch ${url}: ${response.statusText}`);
            }
            const reader = response.body.getReader();
            const contentLength = response.headers.get('Content-Length');
            const total = contentLength ? parseInt(contentLength, 10) : null;
            let loaded = 0;

            const chunks = [];
            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                chunks.push(value);
                loaded += value.length;
                if (total) {
                    const percentComplete = (loaded / total * 100).toFixed(2);
                    $("#upper-arch-progress-bar").css({width: `${percentComplete}%`})
                    $("#upper-arch-progress-bar").html(`%${parseInt(percentComplete)} Loaded`)
                    // document.getElementById('progress-bar').style.width = `${percentComplete}%`;
                    // document.getElementById('progress-bar').textContent = `${percentComplete}%`;
                }
            }
            const arrayBuffer = new Uint8Array(loaded);
            let offset = 0;
            for (let chunk of chunks) {
                arrayBuffer.set(chunk, offset);
                offset += chunk.length;
            }

            const geometry = ply_loader1.parse(arrayBuffer.buffer);
            return geometry;
}

async function loadPLYLower(url) {
    const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Failed to fetch ${url}: ${response.statusText}`);
            }
            const reader = response.body.getReader();
            const contentLength = response.headers.get('Content-Length');
            const total = contentLength ? parseInt(contentLength, 10) : null;
            let loaded = 0;

            const chunks = [];
            while (true) {
                const { done, value } = await reader.read();
                if (done) break;
                chunks.push(value);
                loaded += value.length;
                if (total) {
                    const percentComplete = (loaded / total * 100).toFixed(2);
                    $("#lower-arch-progress-bar").css({width: `${percentComplete}%`})
                    $("#lower-arch-progress-bar").html(`%${parseInt(percentComplete)} Loaded`)
                    // document.getElementById('progress-bar').style.width = `${percentComplete}%`;
                    // document.getElementById('progress-bar').textContent = `${percentComplete}%`;
                }
            }
            const arrayBuffer = new Uint8Array(loaded);
            let offset = 0;
            for (let chunk of chunks) {
                arrayBuffer.set(chunk, offset);
                offset += chunk.length;
            }

            const geometry = ply_loader2.parse(arrayBuffer.buffer);
            return geometry;
}


async function previewUpperStlFile(file_upper)
{
    try {
        container1 = document.getElementById( 'stl-upper-arch-preview' );
        scene1 = new THREE.Scene();
        scene1.name = 'myscene1';
        scene1.background = new THREE.Color( 0xaaaaaa );
        camera1 = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
        camera1.position.set(0, 0, 5);
        renderer1 = new THREE.WebGLRenderer({ antialias: true });
        material1 = new THREE.MeshNormalMaterial();
        controls1 = new OrbitControls(camera1, renderer1.domElement, { enableRotate: true });
        controls1.enableDamping = true;
        THREE.Cache.enabled = true;

        const width = $("#upper-jaw-box").width() + 23;
        const height = $("#upper-jaw-box").height();

        renderer1.setSize( width, height );

        document.body.appendChild( renderer1.domElement );

        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene1.add(ambientLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(1, 1, 1).normalize();
        scene1.add(directionalLight);

        const geometry = await loadSTLUpper('{{url('/patient/mesh/fetch/'.$patient->patient_id)}}/'+file_upper)
        const mesh = new THREE.Mesh(geometry, material1)
        mesh.tag = 'base';
        scene1.add(mesh);
        camera1.position.z = 10;
        camera1.position.x = 0;
        camera1.position.y = -6;
        scene1.scale.set(0.02,0.02,0.02);

        controls1.update();
        animate1();
    } catch (error) {}
}
            window.previewUpperStlFile = previewUpperStlFile;

            async function previewLowerStlFile(file_lower)
            {
                try {
                    container2 = document.getElementById( 'stl-lower-arch-preview' );
                    scene2 = new THREE.Scene();
                    scene2.name = 'myscene2';
                    scene2.background = new THREE.Color( 0xaaaaaa );
                    camera2 = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
                    camera2.position.set(0, 0, 5);
                    renderer2 = new THREE.WebGLRenderer({ antialias: true });

                    material2 = new THREE.MeshNormalMaterial();
                    controls2 = new OrbitControls(camera2, renderer2.domElement, { enableRotate: true });
                    controls2.enableDamping = true;
                    THREE.Cache.enabled = true;

                    const width = $("#upper-jaw-box").width() + 23;
                    const height = $("#upper-jaw-box").height();

                    //modify renderer
                    renderer2.setSize( width, height );


                    //append renderer to body
                    document.body.appendChild( renderer2.domElement );

                    // Lighting
                    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
                    scene2.add(ambientLight);

                    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
                    directionalLight.position.set(1, 1, 1).normalize();
                    scene2.add(directionalLight);

                    const geometry = await loadSTLLower('{{url('/patient/mesh/fetch/'.$patient->patient_id)}}/'+file_lower)
                    const mesh = new THREE.Mesh(geometry, material2)

                    mesh.tag = 'base';
                    scene2.add(mesh);

                    console.log('scene updated');

                    camera2.position.z = 10;
                    camera2.position.x = 0;
                    camera2.position.y = -6;
                    scene2.scale.set(0.02,0.02,0.02);

                    controls2.update();
                    animate2();
                } catch (error) {}
            }
            window.previewLowerStlFile = previewLowerStlFile;

            async function previewUpperPlyFile(file_upper)
            {
                try {
                    container1 = document.getElementById( 'stl-upper-arch-preview' );
                    scene1 = new THREE.Scene();
                    scene1.name = 'myscene1';
                    scene1.background = new THREE.Color( 0xaaaaaa );
                    camera1 = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
                    camera1.position.set(0, 0, 5);
                    renderer1 = new THREE.WebGLRenderer({ antialias: true });

                    material1 = new THREE.MeshStandardMaterial({
                        vertexColors: THREE.VertexColors,
                        flatShading: true
                    });
                    controls1 = new OrbitControls(camera1, renderer1.domElement, { enableRotate: true });
                    controls1.enableDamping = true;

                    THREE.Cache.enabled = true;

                    const width = $("#upper-jaw-box").width() + 23;
                    const height = $("#upper-jaw-box").height();

                    //modify renderer
                    renderer1.setSize( width, height );

                    //append renderer to body
                    document.body.appendChild( renderer1.domElement );

                    // Lighting
                    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
                    scene1.add(ambientLight);

                    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
                    directionalLight.position.set(1, 1, 1).normalize();
                    scene1.add(directionalLight);
                    const geometry = await loadPLYUpper('{{url('/patient/mesh/fetch/'.$patient->patient_id)}}/'+file_upper)
                    geometry.computeVertexNormals();
                    const mesh = new THREE.Mesh(geometry, material1)

                    mesh.tag = 'base';

                    scene1.add(mesh);
                    camera1.position.z = 10;
                    camera1.position.x = 0;
                    camera1.position.y = -6;
                    scene1.scale.set(0.02,0.02,0.02);

                    controls1.update();
                    animate1();
                } catch (error) {}
            }



            window.previewUpperPlyFile = previewUpperPlyFile;

            async function previewLowerPlyFile(file_lower)
            {
                try {
                    container2 = document.getElementById( 'stl-lower-arch-preview' );
                    scene2 = new THREE.Scene();
                    scene2.name = 'myscene2';
                    scene2.background = new THREE.Color( 0xaaaaaa );
                    camera2 = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
                    camera2.position.set(0, 0, 5);
                    renderer2 = new THREE.WebGLRenderer({ antialias: true });
                    material2 = new THREE.MeshStandardMaterial({
                        vertexColors: THREE.VertexColors,
                        flatShading: true
                    });
                    controls2 = new OrbitControls(camera2, renderer2.domElement, { enableRotate: true });
                    controls2.enableDamping = true;
                    THREE.Cache.enabled = true;


                    const width = $("#upper-jaw-box").width() + 23;
                    const height = $("#upper-jaw-box").height();

                    //modify renderer
                    renderer2.setSize( width, height );

                    //append renderer to body
                    document.body.appendChild( renderer2.domElement );
                    // Lighting
                    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
                    scene2.add(ambientLight);

                    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
                    directionalLight.position.set(1, 1, 1).normalize();
                    scene2.add(directionalLight);


                    const geometry = await loadPLYLower('{{url('/patient/mesh/fetch/'.$patient->patient_id)}}/'+file_lower)
                    geometry.computeVertexNormals();
                    const mesh = new THREE.Mesh(geometry, material2)

                    mesh.tag = 'base';
                    scene2.add(mesh);

                    console.log('scene updated');

                    camera2.position.z = 10;
                    camera2.position.x = 0;
                    camera2.position.y = -6;
                    scene2.scale.set(0.02,0.02,0.02);

                    controls2.update();
                    animate2();
                } catch (error) {}
            }
            window.previewLowerPlyFile = previewLowerPlyFile;


            @if(@$patient->fl_upper_arch!='')

            @if(explode(".", @$patient->fl_upper_arch)[1] == 'stl')
            previewUpperStlFile("{{@$patient->fl_upper_arch}}")
            @else
            previewUpperPlyFile("{{@$patient->fl_upper_arch}}")
            @endif
            @endif
            @if(@$patient->fl_lower_arch!='')

            @if(explode(".", @$patient->fl_lower_arch)[1] == 'stl')
            previewLowerStlFile("{{@$patient->fl_lower_arch}}")
            @else
            previewLowerPlyFile("{{@$patient->fl_lower_arch}}")
            @endif
            @endif

            function downloadMeditLinkStlFiles($uuid)
            {
                $.ajax({
                        type: "POST",
                        url: "{{url('/patient/file/download-medit-link')}}",
                        data: {
                            "_token" : "{{ csrf_token() }}",
                            "patient_id" : "{{ $patient->patient_id }}",
                            "treatment_plan_id" : "{{ $patient->id }}",
                            "uuid" : $uuid,
                        },
                        beforeSend: function () {
                            showLoader();
                        }
                    }).done(function (response) {

                        if(response.upper || response.lower) {
                            if(response.upper) {
                                $('#key1').attr('file', response.upper);
                                window.dropzone_active_state('1', response.upper)
                                previewUpperStlFile(response.upper)
                            }
                            if(response.lower) {
                                $('#key2').attr('file', response.lower);
                                window.dropzone_active_state('2', response.lower)
                                previewLowerStlFile(response.lower)
                            }
                                                        if(response.patient_name){
                                    document.getElementById('first_name').value = response.first_name;
                                    document.getElementById('last_name').value = response.last_name;
                            }
                            if(response.patient_code){
                                document.getElementById('patientCode').value = response.patient_code;
                            }
                            $("#3shape-section").addClass('d-none');
                            $("#medit-link-section").addClass('d-none')
                            $("#patient-wizard").removeClass('d-none');
                            hideLoader();
                        }
                        else {
                            hideLoader();
                            toastError("Error while downloading files.");
                        }
                    });
            }

            function download3ShapeStlFiles($case_id, $hash_upper, $hash_lower)
            {
                $.ajax({
                        type: "POST",
                        url: "{{url('/patient/file/download-3shape')}}",
                        data: {
                            "_token" : "{{ csrf_token() }}",
                            "patient_id" : "{{ $patient->patient_id }}",
                            "treatment_plan_id" : "{{ $patient->id }}",
                            "case_id" : $case_id,
                            "hash_upper" : $hash_upper,
                            "hash_lower" : $hash_lower,
                        },
                        beforeSend: function () {
                            showLoader();
                        }
                    }).done(function (response) {

                        if(response.upper || response.lower) {
                            if(response.upper) {
                                $('#key1').attr('file', response.upper);
                                window.dropzone_active_state('1', response.upper)
                                previewUpperStlFile(response.upper)
                            }
                            if(response.lower) {
                                $('#key2').attr('file', response.lower);
                                window.dropzone_active_state('2', response.lower)
                                previewLowerStlFile(response.lower)
                            }
                            $("#3shape-section").addClass('d-none');
                            $("#medit-link-section").addClass('d-none')
                            $("#patient-wizard").removeClass('d-none');
                            hideLoader();
                        }
                        else {
                            hideLoader();
                            toastError("Error while downloading files.");
                        }
                    });
            }

        $(document).ready(function () {

            @if(@$medit_data->case_uuid)
                    downloadMeditLinkStlFiles('{{@$medit_data->case_uuid}}')
                    @endif


            $("#select-from-3shape").on('click', function () {
                $("#3shape-section").removeClass('d-none');
                $("#medit-link-section").addClass('d-none');
                $("#patient-wizard").addClass('d-none');
            });

                    $("#cancel-3shape-select").on('click', function () {
                        $("#3shape-section").addClass('d-none');
                        $("#medit-link-section").addClass('d-none')
                        $("#patient-wizard").removeClass('d-none');
                    });


                    $("#select-from-medit-link").on('click', function () {
                        $("#medit-link-section").removeClass('d-none')
                        $("#3shape-section").addClass('d-none')
                        $("#patient-wizard").addClass('d-none')
                    })

                    $("#cancel-medit-link-select").on('click', function () {
                        $("#3shape-section").addClass('d-none');
                        $("#medit-link-section").addClass('d-none')
                        $("#patient-wizard").removeClass('d-none');
                    })

                    $(document).on('click', '.download-3shape-stl-files',function () {
                        const hash_upper = $(this).attr('hash-upper'),
                        hash_lower = $(this).attr('hash-lower'),
                        case_id = $(this).attr('case-id');
                        download3ShapeStlFiles(case_id, hash_upper, hash_lower);
                    });

                    $(document).on('click', '.download-medit-link-stl-files', function () {
                        const uuid = $(this).attr('data-uuid');
                        downloadMeditLinkStlFiles(uuid)
                    })



                    $("#medit-link-search").on('submit', function (e) {
                        e.preventDefault()
                        e.stopImmediatePropagation()
                        const case_id = $("#medit-link-search input[name=_case_id]").val(),
                        patient_id = $("#medit-link-search input[name=_patient_id]").val(),
                        medit_link_search_for_case = $("#medit-link-search input[name=_medit_link_search_for_case]").val(),
                        medit_link_start_date = $("#medit-link-search input[name=_medit_link_start_date]").val(),
                        medit_link_end_date = $("#medit-link-search input[name=_medit_link_end_date]").val()

                        $.ajax({
                            type: "POST",
                            url: "{{ url('/integrations/medit-link-search-cases') }}",
                            data: {
                                "_token" : "{{ csrf_token() }}",
                                "case_id" : case_id,
                                "patient_id" : patient_id,
                                "medit_link_search_for_case" : medit_link_search_for_case,
                                "medit_link_start_date" : medit_link_start_date,
                                "medit_link_end_date" : medit_link_end_date
                            },
                            beforeSend: function () {
                                showLoader();
                            }
                        }).done(function (response) {
                            $("#medit-link-search-result").html(response);
                            hideLoader();
                        })
                    })

                    $("#3shape-search").on('submit', function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        const case_id = $("#3shape-search input[name=_case_id]").val(),
                        patient_id = $("#3shape-search input[name=_patient_id]").val(),
                        three_shape_case_id = $("#3shape-search input[name=_three_shape_case_id]").val(),
                        three_shape_search_for_case = $("#3shape-search input[name=_three_shape_search_for_case]").val();
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/integrations/3shape-search-cases') }}",
                            data: {
                                "_token" : "{{ csrf_token() }}",
                                "case_id" : case_id,
                                "patient_id" : patient_id,
                                "three_shape_case_id" : three_shape_case_id,
                                "three_shape_search_for_patient" : three_shape_search_for_case,
                            },
                            beforeSend: function () {
                                showLoader();
                            }
                        }).done(function (response) {
                            $("#3shape-search-result").html(response);
                            hideLoader();
                        });
                    });






                $(document).ready(function () {
                    // Show additional divs when an advisor is selected
                    $("#advisor").on("change", function () {
                        if ($(this).val() !== "") {
                            $("#additionalDivs").removeClass("d-none");
                            $("#consultant_agreement").attr("required", true); // Make checkbox required
                        } else {
                            $("#additionalDivs").addClass("d-none");
                            $("#consultant_agreement").removeAttr("required"); // Remove required if no advisor is selected
                        }
                    });

                    // Final submit button logic
                    $(document).on("click", "#final-confirm-and-submit-btn", function () {
                        // Check if terms and conditions are accepted
                        if ($("input[name=terms_and_conditions]").is(":checked")) {
                            const advisor = $("#advisor").val();
                            const comment = $("#comment").val();// Get advisor selection
                            const consultantAgreementChecked = $("#consultant_agreement").is(":checked");

                            // Validate consultant agreement checkbox if advisor is selected
                            if (advisor && !consultantAgreementChecked) {
                                toastError("You must agree to the additional consultation terms.");
                                return;
                            }

                            // Submit the form
                            $("#final-submit-form").append(`<input type="hidden" name="advisor" value="${advisor}" />`);
                        $("#final-submit-form").append(`<input type="hidden" name="comment" value="${comment}" />`);

                        // Submit the form
                        $("#final-submit-form").submit();
                        } else {
                            toastError("You must accept the Packages and Terms & Conditions agreement.");
                        }
                    });
                });

        });
</script>
<script src="{{asset('public/js/cropper.js')}}"></script>
<script>
    $(function () {
        let
        dropzone_state = {
            "key1" : 'inactive',
            "key2" : 'inactive',
            "key3" : 'inactive',
            "key4" : 'inactive',
            "key5" : 'inactive',
            "key6" : 'inactive',
            "key7" : 'inactive',
            "key8" : 'inactive',
            "key9" : 'inactive',
            "key10" : 'inactive',
            "key11" : 'inactive',
            "key12" : 'inactive',
            "key13" : 'inactive',
        }
        const ui = {
            confirm: async (message) => editConfirm(message)
        }

        const editConfirm = (message) => {
            return new Promise((complete, failed)=>{
                $('#confirmMessage').text(message)

                $('#confirmYes').off('click');
                $('#confirmNo').off('click');

                $('#confirmYes').on('click', ()=> { $('.confirm').hide(); complete(true); });
                $('#confirmNo').on('click', ()=> { $('.confirm').hide(); complete(false); });

                $('.confirm').modal('show');
            });
        }
        let dropzone_reset_state = (key, message = "") => {
            dropzone_state["key"+key] = 'inactive'
            $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_added").addClass('_dropzone_added_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_loading").addClass('_dropzone_loading_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
              $(`._dropzone[key='${key}']`).find("._dropzone_edit").addClass('_dropzone_remove_hidden')
            $("._dropzone_template #key"+key).val('')
            $('._dropzone_template #key'+key).attr('file', '')
            if(message != "") {
                toastError(message);
            }
        }

        window.dropzone_reset_state = dropzone_reset_state

        let dropzone_active_state = (key, fileName, message = "") => {
            dropzone_state["key"+key] = 'active'
            $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_added").removeClass('_dropzone_added_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_loading").addClass('_dropzone_loading_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
             $(`._dropzone[key='${key}']`).find("._dropzone_edit").addClass('_dropzone_remove_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_added [data-text]").html(fileName)
            if(message != "") {
                toastError(message);
            }
        }

        window.dropzone_active_state = dropzone_active_state

        let dropzone_uploading_state = (key, message = "") => {
            dropzone_state["key"+key] = 'uploading'
            $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_added").addClass('_dropzone_added_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_loading").removeClass('_dropzone_loading_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_edit").addClass('_dropzone_remove_hidden')

            if(message != "") {
                toastError(message);
            }
        }

        window.dropzone_uploading_state = dropzone_uploading_state

        let dropzone_destroy_state = (key, message = "") => {
            $.ajax({
                type: "POST",
                url: "{{url('/patient/file/revert/'.$patient->patient_id.'/'.$patient->id)}}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "key" : key,
                }
            }).done(function (response) {
                if(response.status == 'success') {
                    dropzone_reset_state(key)
                    if(key == 1) {
                        window.destroyPreview1();
                        $("#stl-upper-arch-preview").html("");
                    }
                    if(key == 2) {
                        window.destroyPreview2();
                        $("#stl-lower-arch-preview").html("");
                    }
                    toastSuccess("File successfully removed")
                } else {
                    toastError("Enable to remove file")
                }
            })
        }

        window.dropzone_destroy_state = dropzone_destroy_state

        let dropzone_upload = (key, file) => {
            let formData = new FormData();
            formData.append('file'+key, file)
            $.ajax({
                url: '{{url('/patient/file/upload/'.$patient->patient_id.'/'.$patient->id)}}?key='+key,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    dropzone_uploading_state(key)
                },
                success: function(response){
                    if(response.status == 'success') {
                        dropzone_active_state(key, response.fileName)
                        $('._dropzone_template #key'+key).attr('file', response.fileName)
                        const UPLOADEDFILE = response.fileName

                        if(key == 1) {
                            if(UPLOADEDFILE.split(".")[1] == 'stl') {
                                window.previewUpperStlFile(response.fileName)
                            } else {
                                window.previewUpperPlyFile(response.fileName)
                            }
                        }
                        if(key == 2) {
                            if(UPLOADEDFILE.split(".")[1] == 'stl') {
                                window.previewLowerStlFile(response.fileName)
                            } else {
                                window.previewLowerPlyFile(response.fileName)
                            }
                        }
                    } else {
                        dropzone_reset_state(key, "Unable to upload file")
                    }
                },
                error: function(xhr, status, error){
                    dropzone_reset_state(key, "Unable to upload file")
                }
            })
        }

        window.dropzone_upload = dropzone_upload
        let openImageEditor = (file, callback) => {
            // Create a full-screen editor overlay
            var editor = document.createElement('div');
            editor.style.position = 'fixed';
            editor.style.left = '0';
            editor.style.right = '0';
            editor.style.top = '0';
            editor.style.bottom = '0';
            editor.style.zIndex = '9999';
            editor.style.backgroundColor = '#1a1a1a';
            editor.style.display = 'flex';
            editor.style.flexDirection = 'column';
            document.body.appendChild(editor);

            // Create header with main actions
            var header = document.createElement('div');
            header.style.cssText = `
                background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%);
                padding: 15px 20px;
                border-bottom: 2px solid #333;
                display: flex;
                justify-content: space-between;
                align-items: center;
                box-shadow: 0 2px 10px rgba(0,0,0,0.5);
            `;
            editor.appendChild(header);

            // Create main content area
            var mainContent = document.createElement('div');
            mainContent.style.cssText = `
                display: flex;
                flex: 1;
                overflow: hidden;
            `;
            editor.appendChild(mainContent);

            // Create sidebar for controls
            var sidebar = document.createElement('div');
            sidebar.style.cssText = `
                width: 320px;
                background: linear-gradient(180deg, #2c2c2c 0%, #1f1f1f 100%);
                border-right: 2px solid #333;
                padding: 20px;
                overflow-y: auto;
                display: flex;
                flex-direction: column;
                gap: 20px;
            `;
            mainContent.appendChild(sidebar);

            // Create image container
            var imageContainer = document.createElement('div');
            imageContainer.style.cssText = `
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                background: #111;
                position: relative;
                overflow: hidden;
            `;
            mainContent.appendChild(imageContainer);

            // Initialize the image
            var image = new Image();
            image.src = URL.createObjectURL(file);
            image.style.maxWidth = '100%';
            image.style.maxHeight = '100%';
            image.style.objectFit = 'contain';
            imageContainer.appendChild(image);

            // Create grid canvas overlay (below drawing canvas)
            var gridCanvas = document.createElement('canvas');
            gridCanvas.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: 998;
            `;
            imageContainer.appendChild(gridCanvas);

            // Create drawing canvas overlay
            var drawingCanvas = document.createElement('canvas');
            drawingCanvas.style.cssText = `
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: auto;
                z-index: 999;
            `;
            imageContainer.appendChild(drawingCanvas);

            var ctx = drawingCanvas.getContext('2d');
            var isDrawing = false;
            var currentTool = 'brush';
            var currentColor = '#ff0000';
            var currentSize = 5;
            var currentOpacity = 1;
            var lastX = 0;
            var lastY = 0;
            var startX = 0;
            var startY = 0;
            var showGrid = false;
            var gridSpacing = 50;

            // Drawing functions
            function resizeCanvas() {
                var rect = imageContainer.getBoundingClientRect();
                drawingCanvas.width = rect.width;
                drawingCanvas.height = rect.height;
                if (gridCanvas) {
                    gridCanvas.width = rect.width;
                    gridCanvas.height = rect.height;
                }
                if (showGrid) renderGrid();
            }

            function renderGrid() {
                if (!gridCanvas) return;
                var gctx = gridCanvas.getContext('2d');
                gctx.clearRect(0, 0, gridCanvas.width, gridCanvas.height);
                gctx.globalAlpha = 0.35;
                gctx.strokeStyle = 'rgba(255,255,255,0.85)';
                gctx.lineWidth = 1;

                // vertical lines
                for (var x = 0; x <= gridCanvas.width; x += gridSpacing) {
                    gctx.beginPath();
                    gctx.moveTo(x + 0.5, 0);
                    gctx.lineTo(x + 0.5, gridCanvas.height);
                    gctx.stroke();
                }
                // horizontal lines
                for (var y = 0; y <= gridCanvas.height; y += gridSpacing) {
                    gctx.beginPath();
                    gctx.moveTo(0, y + 0.5);
                    gctx.lineTo(gridCanvas.width, y + 0.5);
                    gctx.stroke();
                }
                gctx.globalAlpha = 1;
            }

            function clearGrid() {
                if (!gridCanvas) return;
                var gctx = gridCanvas.getContext('2d');
                gctx.clearRect(0, 0, gridCanvas.width, gridCanvas.height);
            }

            function getMousePos(e) {
                var rect = drawingCanvas.getBoundingClientRect();
                var scaleX = drawingCanvas.width / rect.width;
                var scaleY = drawingCanvas.height / rect.height;
                return {
                    x: (e.clientX - rect.left) * scaleX,
                    y: (e.clientY - rect.top) * scaleY
                };
            }

            function startDrawing(e) {
                if (currentTool === 'none') return;
                isDrawing = true;
                var pos = getMousePos(e);
                lastX = pos.x;
                lastY = pos.y;
                startX = pos.x;
                startY = pos.y;

                if (currentTool === 'brush' || currentTool === 'eraser') {
                    drawingCanvas.style.pointerEvents = 'auto';
                }
            }

            function draw(e) {
                if (!isDrawing || currentTool === 'none') return;

                var pos = getMousePos(e);
                ctx.globalAlpha = currentOpacity;
                ctx.lineCap = 'round';
                ctx.lineJoin = 'round';

                if (currentTool === 'brush') {
                    ctx.globalCompositeOperation = 'source-over';
                    ctx.strokeStyle = currentColor;
                    ctx.lineWidth = currentSize;
                    ctx.beginPath();
                    ctx.moveTo(lastX, lastY);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                } else if (currentTool === 'eraser') {
                    ctx.globalCompositeOperation = 'destination-out';
                    ctx.lineWidth = currentSize * 2;
                    ctx.beginPath();
                    ctx.moveTo(lastX, lastY);
                    ctx.lineTo(pos.x, pos.y);
                    ctx.stroke();
                }

                lastX = pos.x;
                lastY = pos.y;
            }

            function stopDrawing(e) {
                if (!isDrawing || currentTool === 'none') return;

                var pos = getMousePos(e);

                if (currentTool === 'rectangle') {
                    drawRectangle(startX, startY, pos.x - startX, pos.y - startY);
                } else if (currentTool === 'circle') {
                    var radius = Math.sqrt(Math.pow(pos.x - startX, 2) + Math.pow(pos.y - startY, 2));
                    drawCircle(startX, startY, radius);
                } else if (currentTool === 'line') {
                    drawLine(startX, startY, pos.x, pos.y);
                } else if (currentTool === 'arrow') {
                    drawArrow(startX, startY, pos.x, pos.y);
                } else if (currentTool === 'measure') {
                    drawMeasure(startX, startY, pos.x, pos.y);
                } else if (currentTool === 'angle') {
                    anglePoints.push(pos);
                    if (anglePoints.length === 3) {
                        drawAngle(anglePoints[0], anglePoints[1], anglePoints[2]);
                        anglePoints = [];
                    }
                }

                isDrawing = false;
                drawingCanvas.style.pointerEvents = (currentTool === 'none') ? 'none' : 'auto';
            }

            function drawRectangle(x, y, width, height) {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = currentColor;
                ctx.lineWidth = currentSize;
                ctx.globalAlpha = currentOpacity;
                ctx.strokeRect(x, y, width, height);
            }

            function drawCircle(x, y, radius) {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = currentColor;
                ctx.lineWidth = currentSize;
                ctx.globalAlpha = currentOpacity;
                ctx.beginPath();
                ctx.arc(x, y, radius, 0, 2 * Math.PI);
                ctx.stroke();
            }

            function drawLine(x1, y1, x2, y2) {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = currentColor;
                ctx.lineWidth = currentSize;
                ctx.globalAlpha = currentOpacity;
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();
            }

            function drawArrow(x1, y1, x2, y2) {
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = currentColor;
                ctx.lineWidth = currentSize;
                ctx.globalAlpha = currentOpacity;

                // Draw line
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();

                // Draw arrowhead
                var angle = Math.atan2(y2 - y1, x2 - x1);
                var arrowLength = 15;
                var arrowAngle = Math.PI / 6;

                ctx.beginPath();
                ctx.moveTo(x2, y2);
                ctx.lineTo(x2 - arrowLength * Math.cos(angle - arrowAngle), y2 - arrowLength * Math.sin(angle - arrowAngle));
                ctx.moveTo(x2, y2);
                ctx.lineTo(x2 - arrowLength * Math.cos(angle + arrowAngle), y2 - arrowLength * Math.sin(angle + arrowAngle));
                ctx.stroke();
            }

            function drawMeasure(x1, y1, x2, y2) {
                // Draw the measurement line (default red)
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = '#ff0000'; // red line
                ctx.lineWidth = 3;
                ctx.globalAlpha = 1;
                ctx.beginPath();
                ctx.moveTo(x1, y1);
                ctx.lineTo(x2, y2);
                ctx.stroke();

                // Draw endpoints as white filled circles with a red border
                var endpointRadius = 6;
                ctx.lineWidth = 2;
                ctx.fillStyle = '#ffffff'; // white fill for endpoints
                ctx.strokeStyle = '#ff0000'; // red border for endpoints

                ctx.beginPath();
                ctx.arc(x1, y1, endpointRadius, 0, 2 * Math.PI);
                ctx.fill();
                ctx.stroke();

                ctx.beginPath();
                ctx.arc(x2, y2, endpointRadius, 0, 2 * Math.PI);
                ctx.fill();
                ctx.stroke();

                // Calculate distance (px -> mm)
                var dx = x2 - x1;
                var dy = y2 - y1;
                var pixels = Math.sqrt(dx*dx + dy*dy);
                var pxToMm = 0.264583; // default scale (adjust if needed)
                var mm = pixels * pxToMm;
                var mmStr = mm.toFixed(2) + ' mm';

                // Prepare text style
                ctx.save();
                ctx.font = '16px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                // Text measurement and white background box
                var padding = 6;
                var textWidth = ctx.measureText(mmStr).width;
                var rectW = textWidth + padding * 2;
                var rectH = 20; // matches 16px font + padding
                var labelX = (x1 + x2) / 2;
                var labelY = (y1 + y2) / 2 - 20;

                // Ensure label doesn't go off-canvas vertically (optional)
                if (labelY - rectH/2 < 0) {
                    labelY = (y1 + y2) / 2 + 20;
                }

                // Rounded rect helper
                function roundRect(ctx, x, y, w, h, r) {
                    var radius = r === undefined ? 6 : r;
                    ctx.beginPath();
                    ctx.moveTo(x + radius, y);
                    ctx.arcTo(x + w, y, x + w, y + h, radius);
                    ctx.arcTo(x + w, y + h, x, y + h, radius);
                    ctx.arcTo(x, y + h, x, y, radius);
                    ctx.arcTo(x, y, x + w, y, radius);
                    ctx.closePath();
                }

                // Draw white background
                ctx.fillStyle = '#ffffff';
                roundRect(ctx, labelX - rectW/2, labelY - rectH/2, rectW, rectH, 6);
                ctx.fill();

                // Draw red text on white bg
                ctx.fillStyle = '#ff0000';
                ctx.fillText(mmStr, labelX, labelY);

                ctx.restore();
            }

            var anglePoints = [];
            function drawAngle(a, b, c) {
                // Draw connecting lines in red
                ctx.globalCompositeOperation = 'source-over';
                ctx.strokeStyle = '#ff0000';
                ctx.lineWidth = 3;
                ctx.globalAlpha = 1;

                ctx.beginPath();
                ctx.moveTo(a.x, a.y);
                ctx.lineTo(b.x, b.y);
                ctx.lineTo(c.x, c.y);
                ctx.stroke();

                // Draw endpoints and vertex as white filled circles with red border
                var dotRadius = 6;
                ctx.lineWidth = 2;
                ctx.fillStyle = '#ffffff'; // white fill
                ctx.strokeStyle = '#ff0000'; // red border

                [a, b, c].forEach(function(p) {
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, dotRadius, 0, 2 * Math.PI);
                    ctx.fill();
                    ctx.stroke();
                });

                // Calculate angle at b (in degrees)
                var u1 = a.x - b.x, u2 = a.y - b.y;
                var v1 = c.x - b.x, v2 = c.y - b.y;
                var dot = u1 * v1 + u2 * v2;
                var mA = Math.sqrt(u1 * u1 + u2 * u2);
                var mB = Math.sqrt(v1 * v1 + v2 * v2);
                var angle = 0;
                if (mA > 0 && mB > 0) {
                    var cosTheta = Math.min(1, Math.max(-1, dot / (mA * mB)));
                    angle = Math.acos(cosTheta) * 180 / Math.PI;
                }
                var angleStr = angle.toFixed(2) + '°';

                // Label: red text (16px) on white rounded background
                ctx.save();
                ctx.font = '16px Arial';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';

                var padding = 6;
                var textWidth = ctx.measureText(angleStr).width;
                var rectW = textWidth + padding * 2;
                var rectH = 20; // matches 16px font + small padding
                var labelX = b.x;
                var labelY = b.y - 24;

                // if label would go off top, flip below the vertex
                if (labelY - rectH / 2 < 0) {
                    labelY = b.y + 24;
                }

                // rounded rect helper
                function roundRect(ctx, x, y, w, h, r) {
                    var radius = r === undefined ? 6 : r;
                    ctx.beginPath();
                    ctx.moveTo(x + radius, y);
                    ctx.arcTo(x + w, y, x + w, y + h, radius);
                    ctx.arcTo(x + w, y + h, x, y + h, radius);
                    ctx.arcTo(x, y + h, x, y, radius);
                    ctx.arcTo(x, y, x + w, y, radius);
                    ctx.closePath();
                }

                // draw white background
                ctx.fillStyle = '#ffffff';
                roundRect(ctx, labelX - rectW / 2, labelY - rectH / 2, rectW, rectH, 6);
                ctx.fill();

                // draw red text on white bg
                ctx.fillStyle = '#ff0000';
                ctx.fillText(angleStr, labelX, labelY);
                ctx.restore();
            }

            function clearDrawing() {
                ctx.clearRect(0, 0, drawingCanvas.width, drawingCanvas.height);
            }

            // Event listeners for drawing
            drawingCanvas.addEventListener('mousedown', startDrawing);
            drawingCanvas.addEventListener('mousemove', draw);
            drawingCanvas.addEventListener('mouseup', stopDrawing);
            drawingCanvas.addEventListener('mouseout', stopDrawing);

            // Initialize canvas size
            window.addEventListener('resize', resizeCanvas);
            setTimeout(resizeCanvas, 100);

            // Initialize the CropperJS instance
            var cropper = new Cropper(image, {
                viewMode: 1,
                aspectRatio: NaN,
                autoCropArea: 1,
                responsive: true,
                rotatable: true,
                movable: true,
                zoomable: true,
                scalable: true,
                zoomOnWheel: true,
                toggleDragModeOnDblclick: false,
                minCropBoxWidth: 50,
                minCropBoxHeight: 50
            });
            // Helper function to create buttons
            function createButton(text, className, onClick, icon = '') {
                var btn = document.createElement('button');
                btn.className = 'btn ' + className;
                btn.innerHTML = icon + ' ' + text;
                btn.style.cssText = `
                    margin: 2px;
                    padding: 10px 16px;
                    font-size: 14px;
                    font-weight: 600;
                    border: none;
                    border-radius: 6px;
                    cursor: pointer;
                    min-width: 100px;
                    transition: all 0.2s ease;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                `;
                btn.addEventListener('click', onClick);
                btn.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-1px)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.4)';
                });
                btn.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';
                });
                return btn;
            }
            // Helper function to create control groups
            function createControlGroup(title) {
                var group = document.createElement('div');
                group.style.cssText = `
                    background: rgba(255,255,255,0.05);
                    border: 1px solid rgba(255,255,255,0.1);
                    border-radius: 8px;
                    padding: 15px;
                    backdrop-filter: blur(10px);
                `;

                var titleElement = document.createElement('h4');
                titleElement.textContent = title;
                titleElement.style.cssText = `
                    color: #fff;
                    margin: 0 0 12px 0;
                    font-size: 16px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    border-bottom: 1px solid rgba(255,255,255,0.1);
                    padding-bottom: 8px;
                `;
                group.appendChild(titleElement);

                return group;
            }

            // Header buttons
            var leftButtons = document.createElement('div');
            leftButtons.style.display = 'flex';
            leftButtons.style.gap = '10px';
            leftButtons.style.alignItems = 'center';

            var rightButtons = document.createElement('div');
            rightButtons.style.display = 'flex';
            rightButtons.style.gap = '10px';

            // Add title to header
            var title = document.createElement('h3');
            title.textContent = 'Image Editor';
            title.style.cssText = `
                color: #fff;
                margin: 0;
                font-size: 20px;
                font-weight: 700;
            `;
            leftButtons.appendChild(title);
            // Main action buttons in header
            rightButtons.appendChild(createButton('Save', 'btn-success', function() {
                // Get the cropped image canvas
                var croppedCanvas = cropper.getCroppedCanvas();

                // Create a new canvas to combine cropped image with drawings
                var finalCanvas = document.createElement('canvas');
                var finalCtx = finalCanvas.getContext('2d');

                // Set final canvas size to match cropped image
                finalCanvas.width = croppedCanvas.width;
                finalCanvas.height = croppedCanvas.height;

                // Draw the cropped image first
                finalCtx.drawImage(croppedCanvas, 0, 0);

                // Draw the drawing canvas on top if it has content
                if (drawingCanvas.width > 0 && drawingCanvas.height > 0) {
                    // Get the cropped area bounds
                    var cropBoxData = cropper.getCropBoxData();
                    var imageData = cropper.getImageData();
                    var canvasData = cropper.getCanvasData();

                    // Calculate the scale factors
                    var scaleX = finalCanvas.width / cropBoxData.width;
                    var scaleY = finalCanvas.height / cropBoxData.height;

                    // Calculate the source rectangle in the drawing canvas
                    var sourceX = cropBoxData.left - canvasData.left;
                    var sourceY = cropBoxData.top - canvasData.top;
                    var sourceWidth = cropBoxData.width;
                    var sourceHeight = cropBoxData.height;

                    // Draw the drawing canvas content scaled to match the final image
                    finalCtx.drawImage(
                        drawingCanvas,
                        sourceX, sourceY, sourceWidth, sourceHeight,
                        0, 0, finalCanvas.width, finalCanvas.height
                    );
                }

                // Convert to blob and create file
                var finalImageData = finalCanvas.toDataURL(file.type);
                var blob = dataURItoBlob(finalImageData);
                var croppedFile = new File([blob], file.name, { type: file.type });

                document.body.removeChild(editor);
                callback(croppedFile);
            }, '💾'));

            rightButtons.appendChild(createButton('Cancel', 'btn-danger', function() {
                document.body.removeChild(editor);
            }, '❌'));

            rightButtons.appendChild(createButton('Reset', 'btn-warning', function() {
                cropper.reset();
            }, '🔄'));

            header.appendChild(leftButtons);
            header.appendChild(rightButtons);

            // Aspect Ratio Controls
            var aspectRatioGroup = createControlGroup('📐 Aspect Ratio');
            var aspectRatioButtons = document.createElement('div');
            aspectRatioButtons.style.cssText = `
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                margin-top: 10px;
            `;

            var ratios = [
                { text: 'Free', value: NaN },
                { text: '1:1', value: 1 },
                { text: '4:3', value: 4/3 },
                { text: '16:9', value: 16/9 },
                { text: '3:2', value: 3/2 },
                { text: '2:3', value: 2/3 }
            ];

            ratios.forEach(function(ratio) {
                var btn = createButton(ratio.text, 'btn-outline-light btn-sm', function() {
                    cropper.setAspectRatio(ratio.value);
                });
                btn.style.cssText = `
                    padding: 8px 12px;
                    font-size: 12px;
                    min-width: auto;
                    margin: 0;
                `;
                aspectRatioButtons.appendChild(btn);
            });

            aspectRatioGroup.appendChild(aspectRatioButtons);
            sidebar.appendChild(aspectRatioGroup);

            // Zoom Controls
            var zoomGroup = createControlGroup('🔍 Zoom');
            var zoomControls = document.createElement('div');
            zoomControls.style.cssText = `
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: 10px;
            `;

            var zoomOutBtn = createButton('−', 'btn-outline-light btn-sm', function() {
                cropper.zoom(-0.1);
            });
            zoomOutBtn.style.cssText = `
                padding: 10px;
                font-size: 18px;
                min-width: auto;
                margin: 0;
            `;

            var zoomDisplay = document.createElement('div');
            zoomDisplay.style.cssText = `
                background: rgba(255,255,255,0.1);
                color: #fff;
                padding: 10px 15px;
                border-radius: 6px;
                font-weight: 600;
                text-align: center;
                min-width: 80px;
                border: 1px solid rgba(255,255,255,0.2);
            `;
            zoomDisplay.textContent = '100%';

            var zoomInBtn = createButton('+', 'btn-outline-light btn-sm', function() {
                cropper.zoom(0.1);
            });
            zoomInBtn.style.cssText = `
                padding: 10px;
                font-size: 18px;
                min-width: auto;
                margin: 0;
            `;

            zoomControls.appendChild(zoomOutBtn);
            zoomControls.appendChild(zoomDisplay);
            zoomControls.appendChild(zoomInBtn);

            zoomGroup.appendChild(zoomControls);
            sidebar.appendChild(zoomGroup);

            // Rotation Controls
            var rotationGroup = createControlGroup('🔄 Rotation');

            var rotationButtons = document.createElement('div');
            rotationButtons.style.cssText = `
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 8px;
                margin: 10px 0;
            `;

            var rotationPresets = [
                { text: '↶ 90°', value: -90 },
                { text: '↷ 90°', value: 90 },
                { text: '↶ 45°', value: -45 },
                { text: '↷ 45°', value: 45 }
            ];

            rotationPresets.forEach(function(preset) {
                var btn = createButton(preset.text, 'btn-outline-light btn-sm', function() {
                    cropper.rotate(preset.value);
                });
                btn.style.cssText = `
                    padding: 8px 12px;
                    font-size: 12px;
                    min-width: auto;
                    margin: 0;
                `;
                rotationButtons.appendChild(btn);
            });

            var customRotation = document.createElement('div');
            customRotation.style.cssText = `
                display: flex;
                align-items: center;
                gap: 8px;
                margin-top: 10px;
            `;

            var rotationInput = document.createElement('input');
            rotationInput.type = 'number';
            rotationInput.className = 'form-control form-control-sm';
            rotationInput.placeholder = 'Custom Angle';
            rotationInput.style.cssText = `
                flex: 1;
                padding: 8px 12px;
                background: rgba(255,255,255,0.1);
                border: 1px solid rgba(255,255,255,0.2);
                border-radius: 4px;
                color: #fff;
            `;
            rotationInput.addEventListener('change', function() {
                var angle = parseFloat(this.value) || 0;
                cropper.rotateTo(angle);
            });

            var applyBtn = createButton('Apply', 'btn-primary btn-sm', function() {
                var angle = parseFloat(rotationInput.value) || 0;
                cropper.rotateTo(angle);
            });
            applyBtn.style.cssText = `
                padding: 8px 12px;
                font-size: 12px;
                min-width: auto;
                margin: 0;
            `;

            customRotation.appendChild(rotationInput);
            customRotation.appendChild(applyBtn);

            rotationGroup.appendChild(rotationButtons);
            rotationGroup.appendChild(customRotation);
            sidebar.appendChild(rotationGroup);

            // Move Controls
            var moveGroup = createControlGroup('↔️ Move');
            var moveControls = document.createElement('div');
            moveControls.style.cssText = `
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 4px;
                margin: 10px 0;
                max-width: 150px;
                margin-left: auto;
                margin-right: auto;
            `;

            var moveButtons = [
                { text: '↖', dir: [-10, -10] },
                { text: '↑', dir: [0, -10] },
                { text: '↗', dir: [10, -10] },
                { text: '←', dir: [-10, 0] },
                { text: '⌂', dir: [0, 0] },
                { text: '→', dir: [10, 0] },
                { text: '↙', dir: [-10, 10] },
                { text: '↓', dir: [0, 10] },
                { text: '↘', dir: [10, 10] }
            ];

            moveButtons.forEach(function(btn) {
                var button = createButton(btn.text, 'btn-outline-light btn-sm', function() {
                    if (btn.text === '⌂') {
                        cropper.center();
                    } else {
                        cropper.move(btn.dir[0], btn.dir[1]);
                    }
                });
                button.style.cssText = `
                    padding: 8px;
                    font-size: 14px;
                    min-width: auto;
                    margin: 0;
                `;
                moveControls.appendChild(button);
            });

            moveGroup.appendChild(moveControls);
            sidebar.appendChild(moveGroup);

            // Scale Controls
            var scaleGroup = createControlGroup('🔄 Scale');
            var scaleButtons = document.createElement('div');
            scaleButtons.style.cssText = `
                display: flex;
                gap: 10px;
                margin-top: 10px;
            `;

            var flipHBtn = createButton('Flip H', 'btn-outline-light btn-sm', function() {
                cropper.scaleX(-cropper.getImageData().scaleX);
            });
            flipHBtn.style.cssText = `
                padding: 8px 12px;
                font-size: 12px;
                min-width: auto;
                margin: 0;
                flex: 1;
            `;

            var flipVBtn = createButton('Flip V', 'btn-outline-light btn-sm', function() {
                cropper.scaleY(-cropper.getImageData().scaleY);
            });
            flipVBtn.style.cssText = `
                padding: 8px 12px;
                font-size: 12px;
                min-width: auto;
                margin: 0;
                flex: 1;
            `;

            scaleButtons.appendChild(flipHBtn);
            scaleButtons.appendChild(flipVBtn);

            scaleGroup.appendChild(scaleButtons);
            sidebar.appendChild(scaleGroup);

            // Drawing Tools
            var drawingGroup = createControlGroup('✏️ Drawing Tools');

            // Drawing tool selection
            var toolSelection = document.createElement('div');
            toolSelection.style.cssText = `
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                margin: 10px 0;
            `;

            var tools = [
                { name: 'none', icon: '🚫', text: 'None' },
                { name: 'brush', icon: '🖌️', text: 'Brush' },
                { name: 'eraser', icon: '🧹', text: 'Eraser' },
                { name: 'rectangle', icon: '⬜', text: 'Rect' },
                { name: 'circle', icon: '⭕', text: 'Circle' },
                { name: 'line', icon: '📏', text: 'Line' },
                { name: 'arrow', icon: '➡️', text: 'Arrow' },
                { name: 'measure', icon: '📐', text: 'Measure' },
                { name: 'angle', icon: '📐', text: 'Angle' }
            ];

            tools.forEach(function(tool) {
                var btn = createButton(tool.text, 'btn-outline-light btn-sm', function() {
                    currentTool = tool.name;
                    // Update button states
                    toolSelection.querySelectorAll('button').forEach(function(b) {
                        b.classList.remove('btn-primary');
                        b.classList.add('btn-outline-light');
                    });
                    this.classList.remove('btn-outline-light');
                    this.classList.add('btn-primary');
                    // Enable/disable drawing interactions based on tool
                    drawingCanvas.style.pointerEvents = (currentTool === 'none') ? 'none' : 'auto';
                    // Toggle cropper interactions to avoid blocking drawing
                    try {
                        if (currentTool === 'none') {
                            cropper.enable();
                        } else {
                            cropper.disable();
                        }
                    } catch (e) { /* ignore if cropper not ready */ }
                }, tool.icon);
                btn.style.cssText = `
                    padding: 8px 12px;
                    font-size: 12px;
                    min-width: auto;
                    margin: 0;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 2px;
                `;
                toolSelection.appendChild(btn);
            });

            drawingGroup.appendChild(toolSelection);

            // Drawing controls
            var drawingControls = document.createElement('div');
            drawingControls.style.cssText = `
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-top: 15px;
            `;

            // Color picker
            var colorGroup = document.createElement('div');
            colorGroup.style.cssText = `
                display: flex;
                align-items: center;
                gap: 10px;
            `;

            var colorLabel = document.createElement('label');
            colorLabel.textContent = 'Color:';
            colorLabel.style.cssText = `
                color: #fff;
                font-size: 14px;
                font-weight: 600;
                min-width: 50px;
            `;

            var colorInput = document.createElement('input');
            colorInput.type = 'color';
            colorInput.value = currentColor;
            colorInput.style.cssText = `
                width: 40px;
                height: 40px;
                border: none;
                border-radius: 6px;
                cursor: pointer;
                background: transparent;
            `;
            colorInput.addEventListener('change', function() {
                currentColor = this.value;
            });

            var colorPresets = document.createElement('div');
            colorPresets.style.cssText = `
                display: flex;
                gap: 4px;
                flex-wrap: wrap;
            `;
            var presetColors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', '#ffffff', '#000000'];
            presetColors.forEach(function(color) {
                var colorBtn = document.createElement('button');
                colorBtn.style.cssText = `
                    width: 24px;
                    height: 24px;
                    border-radius: 4px;
                    border: 2px solid rgba(255,255,255,0.3);
                    background: ${color};
                    cursor: pointer;
                `;
                colorBtn.addEventListener('click', function() {
                    currentColor = color;
                    colorInput.value = color;
                });
                colorPresets.appendChild(colorBtn);
            });

            // colorGroup.appendChild(colorLabel);
            // colorGroup.appendChild(colorInput);
            // colorGroup.appendChild(colorPresets);
            // drawingControls.appendChild(colorGroup);

            // Brush size
            var sizeGroup = document.createElement('div');
            sizeGroup.style.cssText = `
                display: flex;
                align-items: center;
                gap: 10px;
            `;

            var sizeLabel = document.createElement('label');
            sizeLabel.textContent = 'Size:';
            sizeLabel.style.cssText = `
                color: #fff;
                font-size: 14px;
                font-weight: 600;
                min-width: 50px;
            `;
            var sizeSlider = document.createElement('input');
            sizeSlider.type = 'range';
            sizeSlider.min = '1';
            sizeSlider.max = '20';
            sizeSlider.value = currentSize;
            sizeSlider.style.cssText = `
                flex: 1;
                height: 6px;
                border-radius: 3px;
                background: rgba(255,255,255,0.2);
                outline: none;
                cursor: pointer;
            `;
            sizeSlider.addEventListener('input', function() {
                currentSize = parseInt(this.value);
                sizeDisplay.textContent = this.value + 'px';
            });

            var sizeDisplay = document.createElement('span');
            sizeDisplay.textContent = currentSize + 'px';
            sizeDisplay.style.cssText = `
                color: #fff;
                font-size: 12px;
                min-width: 35px;
                text-align: right;
            `;

            sizeGroup.appendChild(sizeLabel);
            sizeGroup.appendChild(sizeSlider);
            sizeGroup.appendChild(sizeDisplay);
            drawingControls.appendChild(sizeGroup);

            // Opacity
            var opacityGroup = document.createElement('div');
            opacityGroup.style.cssText = `
                display: flex;
                align-items: center;
                gap: 10px;
            `;

            var opacityLabel = document.createElement('label');
            opacityLabel.textContent = 'Opacity:';
            opacityLabel.style.cssText = `
                color: #fff;
                font-size: 14px;
                font-weight: 600;
                min-width: 50px;
            `;
            var opacitySlider = document.createElement('input');
            opacitySlider.type = 'range';
            opacitySlider.min = '0.1';
            opacitySlider.max = '1';
            opacitySlider.step = '0.1';
            opacitySlider.value = currentOpacity;
            opacitySlider.style.cssText = `
                flex: 1;
                height: 6px;
                border-radius: 3px;
                background: rgba(255,255,255,0.2);
                outline: none;
                cursor: pointer;
            `;
            opacitySlider.addEventListener('input', function() {
                currentOpacity = parseFloat(this.value);
                opacityDisplay.textContent = Math.round(this.value * 100) + '%';
            });

            var opacityDisplay = document.createElement('span');
            opacityDisplay.textContent = Math.round(currentOpacity * 100) + '%';
            opacityDisplay.style.cssText = `
                color: #fff;
                font-size: 12px;
                min-width: 35px;
                text-align: right;
            `;

            opacityGroup.appendChild(opacityLabel);
            opacityGroup.appendChild(opacitySlider);
            opacityGroup.appendChild(opacityDisplay);
            drawingControls.appendChild(opacityGroup);

            // Drawing actions
            var drawingActions = document.createElement('div');
            drawingActions.style.cssText = `
                display: flex;
                gap: 8px;
                margin-top: 10px;
            `;

            // ...existing code...
                        var clearBtn = createButton('Clear', 'btn-outline-warning btn-sm', function() {
                            clearDrawing();
                        });
                        clearBtn.style.cssText = `
                            flex: 1;
                        `;

                        var undoBtn = createButton('Undo', 'btn-outline-info btn-sm', function() {
                            clearDrawing();
                        });
                        undoBtn.style.cssText = `
                            flex: 1;
                        `;

                        var gridToggleBtn = createButton('Show Grid', 'btn-outline-light btn-sm', function() {
                            showGrid = !showGrid;
                            this.innerHTML = (showGrid ? 'Hide Grid' : 'Show Grid');
                            if (showGrid) {
                                renderGrid();
                            } else {
                                clearGrid();
                            }
                        });
                        gridToggleBtn.style.cssText = `
                            flex: 1;
                        `;

                        drawingActions.appendChild(clearBtn);
                        drawingActions.appendChild(undoBtn);
                        drawingActions.appendChild(gridToggleBtn);
            // ...existing code...

            drawingGroup.appendChild(toolSelection);
            drawingGroup.appendChild(drawingControls);
            drawingGroup.appendChild(drawingActions);
            sidebar.appendChild(drawingGroup);

            // Info Display
            var infoGroup = createControlGroup('📊 Image Info');
            var infoDisplay = document.createElement('div');
            infoDisplay.style.cssText = `
                background: rgba(0,0,0,0.3);
                color: #fff;
                padding: 12px;
                border-radius: 6px;
                font-size: 12px;
                line-height: 1.6;
                margin-top: 10px;
                font-family: 'Courier New', monospace;
                border: 1px solid rgba(255,255,255,0.1);
            `;
            infoGroup.appendChild(infoDisplay);
            sidebar.appendChild(infoGroup);

            // Update info function
            function updateInfo() {
                var imageData = cropper.getImageData();
                var canvasData = cropper.getCanvasData();
                var cropBoxData = cropper.getCropBoxData();
                var zoomRatio = Math.round((canvasData.width / imageData.naturalWidth) * 100);

                zoomDisplay.textContent = zoomRatio + '%';

                infoDisplay.innerHTML =
                    '<strong>Dimensions:</strong> ' + Math.round(cropBoxData.width) + ' × ' + Math.round(cropBoxData.height) + 'px<br>' +
                    '<strong>Position:</strong> ' + Math.round(cropBoxData.left) + ', ' + Math.round(cropBoxData.top) + '<br>' +
                    '<strong>Zoom:</strong> ' + zoomRatio + '%<br>' +
                    '<strong>Rotation:</strong> ' + Math.round(imageData.rotate) + '°<br>' +
                    '<strong>Scale:</strong> ' + Math.round(imageData.scaleX * 100) + '% × ' + Math.round(imageData.scaleY * 100) + '%';
            }

            // Initial info update
            setTimeout(updateInfo, 100);

            // Keyboard shortcuts
            editor.addEventListener('keydown', function(e) {
                switch(e.key) {
                    case 'Escape':
                        document.body.removeChild(editor);
                        break;
                    case 'Enter':
                        document.body.removeChild(editor);
                        var croppedImageData = cropper.getCroppedCanvas().toDataURL(file.type);
                        var blob = dataURItoBlob(croppedImageData);
                        var croppedFile = new File([blob], file.name, { type: file.type });
                        callback(croppedFile);
                        break;
                    case 'r':
                    case 'R':
                        if (e.ctrlKey) {
                            cropper.reset();
                        }
                        break;
                }
            });

            // Focus the editor for keyboard shortcuts
            editor.tabIndex = 0;
            editor.focus();
        };

        function dataURItoBlob(dataURI) {
            var byteString = atob(dataURI.split(',')[1]);
            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            return new Blob([ab], { type: mimeString });
        }
        $(document).on('dragover', function(e) {
            e.preventDefault();
        });

        $(document).on('drop', function(e) {
            e.preventDefault();
        });

        $(document).on("mouseenter", "._dropzone", function () {
            const key = $(this).attr('key')
            if(dropzone_state["key"+key] == 'inactive') {
                $(this).find("._dropzone_hover").removeClass('_dropzone_hover_hidden')
            }
            if(dropzone_state["key"+key] == 'active') {
                $(this).find('._dropzone_added').addClass('_dropzone_added_hidden')
                $(this).find('._dropzone_remove').removeClass('_dropzone_remove_hidden')
                  $(this).find('._dropzone_edit').removeClass('_dropzone_remove_hidden')
            }
        })

        $(document).on('mouseleave', "._dropzone", function () {
            const key = $(this).attr('key')
            if(dropzone_state["key"+key] == 'inactive') {
                $(this).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
            }
            if(dropzone_state["key"+key] == 'active') {
                $(this).find('._dropzone_added').removeClass('_dropzone_added_hidden')
                $(this).find('._dropzone_remove').addClass('_dropzone_remove_hidden')
                 $(this).find('._dropzone_edit').addClass('_dropzone_remove_hidden')
            }
        })

        $(document).on('drop', '._dropzone_template', async function (e) {
            e.preventDefault();
            const key = $(this).attr('template-key')
            if(dropzone_state["key"+key] == 'inactive') {
                var file = e.originalEvent.dataTransfer.files[0];
                if (file) {
                    var fileSize = file.size / 1024 / 1024; // in MB
                    var fileType = file.type.split('/').shift(); // get file type

                    var fileName = file.name;
                    var fileExtension = fileName.split('.').pop().toLowerCase(); // get file extension

                    if(key == 1 || key == 2) {
                        if (fileExtension !== 'stl' && fileExtension !== 'ply') {
                            dropzone_reset_state(key, "Please drop a stl or ply file.")
                            return false;
                        }
                        const scan = $('._dropzone_template #key'+ (key == 1 ? 2 : 1)).attr('file')
                        if(scan != "" && scan != undefined) {
                            if(scan.split(".")[1] === "stl" && fileExtension === "ply") {
                                dropzone_reset_state(key, "Please drop a stl file.")
                                return false;
                            }
                            if(scan.split(".")[1] == "ply" && fileExtension === "stl") {
                                dropzone_reset_state(key, "Please drop a ply file.")
                                return false;
                            }
                        }
                        dropzone_upload(key, file)
                    }
                    else {
                        if (fileType !== 'image') {
                            dropzone_reset_state(key, "Please drop an image file.")
                            return false;
                        }

                        if (fileSize > 20) {
                            dropzone_reset_state(key, "Image size must be less than 20MB.")
                            return false;
                        }
                        dropzone_upload(key, file)
                        // let confirm = await ui.confirm("Do you want to edit Image?");
                        // if(confirm) {
                        //     openImageEditor(file, function(croppedFile) {
                        //         dropzone_upload(key, croppedFile)
                        //     });
                        // } else {
                        //     dropzone_upload(key, file)
                        // }
                    }
                }
            }
        })

        $(document).on('click', '._dropzone', function (e) {
            const key = $(this).attr('key')
            if(dropzone_state["key"+key] == 'inactive') {
                $("._dropzone_template #key"+key).trigger('click')
            }
            if(dropzone_state["key"+key] == 'active') {

               // dropzone_destroy_state(key)
            }
        })

          $(document).on('click', '._dropzone_remove', function (e) {
                       const key = $(this).parent().attr('key')
                 dropzone_destroy_state(key)
          });
               $(document).on('click', '._dropzone_edit', function (e) {
                       const key = $(this).parent().attr('key')


        var file = $("._dropzone_template #key" + key).attr('file');

        var imageUrl="{{asset('storage/PatientFiles/Patient')}}{{$patient->patient_id}}/"+file;
    if (file) {
  fetch(imageUrl)
            .then(response => response.blob()) // Convert the image to a blob
            .then(blob => {
                const file = new File([blob], "editedImage.jpg", { type: blob.type }); // Create a new File object
                // Open image editor and pass the file object
                openImageEditor(file, function(croppedFile) {
                    dropzone_upload(key, croppedFile); // Upload the edited image
                });
            })
            .catch(err => console.error("Error fetching the image: ", err));

    } else {
        console.error("No file found for editing in the dropzone.");
    }
          });


        $(document).on('change', '._dropzone_template input[data-field]', async function () {
            const key = $(this).attr('data-field')
            var file = this.files[0];
            if (file) {
                var fileSize = file.size / 1024 / 1024;
             //   var fileSize = file.size; // in MB
                var fileType = file.type.split('/').shift(); // get file type

                var fileName = file.name;
                var fileExtension = fileName.split('.').pop().toLowerCase(); // get file extension

                if(key == 1 || key == 2) {
                        if (fileExtension !== 'stl' && fileExtension !== 'ply') {
                            dropzone_reset_state(key, "Please drop a stl or ply file.")
                            return false;
                        }
                        const scan = $('._dropzone_template #key'+ (key == 1 ? 2 : 1)).attr('file')
                        if(scan != "" && scan != undefined) {
                            if(scan.split(".")[1] === "stl" && fileExtension === "ply") {
                                dropzone_reset_state(key, "Please drop a stl file.")
                                return false;
                            }
                            if(scan.split(".")[1] == "ply" && fileExtension === "stl") {
                                dropzone_reset_state(key, "Please drop a ply file.")
                                return false;
                            }
                        }
                        dropzone_upload(key, file)
                    } else {
                    if (fileType !== 'image') {
                        dropzone_reset_state(key, "Please upload an image file")
                        return false;
                    }

                    if (fileSize > 20) {
                        dropzone_reset_state(key, "Image size must be less then 20mb.")
                        return false;
                    }
                    dropzone_upload(key, file)
                    // let confirm = await ui.confirm("Do you want to edit Image?");
                    // if(confirm) {
                    //     openImageEditor(file, function(croppedFile) {
                    //         dropzone_upload(key, croppedFile)
                    //     });
                    // } else {
                    //     dropzone_upload(key, file)
                    // }
                }
            }
        })

        if($("._dropzone_template #key1").attr('file') != "") {
            dropzone_active_state('1', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key2").attr('file') != "") {
            dropzone_active_state('2', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key3").attr('file') != "") {
            dropzone_active_state('3', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key4").attr('file') != "") {
            dropzone_active_state('4', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key5").attr('file') != "") {
            dropzone_active_state('5', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key6").attr('file') != "") {
            dropzone_active_state('6', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key7").attr('file') != "") {
            dropzone_active_state('7', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key8").attr('file') != "") {
            dropzone_active_state('8', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key9").attr('file') != "") {
            dropzone_active_state('9', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key10").attr('file') != "") {
            dropzone_active_state('10', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key11").attr('file') != "") {
            dropzone_active_state('11', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key12").attr('file') != "") {
            dropzone_active_state('12', $("._dropzone_template #key1").attr('file'))
        }
        if($("._dropzone_template #key13").attr('file') != "") {
            dropzone_active_state('13', $("._dropzone_template #key1").attr('file'))
        }
    });
    </script>
    <script>
        $(document).ready(function() {
            // When an advisor is selected
            $('#advisor').change(function() {
                if ($(this).val()) {
                    // Show additional divs
                    $('#additionalDivs').removeClass('d-none');
                    // Make the checkbox required
                    $('#consultant_agreement').prop('required', true);
                } else {
                    // Hide additional divs if no advisor is selected
                    $('#additionalDivs').addClass('d-none');
                    // Remove the required attribute from the checkbox
                    $('#consultant_agreement').prop('required', false);
                }
            });
        });
    </script>
<script>
    const PHASE = '{{$patient->phase}}'
    var link_regex =
            /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[/?#]\S*)?$/


        $(document).ready(function() {



            $(document).on('change', '.hyperlink', function() {
                var link = $(this).val();
                if (!link_regex.test(link)) {
                    $(this).val('');
                }
            });
            $(document).on('input', '.hyperlink', function() {
                var link = $(this).val();
                if (link_regex.test(link)) {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
            });

            // function fetchOverview()
            // {
            //     fetch(`{{url('/patient/fetch-case-overview/'.$hashids->encode($patient->id).'?i=true')}}`)
            //         .then(response => response.text())
            //         .then(html => {
            //             $("#overview-container").html(html)
            //         })
            //         .catch(error => console.error('Error fetching HTML:', error));
            // }
            function fetchOverview() {
                // ensure loader is visible when fetching overview
                try { showLoader(); } catch(e) { /* noop if showLoader undefined */ }
                $.ajax({
                    url: `{{ url('/patient/fetch-case-overview/' . $hashids->encode($patient->id) . '?i=true') }}`,
                    type: "GET",
                    success: function(response) {
                        $("#overview-container").html(response);
                        hideLoader();
                    },
                    error: function(xhr) {
                        console.error("Error fetching HTML:", xhr);
                        hideLoader();
                    }
                });
            }

            // Listen for click events on tab links
            // $('ul.nav-pills a').on('click', async function(e) {
            //     e.preventDefault();
            //     // Get the ID of the clicked tab
            //     var targetTab = $(this).attr('href');
            //     var newUrl = window.location.pathname + '?tab=' + targetTab.substring(1);
            //     window.history.pushState({}, '', newUrl);

            //     if(targetTab == '#pill-tab-div5') {
            //         showLoader();
            //         fetchOverview()
            //     }

            //     if (targetTab == '#pill-tab-div6') {
            //         try {
            //             const response = await $.ajax({
            //                 type: "POST",
            //                 url: "{{ url('/patient/validate-data') }}",
            //                 data: {
            //                     "_token": "{{ csrf_token() }}",
            //                     "treatment_plan_id": "{{ $patient->id }}",
            //                     "patient_id": "{{ $patient->patient_id }}"
            //                 },
            //                 beforeSend() {
            //                     showLoader();
            //                 }
            //             });


            //             const fn1 = response.fn1;
            //             const fn2 = response.fn2;
            //             const fn3 = response.fn3;
            //             const fn4 = response.fn4;

            //             let html = ``;
            //             let incompleteCount = 0;
            //             let incompleteSections = [];

            //             // Build detailed error messages
            //             if (fn1 == 0) {
            //                 html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
            //                 <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
            //                 <p class="mb-0 flex-1">Patient Info section is not complete!</p>
            //                 </div>`;
            //                 incompleteCount++;
            //                 incompleteSections.push('Patient Info');
            //             }
            //             if (fn2 == 0) {
            //                 html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
            //                 <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
            //                 <p class="mb-0 flex-1">Scan Data section is not complete!</p>
            //                 </div>`;
            //                 incompleteCount++;
            //                 incompleteSections.push('Scan Data');
            //             }

            //             if (fn3 == 0) {
            //                 html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
            //                 <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
            //                 <p class="mb-0 flex-1">Images / X-Rays section is not complete!</p>
            //                 </div>`;
            //                 incompleteCount++;
            //                 incompleteSections.push('Images / X-Rays');
            //             }
            //             if (fn4 == 0) {
            //                 html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
            //                 <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
            //                 <p class="mb-0 flex-1">Prescription section is not complete!</p>
            //                 </div>`;
            //                 incompleteCount++;
            //                 incompleteSections.push('Prescription');
            //             }

            //             if (html != ``) {
            //                 // Add summary message at top
            //                 let summaryMsg = `<div class="alert alert-warning border-2 d-flex align-items-center mb-3" role="alert">
            //                 <div class="bg-warning me-3 icon-item"><span class="fas fa-exclamation-triangle text-white fs-3"></span></div>
            //                 <p class="mb-0 flex-1"><strong>${incompleteCount} section(s) incomplete:</strong> ${incompleteSections.join(', ')}</p>
            //                 </div>`;
            //                 html = summaryMsg + html;

            //                 $(".finish").fadeOut();
            //                 $(".notifications").html(html);
            //                 $(".notifications").fadeIn();
            //             } else {
            //                 $(".notifications").html(html);
            //                 $(".notifications").fadeOut();
            //                 $(".finish").fadeIn();

            //                 // validation passed — show Confirm & Submit tab
            //                 let tabElement = document.querySelector('ul.nav-pills a[href="#pill-tab-div6"]');
            //                 if (tabElement) {
            //                     let tabObj = new bootstrap.Tab(tabElement);
            //                     tabObj.show();
            //                 }
            //             }

            //         } catch (err) {
            //             toastError("Not able to proceed. check your internet connection.");
            //         } finally {
            //             hideLoader();
            //         }
            //     } else {
            //         let tab = document.querySelector('ul.nav-pills a[href="' + targetTab + '"]');
            //         let tabObj = new bootstrap.Tab(tab);
            //         tabObj.show();
            //     }


            // });

             $('ul.nav-pills a').on('click', async function(e) {
                e.preventDefault();
                // Get the ID of the clicked tab
                var targetTab = $(this).attr('href');
                var newUrl = window.location.pathname + '?tab=' + targetTab.substring(1);
      window.history.pushState({}, '', newUrl);

                if(targetTab == '#pill-tab-div5') {
                    fetchOverview()
                }

                if (targetTab == '#pill-tab-div6') {
                    let responseCall = await $.ajax({
                        type: "POST",
                        url: "{{ url('/patient/validate-data') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "treatment_plan_id": "{{ $patient->id }}",
                            "patient_id": "{{ $patient->patient_id }}"
                        },
                        beforeSend() {
                            showLoader();
                        }
                    }).done(function(response) {
                        //console.log(response)
                        const fn1 = response.fn1;
                        const fn2 = response.fn2;
                        const fn3 = response.fn3;
                        const fn4 = response.fn4;

                        let html = ``;
                        if (fn1 == 0) {
                            html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                            <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
                            <p class="mb-0 flex-1">Patient Info section is not complete!</p>
                            </div>`;
                        }
                        if (fn2 == 0) {
                            html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                            <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
                            <p class="mb-0 flex-1">Scan Data section is not complete!</p>
                            </div>`;
                        }

                        if (fn3 == 0) {
                            html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                            <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
                            <p class="mb-0 flex-1">Images / X-Rays section is not complete!</p>
                            </div>`;
                        }
                        if (fn4 == 0) {
                            html += `<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                            <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
                            <p class="mb-0 flex-1">Prescription section is not complete!</p>
                            </div>`;
                        }
                        if (html != ``) {
                            $(".finish").fadeOut();
                            $(".notifications").html(html);
                            $(".notifications").fadeIn();
                        } else {
                            $(".notifications").html(html);
                            $(".notifications").fadeOut();
                            $(".finish").fadeIn();
                        }
                        // Activate the clicked tab
                        $('ul.nav-pills a[href="' + targetTab + '"]').tab('show');

                                hideLoader();
                        }).fail(function(response) {
                            toastError("Not able to proceed. check your internet connection.");
                            hideLoader();
                        });
                } else {
                    // Activate the clicked tab
                    $('ul.nav-pills a[href="' + targetTab + '"]').tab('show');
                }


            });

            // Fetch overview whenever the Case Overview tab becomes active (covers clicks and programmatic tab shows)
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                try {
                    var activatedId = e.target ? e.target.id : null;
                    if (activatedId === 'pill-tab-li5' || $(e.target).attr('href') == '#pill-tab-div5') {
                        fetchOverview();
                    }
                } catch(err) {
                    console.error('Error handling shown.bs.tab for overview tab', err);
                }
            });

            @if(@$_GET['tab'])
                try { showLoader(); } catch(e) { }
                fetchOverview()
                let tabSelector = 'ul.nav-pills a[href="#{{ $_GET["tab"] }}"]';
                let tabEl = document.querySelector(tabSelector);

                if (tabEl) {
                    let tab = new bootstrap.Tab(tabEl);
                    tab.show();
                }
            @endif


        });
</script>
<script>
    const mode = "{{$mode}}";
        const midlineCheckboxes = document.querySelectorAll('input[name="midline"]');
        const archformCheckboxes = document.querySelectorAll('input[name="archform"]');
        const classCheckboxes = document.querySelectorAll('input[name="class"]');
        const occlusalCheckboxes = document.querySelectorAll('input[name="occlusal_plan"]');

        const checkboxBehavior = (checkboxes) => {
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('click', (event) => {
                    const clickedCheckbox = event.target;
                    const isAlreadyChecked = clickedCheckbox.checked;

                    checkboxes.forEach(otherCheckbox => {
                        if (otherCheckbox !== clickedCheckbox) {
                            otherCheckbox.checked = false;
                        }
                    });

                    if (!isAlreadyChecked) {
                        clickedCheckbox.checked = true;
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', () => {
                checkboxes.forEach(checkbox => {
                    if(mode == 'add') {
                        checkbox.checked = false;
                    }
                });
            });
        };

        checkboxBehavior(midlineCheckboxes);
        checkboxBehavior(archformCheckboxes);
        checkboxBehavior(classCheckboxes);
        checkboxBehavior(occlusalCheckboxes);


        $(document).ready(function() {
            $('#limits').on('input', function(event) {
                var val = parseFloat($(this).val());

                if (isNaN(val) || val < 0.1 || val > 0.6) {
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            $("#limits").on('change', function() {
                var val = parseFloat($(this).val());
                if (isNaN(val) || val < 0.1 || val > 0.6) {
                    $(this).val('');
                }
            });
            $("#first_name, #last_name, #dob").on('input', function() {
                if ($(this).val() != '') {
                    $(this).removeClass('is-invalid');
                } else {
                    $(this).addClass('is-invalid');
                }
            });
        });
</script>


<script >


        $(document).ready(function() {
            const fp = flatpickr($(".pickr"), {
                dateFormat: "d-m-Y", // 2026-02-06
                allowInput: true
            });

            function parseDMY(dateStr) {
                const [dd, mm, yyyy] = dateStr.split("-");
                return new Date(yyyy, mm - 1, dd);
            }

            function formatDMY(date) {
                const dd = String(date.getDate()).padStart(2, "0");
                const mm = String(date.getMonth() + 1).padStart(2, "0");
                const yyyy = date.getFullYear();
                return `${dd}-${mm}-${yyyy}`;
            }
            // document.getElementById("startDate").addEventListener("change", function () {
           $(document).on('change', '#startDate', function () {
                const startValue = this.value;
                if (!startValue) return;

                const start = parseDMY(startValue);

                const end = new Date(start);
                end.setDate(end.getDate() + 3);

                $('#endDate').val(formatDMY(end));
            });


            // document.getElementById("endDate").addEventListener("change", function () {
            $(document).on('change', '#endDate', function () {
                const endValue = this.value;
                if (!endValue) return;

                const end = parseDMY(endValue);

                const start = new Date(end);
                start.setDate(start.getDate() - 3);

                $('#startDate').val(formatDMY(start));
            });

            $(document).on('change', 'input[name=pricing_package]', function () {
                if($(this).is(":checked")) {
                    $("input[name=client_preferred_package]").val($(this).val());
                }
            });

            $("#submit-patient-info").on('click', function() {
                var first_name = $("#first_name").val();
                var last_name = $("#last_name").val();
                var dob = $("#dob").val();
                if (first_name == '') {
                    $("#first_name").addClass('is-invalid');
                }
                if (last_name == '') {
                    $("#last_name").addClass('is-invalid');
                }
                if (dob == '') {
                    $("#dob").addClass('is-invalid')
                }
                if (first_name == '' || last_name == '' || dob == '') {
                    toastError("Enter required data.");
                    return false;
                }
                $.ajax({
                    type: "POST",
                    url: "{{ url('/patient/patient-info/save') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "first_name": first_name,
                        "last_name": last_name,
                        "dob": dob,
                        "treatment_plan_id": "{{ $patient->id }}",
                        "patient_id": "{{ $patient->patient_id }}"
                    },
                }).done(function(response) {
                    $("#submit-prescription").attr('fn', 1);
                    $("#pill-tab-li-treatment-type").click();
                    // let tabEl = document.querySelector('#pill-tab-li-treatment-type');
                    // let tab = new bootstrap.Tab(tabEl);
                    // tab.show();
                    toastSuccess("Patient Info Saved");
                }).fail(function(response) {
                    $("#submit-prescription").attr('fn', 0);
                    toastError("Enable to save patient info");
                });
            });

            $("#submit-treatment-plan").on('click', function() {
                 let selectedPlan = $("input[name='plan']:checked").val();

                if (!selectedPlan) {
                    toastError("Please select treatment type");
                    return; // stop execution
                }
                $.ajax({
                    type: "POST",
                    url: "{{ url('/patient/patient-info/selected-plan') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "treatment_type": selectedPlan, // 👈 send selected treatment type
                        "treatment_plan_id": "{{ $patient->id }}",
                        "patient_id": "{{ $patient->patient_id }}"
                    },
                }).done(function(response) {
                    $("#submit-treatment-plan").attr('disabled', false);
                    // let tabEl = document.querySelector('#pill-tab-li2');
                    // let tab = new bootstrap.Tab(tabEl);
                    // tab.show();
                    $("#pill-tab-li2").click();
                    toastSuccess("Patient treatment plan info saved");
                }).fail(function(response) {
                    $("#submit-treatment-plan").attr('disabled', true);
                    toastError("Unable to save treatment plan");
                });
            });

            $("#submit-scan-data").on('click', function() {
                var fl_upper_arch = $("#fl_upper_arch").val();
                var fl_lower_arch = $("#fl_lower_arch").val();
                if ($("#key1").attr('file') == '' || $("#key2").attr('file') == '') {
                    toastError("Upload scan data files.");
                    $("#submit-prescription").attr('fn', 0);
                    return false;
                }
                $("#submit-prescription").attr('fn', 1);
                // let tabEl = document.querySelector('#pill-tab-li3');
                // let tab = new bootstrap.Tab(tabEl);
                // tab.show();
                 $("#pill-tab-li3").click();
                toastSuccess("Scan data Saved");
                // $.ajax({
                //     type: "POST",
                //     url: "{{ url('/patient/scan-data/save') }}",
                //     data: {
                //         "_token": "{{ csrf_token() }}",
                //         "fl_upper_arch": fl_upper_arch,
                //         "fl_lower_arch": fl_lower_arch,
                //         "treatment_plan_id": "{{ $patient->id }}",
                //         "patient_id": "{{ $patient->patient_id }}"
                //     },
                // }).done(function (response) {
                //     $("#submit-prescription").attr('fn', 1);
                //     $("#pill-tab-li3").click();
                //     toastSuccess("Patient Info Saved");
                // }).fail(function (response) {
                //     $("#submit-prescription").attr('fn', 0);
                //     toastError("Enable to save patient info");
                // });
            });
            //
            $("#submit-images").on('click', function() {
                if (PHASE == '1' && ($("#key3").attr('file') == '' || $("#key4").attr('file') == '' || $("#key5").attr('file') == '' || $("#key6").attr('file') == '' || $("#key7").attr('file') == '' || $("#key8").attr('file') == '' || $("#key9").attr('file') == '' || $("#key10").attr('file') == '' || $("#key11").attr('file') == '' || $("#key12").attr('file') == '')) {
                    $("#submit-images").attr('fn', 0);
                    toastError("Upload all required images.");
                } else {
                    const hyperlink = $("#general_upload_hyperlink").val();
                    if(hyperlink == '') {
                        $("#submit-images").attr('fn', 1);
                        // let tabTrigger = new bootstrap.Tab(document.querySelector('#pill-tab-li4'));
                        // tabTrigger.show();
                        $("#pill-tab-li4").click();
                        toastSuccess("Images / X-Rays saved");
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "{{ url('/patient/images/save') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "hyperlink": hyperlink,
                                "treatment_plan_id": "{{ $patient->id }}",
                                "patient_id": "{{ $patient->patient_id }}"
                            },
                        }).done(function(response) {
                            $("#submit-images").attr('fn', 1);
                            // let tabEl = document.querySelector('#pill-tab-li4');
                            // let tab = new bootstrap.Tab(tabEl);
                            // tab.show();
                            $("#pill-tab-li4").click();
                            toastSuccess("Images / X-Rays saved");
                        }).fail(function(response) {
                            $("#submit-images").attr('fn', 0);
                            toastError("Enable to save X-Ray/Images");
                        });
                    }

                }
            });
            //
            $("#submit-prescription").on('click', function() {
                var fd = new FormData();
                //prefered treatment
                var upper_arch = $("input[name=upper_arch]:checked").val() || '0';
                fd.append("upper_arch", upper_arch);
                var lower_arch = $("input[name=lower_arch]:checked").val() || '0';
                fd.append("lower_arch", lower_arch);
                if (upper_arch == '0' && lower_arch == '0' || upper_arch == undefined || lower_arch ==
                    undefined || upper_arch == null || lower_arch == null) {
                        $("input[name=upper_arch]").addClass('is-invalid');
                        $("input[name=lower_arch]").addClass('is-invalid');
                    toastError("Select your preferred treatment either upper or lower arch or both.");
                    return false;
                }
                $("input[name=upper_arch]").removeClass('is-invalid');
                $("input[name=lower_arch]").removeClass('is-invalid');
                //midline
                var midline = $("input[name=midline]:checked").val() || '';
                fd.append("midline", midline);
                var align_to_facial_midline = $("input[name=align_to_facial_midline]:checked").val() || '';
                fd.append('align_to_facial_midline', align_to_facial_midline);
                var midline_notes = $("textarea[name=midline_notes]").val();
                fd.append("midline_notes", midline_notes);
                if (midline == '' || midline == undefined || midline == null) {
                    $("input[name=midline]").addClass('is-invalid');
                    toastError("Midline section is required.");
                    return false;
                }
                $("input[name=midline]").removeClass('is-invalid');
                //archform
                var archform = $("input[name=archform]:checked").val() || '';
                fd.append("archform", archform);
                var archform_notes = $("textarea[name=archform_notes]").val();
                fd.append("archform_notes", archform_notes);
                if (archform == '' || archform == undefined || archform == null) {
                    $("input[name=archform]").addClass('is-invalid');
                    toastError("Archform section is required.");
                    return false;
                }
                $("input[name=archform]").removeClass('is-invalid');
                //class
                var clas = $("input[name=class]:checked").val() || '';
                fd.append("class", clas);
                var clas_notes = $("textarea[name=class_notes]").val();

                //pcp
                var pcp_ur = $('input[name="pcp_ur"]:checked').map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("pcp_ur", JSON.stringify(pcp_ur));
                var pcp_lr = $("input[name=pcp_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("pcp_lr", JSON.stringify(pcp_lr));
                var pcp_ul = $("input[name=pcp_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("pcp_ul", JSON.stringify(pcp_ul));
                var pcp_ll = $("input[name=pcp_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("pcp_ll", JSON.stringify(pcp_ll));
                //ctp
                var ctp_ur = $('input[name="ctp_ur"]:checked').map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ctp_ur", JSON.stringify(ctp_ur));
                var ctp_lr = $("input[name=ctp_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ctp_lr", JSON.stringify(ctp_lr));
                var ctp_ul = $("input[name=ctp_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ctp_ul", JSON.stringify(ctp_ul));
                var ctp_ll = $("input[name=ctp_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ctp_ll", JSON.stringify(ctp_ll));

                //i-hook
                var ihook_ur = $('input[name="ihook_ur"]:checked').map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ihook_ur", JSON.stringify(ihook_ur));
                var ihook_lr = $("input[name=ihook_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ihook_lr", JSON.stringify(ihook_lr));
                var ihook_ul = $("input[name=ihook_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ihook_ul", JSON.stringify(ihook_ul));
                var ihook_ll = $("input[name=ihook_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ihook_ll", JSON.stringify(ihook_ll));

                //notes
                fd.append("class_notes", clas_notes);
                if (clas == '' || clas == undefined || clas == null) {
                    $("input[name=class]").addClass('is-invalid');
                    toastError("Class section is required.");
                    return false;
                }
                $("input[name=class]").removeClass('is-invalid');
                //resolutions
                var size_issues = $("input[name=size_issues]:checked").val() || '';
                fd.append("size_issues", size_issues);
                if (size_issues == '' || size_issues == undefined || size_issues == null) {
                    $("input[name=size_issues]").addClass('is-invalid');
                    toastError("Resolve tooth size issues section is required. Select atleast an option.");
                    return false;
                }
                $("input[name=size_issues]").removeClass('is-invalid');
                var location_upper = $("select[name=location_upper]").val();
                fd.append("location_upper", location_upper);
                var location_lower = $("select[name=location_lower]").val();
                fd.append("location_lower", location_lower);
                console.log(location_upper)
                console.log(location_lower)


                if(size_issues === "IPR") {
                    if(upper_arch === '1' && lower_arch === '1') {
                        if (location_lower == '' || location_upper == '' || location_lower == undefined || location_lower == null || location_upper == undefined || location_upper == null) {
                            $("select[name=location_upper]").addClass('is-invalid');
                            $("select[name=location_lower]").addClass('is-invalid');
                            toastError("Select upper and lower locations.");
                            return false;
                        }
                    }
                    if(upper_arch === '1') {
                        if (location_upper == '' || location_upper == undefined || location_upper == null) {
                            $("select[name=location_upper]").addClass('is-invalid');
                            toastError("Select upper location.");
                            return false;
                        }
                    }
                    if(lower_arch === '1') {
                        if (location_lower == '' || location_lower == undefined || location_lower == null) {
                            $("select[name=location_lower]").addClass('is-invalid');
                            toastError("Select lower location.");
                            return false;
                        }
                    }
                }


                $("select[name=location_upper]").removeClass('is-invalid');
                        $("select[name=location_lower]").removeClass('is-invalid');
                var limits = $("input[name=limits]").val();
                fd.append("limits", limits);
                if (limits == '' || limits == undefined || limits == null) {
                    if(size_issues != "Restorative (No IPR)" && size_issues != "Accept best fit (No IPR/Restorative)")  {
                        $("input[name=limits]").addClass('is-invalid');
                        toastError("Enter Maximum Ant. IPR/Contact limit.");
                        return false;
                    }

                }
                $("input[name=limits]").removeClass('is-invalid');
                var ofp_ur = $('input[name="ofp_ur"]:checked').map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ofp_ur", JSON.stringify(ofp_ur));
                var ofp_lr = $("input[name=ofp_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ofp_lr", JSON.stringify(ofp_lr));
                var ofp_ul = $("input[name=ofp_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ofp_ul", JSON.stringify(ofp_ul));
                var ofp_ll = $("input[name=ofp_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("ofp_ll", JSON.stringify(ofp_ll));
                var tmr_ur = $('input[name="tmr_ur"]:checked').map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tmr_ur", JSON.stringify(tmr_ur));
                var tmr_lr = $("input[name=tmr_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tmr_lr", JSON.stringify(tmr_lr));
                var tmr_ul = $("input[name=tmr_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tmr_ul", JSON.stringify(tmr_ul));
                var tmr_ll = $("input[name=tmr_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                /* if (tmr_ur.length == 0 && tmr_lr.length == 0 && tmr_ul.length == 0 && tmr_ll.length == 0) {
                    toastError("Tooth movement restrictions Variable/schemes are required.");
                    return false;
                } **/
                fd.append("tmr_ll", JSON.stringify(tmr_ll));
                var mut_ur = $("input[name=mut_ur]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("mut_ur", JSON.stringify(mut_ur));
                var mut_lr = $("input[name=mut_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("mut_lr", JSON.stringify(mut_lr));
                var mut_ul = $("input[name=mut_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("mut_ul", JSON.stringify(mut_ul));
                var mut_ll = $("input[name=mut_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                /*if (mut_ur.length == 0 && mut_lr.length == 0 && mut_ul.length == 0 && mut_ll.length == 0) {
                    toastError("Missing or unenrupted teeth Variables/schemes are required.");
                    return false;
                }**/
                fd.append("mut_ll", JSON.stringify(mut_ll));
                var tbe_ur = $("input[name=tbe_ur]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tbe_ur", JSON.stringify(tbe_ur));
                var tbe_lr = $("input[name=tbe_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tbe_lr", JSON.stringify(tbe_lr));
                var tbe_ul = $("input[name=tbe_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tbe_ul", JSON.stringify(tbe_ul));
                var tbe_ll = $("input[name=tbe_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tbe_ll", JSON.stringify(tbe_ll));
                /* if (tbe_ur.length == 0 && tbe_lr.length == 0 && tbe_ul.length == 0 && tbe_ll.length == 0) {
                    toastError("To be extracted Variables/schemes are required.");
                    return false;
                } **/
                var resolution_notes = $("textarea[name=resolution_notes]").val();
                fd.append("resolution_notes", resolution_notes);
                //occlusal plane
                var occlusal_plan = $("input[name=occlusal_plan]:checked").val() || '';
                fd.append("occlusal_plane", occlusal_plan);
                var occlusal_plane_notes = $("textarea[name=occlusal_plane_notes]").val();
                fd.append("occlusal_plane_notes", occlusal_plane_notes);
                if (occlusal_plan == '' || occlusal_plan == undefined || occlusal_plan == null) {
                    $("input[name=occlusal_plan]").addClass('is-invalid');
                    toastError("Occlusal plan section is required.");
                    return false;
                }
                $("input[name=occlusal_plan]").removeClass('is-invalid');
                //special instructions
                 var additional_attachments = $('input[name="additional_attachments"]:checked').map(function() {
                    return $(this).val();
                }).get();
                fd.append("additional_attachments", JSON.stringify(additional_attachments));
                var additional_attachments_notes = $("textarea[name=additional_attachments_notes]").val();
                fd.append("additional_attachments_notes", additional_attachments_notes);

                var keep_already_place_attachments = $(
                    "input[name=keep_already_placed_attachments]:checked").val() || '0';
                fd.append("keep_already_place_attachments", keep_already_place_attachments);
                var aligner_trim_type_upper = $("select[name=trim_type_upper]").val();
                fd.append("aligner_trim_type_upper", aligner_trim_type_upper);
                var aligner_trim_type_lower = $("select[name=trim_type_lower]").val();
                fd.append("aligner_trim_type_lower", aligner_trim_type_lower);
                if (aligner_trim_type_lower == '' || aligner_trim_type_lower == undefined ||
                    aligner_trim_type_lower == null || aligner_trim_type_upper == '' ||
                    aligner_trim_type_upper == undefined || aligner_trim_type_upper == null) {
                        $("select[name=trim_type_upper]").addClass('is-invalid')
                        $("select[name=trim_type_lower]").addClass('is-invalid')
                    toastError("Aligner trim type lower and upper are required.");
                    return false;
                }
                $("select[name=trim_type_upper]").removeClass('is-invalid')
                $("select[name=trim_type_lower]").removeClass('is-invalid')

                //last aligners to cover
                var tla_ur = $("input[name=tla_ur]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tla_ur", JSON.stringify(tla_ur));
                var tla_lr = $("input[name=tla_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tla_lr", JSON.stringify(tla_lr));
                var tla_ul = $("input[name=tla_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tla_ul", JSON.stringify(tla_ul));
                var tla_ll = $("input[name=tla_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("tla_ll", JSON.stringify(tla_ll));

                if (tla_ur.length == 0 && tla_lr.length == 0 && tla_ul.length == 0 && tla_ll.length == 0) {
                    toastError("Please mark the last tooth you want the aligners to cover (Special Instructions).");
                    return false;
                }

                //Add Pontic
                var add_pontic_ur = $("input[name=add_pontic_ur]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_pontic_ur", JSON.stringify(add_pontic_ur));

                var add_pontic_ul = $("input[name=add_pontic_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_pontic_ul", JSON.stringify(add_pontic_ul));

                var add_pontic_lr = $("input[name=add_pontic_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_pontic_lr", JSON.stringify(add_pontic_lr));

                var add_pontic_ll = $("input[name=add_pontic_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_pontic_ll", JSON.stringify(add_pontic_ll));

                //Add Bite Turbos
                var add_bite_turbos_ur = $("input[name=add_bite_turbos_ur]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_bite_turbos_ur", JSON.stringify(add_bite_turbos_ur));

                var add_bite_turbos_ul = $("input[name=add_bite_turbos_ul]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_bite_turbos_ul", JSON.stringify(add_bite_turbos_ul));

                var add_bite_turbos_lr = $("input[name=add_bite_turbos_lr]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_bite_turbos_lr", JSON.stringify(add_bite_turbos_lr));

                var add_bite_turbos_ll = $("input[name=add_bite_turbos_ll]:checked").map(function() {
                    return $(this).data('number');
                }).get();
                fd.append("add_bite_turbos_ll", JSON.stringify(add_bite_turbos_ll));

                //csrf & id
                fd.append("_token", "{{ csrf_token() }}");
                fd.append("patient_id", "{{ $patient->patient_id }}");
                fd.append("treatment_plan_id", "{{ $patient->id }}");
                $.ajax({
                    type: "POST",
                   url: "{{ url('/patient/prescription/save') }}",
                    data: fd,
                    processData: false,
                    contentType: false,
                }).done(function(response) {
                    $("#submit-prescription").attr('fn', 1);
                    // let tabEl = document.querySelector('#pill-tab-li5');
                    // let tab = new bootstrap.Tab(tabEl);
                    // tab.show();
                    $("#pill-tab-li5").click();
                    toastSuccess("Prescription Saved");
                }).fail(function(response) {
                    $("#submit-prescription").attr('fn', 0);
                    toastError("Enable to save prescription");
                });
            });


            $(document).on('change', 'input[name=size_issues]', function () {
                if($(this).val() === 'IPR') {
                    $("#presc-location-section").removeClass('d-none');
                    $("#pres-limits-section").removeClass('d-none');
                } else {
                    $("#presc-location-section").addClass('d-none');
                    $("#pres-limits-section").addClass('d-none');
                    $("select[name=location_upper]").val('');
                    $("select[name=location_lower]").val('');
                    $("input[name=limits]").val('');
                }
            });

            $(document).on('click', '#select-from-shining3d-link', function () {
                const shining3dAuthUrl =
                    'https://dental3dcloud.com/p/index?' +
                    'codeChallenge={{ config("shining3d.shining3d_code_challenge") }}' +
                    '&codeChallengeMethod={{ config("shining3d.shining3d_code_challenge_method") }}' +
                    '&redirectUri={{ config("shining3d.shining3d_redirect_uri") }}' +
                    '&responseType=code' +
                    '&appId={{ config("shining3d.shining3d_app_id") }}' +
                    '&thirdUserID={{ Auth::user()->id }}' +
                    '&thirdUserName={{ Auth::user()->shining3d_org_name }}';

                // Redirect in same tab/page
                window.location.href = shining3dAuthUrl;
            });
        });


</script>

<script src="{{ asset('public/assets/customjs/dm-integration.js') }}"></script>
<script src="{{ asset('public/assets/customjs/add-patient.js') }}"></script>
<script src="{{ asset('public/assets/customjs/shining3d.js') }}?v={{ time() }}"></script>

<script>
    $(document).ready(function() {
        const params = new URLSearchParams(window.location.search);

        const code = params.get('code');
        const matchNode = params.get('matchNode');
        const codeChallenge = params.get('codeChallenge');
        const domain = params.get('domain');

        if (code && matchNode && codeChallenge && domain) {
            $('#order-from-shining3d-modal').modal('show');
        }

        DmIntegration.init();
        AddPatient.init();
        Shining3d.init();
    });
</script>

@stop
