@extends('layouts.app_base_horizontal')

@section('css')
<link href="{{ asset('public') }}/dashboard/vendors/glightbox/glightbox.min.css" rel="stylesheet">
<link href="{{ asset('public') }}/dashboard/vendors/prism/prism-okaidia.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('public/') }}/filepond/dist/filepond.css">
<link rel="stylesheet" href="{{ asset('public/') }}/filepond/dist/filepond-plugin-image-preview.css">
<link rel="stylesheet" href="{{ asset('public/assets') }}/restrictions.css">
<script src="{{ asset('public/assets/three/build/three.js') }}"></script>
<script type="importmap">
    {
        "imports": {
            "three": "{{asset('public/assets/three/build/three.module.js')}}",
            "OrbitControls": "{{asset('public/assets/three/examples/jsm/controls/OrbitControls.js')}}"
        }
    }
</script>

<style>
    #scan-data-canvas {
        max-height: 220px;
    }


    #sharesmile-canvas {
        opacity: 0;
    }

    #sharesmile-canvas[state=loaded] {
        opacity: 1;
    }

    div#canvas canvas {
        margin: 0 auto;
        /*border: 10px solid #c3e8f8;*/
        /*background: #f2f2f2;*/
    }

    .canvas-bg {
        background: #f2f2f2;
    }
</style>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
@stop

@section('content')
<div class="page-content">

    @if(@$_GET['i'] != 'true')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Demo Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/demo/patients/view')}}">Patients</a></li>
                        <li class="breadcrumb-item active">Case Overview</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endif

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
if ($patient->fl_front && $patient->fl_smile && $patient->fl_profile && $patient->fl_frontal &&
$patient->fl_right_buccal && $patient->fl_left_buccal && $patient->fl_upper_occlusal && $patient->fl_lower_occlusal &&
$patient->fl_panorex && $patient->fl_lateral_ceph) {
$fn3 = 1;
}
if (($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1) {
$fn4 = 1;
}
@endphp
@if(@$_GET['i'] != 'true')
<div class="card">
    <div class="card-body">
        <div class="row gx-0 kanban-header rounded-2 px-card py-2 ">
          @if(Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin')
          @php
          $pending_nemo_sync = DB::table('sync_queues')
->where('treatment_plan_id', $patient->id)->where('is_synced', 0)->where('is_cancelled', 0)->first();            @endphp
@if(@$pending_nemo_sync)
@php
$nemo_files_synced = 0;
if($pending_nemo_sync->is_fl_upper_arch_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->is_fl_lower_arch_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_front_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_smile_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_profile_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_frontal_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_right_buccal_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_left_buccal_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_upper_occlusal_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_lower_occlusal_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_panorex_synced == 1) {
  $nemo_files_synced++;
}
if($pending_nemo_sync->fl_lateral_ceph_synced == 1) {
  $nemo_files_synced++;
}
@endphp
<div class="col d-flex align-items-center">
  <p class="mb-0 text-info">Sync in progress ({{$nemo_files_synced}}/12) files synced.</p>
  </div>
@endif
          @endif
            <div class="col d-flex align-items-center">

                <div class="vertical-line vertical-line-400 position-relative h-100 mx-3"></div>
                @if(@$patient->is_completed == 1 && @$patient->tracking_id)
                <a class="text-success" href="{{$patient->tracking_id}}" target="_blank">Tracking Nr.</a>
                @endif

            </div>

            <div class="col-auto d-flex align-items-center">


                @if(Auth::user()->role == 'doctor')
        @if(@$patient->is_submitted == 1 && @$patient->is_completed == 0)
        @if(!DB::table('p_treatment_plans')->where('patient_id', $patient->patient_id)->where('phase', '>', $patient->phase)->exists())
        <a href="javascript:void(0);"
            class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block update-package" data-current="{{$patient->pricing_package}}"><span
                class="fas fa-cube me-2"></span>{{$patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT'}}</a>
        @endif
                @endif
        @endif

        @if(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')
        <a href="javascript:void(0);"
            class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block"><span
                class="fas fa-cube me-2"></span>{{$patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT'}}</a>
        @endif


                @if(@$patient->fl_profile && @$patient->fl_front && @$patient->fl_smile && @$patient->fl_upper_occlusal && @$patient->fl_lower_occlusal && @$patient->fl_right_buccal && @$patient->fl_frontal && @$patient->fl_left_buccal)
                <a href="javascript:;"
                    class="btn btn-sm btn-falcon-default me-2 d-none d-md-block "><span
                        class="fas fas fa-print me-2"></span>Images</a>

                        @endif



        {{-- @if(@$patient->is_completed == 1 && @$patient->tracking_id)
        <a href="{{url('/patient/print/images/'.$patient->id)}}"
            class="btn btn-sm btn-falcon-default me-2 d-none d-md-block "><span
                class="fas fa-check-double me-2"></span> Finish Treatment</a>
        @endif --}}



                @if ($patient->is_editable == 1 && Auth::user()->role == 'doctor')
                <a href="javascript:;"
                    class="btn btn-sm btn-falcon-default me-2 d-none d-md-block"><span
                        class="fas fas fa-edit me-2"></span>Edit</a>
                @endif
                @if ($patient->is_submitted == 0)
                <a href="javascript:;"
                    class="btn btn-sm btn-falcon-default me-2 d-none d-md-block"><span
                        class="fas fas fa-edit me-2"></span>Submit Case</a>
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
                @if(Auth::user()->role == 'doctor')
                <a href="javascript:;" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block"><span
                    class="fas fa-folder-open me-2"></span>Documentation</a>
                @endif
                <div class="dropdown font-sans-serif">
                    <a class="btn btn-sm btn-falcon-default me-2 d-none d-md-block dropdown-toggle" id="dropdownMenuLink"
                        href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Treatment
                        Plan {{ $patient->phase }}</a>
                    <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="dropdownMenuLink">
                        @foreach ($plans as $plan)
                        @if($plan->id != $patient->id)
                        <a class="dropdown-item" href="javascript:;">Treatment Plan
                            {{$plan->phase}}</a>
                        @endif
                        @endforeach
                        {{-- <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a> --}}
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endif


@if(@$_GET['i'] != 'true')

@if ($patient->is_submitted == 0)
<div class="alert alert-warning border-2 d-flex align-items-center" role="alert">
    <div class="bg-warning me-3 icon-item"><span class="fas fa-exclamation-circle text-white  fs-3"></span></div>
    @if($patient->phase == 1)
    <p class="mb-0 flex-1">Case is not submitted yet. You have to pay initial deposit amount of
        <strong>€150.00</strong>
        to submit!
    </p>
    @else
    <p class="mb-0 flex-1">Case is not submitted yet.
    </p>
    @endif
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@endif






<div class="row gx-2">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body py-4">

                <p><strong>Name:</strong> {{ $patient->first_name . ' ' . $patient->last_name }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->dob }}</p>
                {{-- @if ($patient->fl_upper_arch && $patient->fl_lower_arch && $patient->is_treatment_submitted == 0)
                <div class="container-fluid mx-0 my-3">
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
                                    class="btn-check model-control" name="btnradio" id="labial" autocomplete="off">
                                <label class="btn btn-outline-primary btn-square" for="labial">Front</label>
                                <input data-camerax="-10" data-visible="1" type="radio" class="btn-check model-control"
                                    name="btnradio" id="right_buccal" autocomplete="off">
                                <label class="btn btn-outline-primary btn-square" for="right_buccal">Right
                                    Buccal</label>
                                <input data-camerax="10" data-visible="1" type="radio" class="btn-check model-control"
                                    name="btnradio" id="left_buccal" autocomplete="off">
                                <label class="btn btn-outline-primary btn-square" for="left_buccal">Left
                                    Buccal</label>
                                <input data-camerax="-10" type="radio" class="btn-check model-control" name="btnradio"
                                    id="maxillary" autocomplete="off">
                                <label class="btn btn-outline-primary btn-square btn-square" for="maxillary">Upper
                                    Occlusal</label>
                                <input data-camerax="10" type="radio" class="btn-check model-control" name="btnradio"
                                    id="mandibular" autocomplete="off">
                                <label class="btn btn-outline-primary btn-square" for="mandibular">Lower
                                    Occlusal</label>
                            </div>
                            <div class="p-3">
                                <h6 class="mb-3 mt-0">Rotate Vertically</h6>
                                <input type="range" class="form-range" id="slider">
                            </div>
                            <div id="canvas" class="canvas-bg"></div>
                            @php
                            $upper_arch_stl = asset('/storage/PatientDemoFiles/Patient' .
                            $patient->patient_id . '/' . $patient->fl_upper_arch);
                            $lower_arch_stl = asset('/storage/PatientDemoFiles/Patient' .
                            $patient->patient_id . '/' . $patient->fl_lower_arch);
                            @endphp
                            <div class="btn-group float-end btns-steps" role="group"
                                aria-label="Basic radio toggle button group d-block" style="display:none !important;">
                                <?php
                                                    $step = 1;
                                                    ?>
                                <input data-maxillary="<?php echo $upper_arch_stl; ?>"
                                    data-mandibular="<?php echo $lower_arch_stl; ?>" data-cameraz="10" data-camerax="0"
                                    data-visible="1" type="radio" class="btn-check step-control" name="step-trigger"
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
                                <input value="0" type="range" class="form-range" min="0" max="<?php echo 1 - 1; ?>"
                                    id="customRange2" step="1">
                            </div>
                            <div class="btn-group d-none" aria-label="Basic example" role="group">
                                <button id="play-button" type="button" class="btn btn-outline-primary btn-square"><i
                                        class="fas fa-play"></i></button>
                            </div>

                        </div>
                    </div>
                </div>
                @endif --}}

                @if (@$patient->iframe_link)
                <div id="iframe-container">
                    <iframe src="{{ $patient->iframe_link }}" width="100%" height="700"
                        style="min-height: 700px;"></iframe>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <a href="{{ route('demo_iframe', $phase) }}" class="btn btn-primary" target="_blank">View on full screen</a>
                            </div>
                        </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>








<div class="row gx-2">
    <div class="col-md-8">


        <div class="card">
            <div class="card-body p-0">
                {{-- @if (@$patient->iframe_link && $patient->is_treatment_submitted == 1)
                <a class="btn btn-falcon-primary me-1 mb-1" target="_blank" href="{{ $patient->iframe_link }}">3D Editor
                </a>
                <br>
                @endif --}}
                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading2">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2">Scan
                                Data</button>
                        </h2>
                        <div class="accordion-collapse collapse " id="collapse2" aria-labelledby="heading2"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">


                                @if ($patient->fl_upper_arch)
                                <a href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_arch) }}"
                                    target="_blank" class="btn btn-link btn-sm ps-0 mt-2">Upper Arch <i
                                        class="fas fa-angle-right"></i></a>
                                @endif
                                @if ($patient->fl_upper_arch)
                                <a href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_arch) }}"
                                    target="_blank" class="btn btn-link btn-sm ps-0 mt-2">Lower Arch <i
                                        class="fas fa-angle-right"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading3">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse3" aria-expanded="true"
                                aria-controls="collapse3">Intraoral</button>
                        </h2>
                        <div class="accordion-collapse collapse " id="collapse3" aria-labelledby="heading3"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">

                                    @if ($patient->fl_frontal)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_frontal) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_frontal) }}?v={{rand(0,1000)}}"
                                                        alt="Frontal" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Frontal</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_frontal)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_upper_occlusal)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_occlusal) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_occlusal) }}?v={{rand(0,1000)}}"
                                                        alt="Upper Occlusal" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Upper Occlusal</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_upper_occlusal)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_lower_occlusal)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_occlusal) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_occlusal) }}?v={{rand(0,1000)}}"
                                                        alt="Lower Occlusal" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Lower Occlusal</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_lower_occlusal)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_right_buccal)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_right_buccal) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_right_buccal) }}?v={{rand(0,1000)}}"
                                                        alt="Right Buccal" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Right Buccal</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_right_buccal)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_left_buccal)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_left_buccal) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_left_buccal) }}?v={{rand(0,1000)}}"
                                                        alt="Left Buccal" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Left Buccal</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_left_buccal)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse4" aria-expanded="true"
                                aria-controls="collapse4">Extraoral</button>
                        </h2>
                        <div class="accordion-collapse collapse " id="collapse4" aria-labelledby="heading4"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    @if ($patient->fl_front)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_front) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_front) }}?v={{rand(0,1000)}}"
                                                        alt="Front" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Front</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_front)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_profile)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_profile) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_profile) }}?v={{rand(0,1000)}}"
                                                        alt="Profile" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Profile</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_profile)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_smile)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_smile) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_smile) }}?v={{rand(0,1000)}}"
                                                        alt="Smile" /> </a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Smile</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_smile)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading5">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse5" aria-expanded="true"
                                aria-controls="collapse5">X-ray</button>
                        </h2>
                        <div class="accordion-collapse collapse " id="collapse5" aria-labelledby="heading5"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="row">
                                    @if ($patient->fl_panorex)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_panorex) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_panorex) }}?v={{rand(0,1000)}}"
                                                        alt="Panorex" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Panorex</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_panorex)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_lateral_ceph)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lateral_ceph) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lateral_ceph) }}?v={{rand(0,1000)}}"
                                                        alt="Lateral Ceph" /></a>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">Lateral Ceph</h5>
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_lateral_ceph)}}">Edit Photo</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if ($patient->fl_general_upload)
                                    <div class="col-xl-4 mb-3">
                                        <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                            @if (pathinfo($patient->fl_general_upload, PATHINFO_EXTENSION) != 'pdf')
                                            <div class="card-img-top text-center"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload) }}"
                                                    data-gallery="gallery-1"><img style="width: 100%;" class="img-fluid"
                                                        src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload) }}?v={{rand(0,1000)}}"
                                                        alt="General Upload" /></a>
                                            </div>
                                            @else
                                            <p class="mb-0 ps-3"><a
                                                    href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload) }}"
                                                    download="">Download</a>
                                            </p>
                                            @endif
                                            <div class="card-body">
                                                @if(@$patient->fl_general_upload_drive_link)
                                                <p>Drive Link: <a href="{{@$patient->fl_general_upload_drive_link}}"
                                                        target="_blank">{{@$patient->fl_general_upload_drive_link}}</a>
                                                </p>
                                                @endif
                                                <h5 class="card-title">General Upload
                                                </h5>
                                                @if(pathinfo($patient->fl_general_upload, PATHINFO_EXTENSION) != 'pdf')
                                                {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$patient->fl_general_upload)}}">Edit Photo</a> --}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (@$patient->iframe_link && $patient->is_treatment_submitted == 1 && Auth::user()->role !=
                    'doctor')
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading8">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse8" aria-expanded="true" aria-controls="collapse8">Treatment
                                Plan</button>
                        </h2>
                        <div class="accordion-collapse collapse " id="collapse8" aria-labelledby="heading8"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <div class="card mb-3">
                                    <div class="card-body py-4">
                                        @if (@$patient->treatment_link)
                                        <div class="container-fluid mt-3">
                                            <p class="fw-bold">Please click the link below to view the
                                                treatment plan</p>
                                            <a href="{{ $patient->treatment_link }}"
                                                class="btn btn-link btn-sm ps-0 mt-2" target="_blank">Treatment Plan <i
                                                    class="fas fa-angle-right"></i></a>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 ">



        <div class="card mb-3">
            <div class="card-body p-0">

                <div class="accordion" id="accordionExample2">
                    @if (@$comments && $patient->is_submitted != 0)
                    @if (count($comments) > 0)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingl1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsel1" aria-expanded="true"
                                aria-controls="collapsel1">Comments</button>
                        </h2>
                        <div class="accordion-collapse collapse" id="collapsel1" aria-labelledby="headingl1"
                            data-bs-parent="#accordionExample2">
                            <div class="accordion-body">
                                <div class="container-fluid px-0 " id="case-overview-comments">
                                    @include('patients.overview_comments')
                                </div>
                                @if ($comments->lastPage() != $comments->currentPage())
                                <div class="d-flex my-2 justify-content-end">
                                    <a class="btn btn-link btn-sm px-0 fw-medium" href="javascript:void(0);"
                                        id="load-more-comments" data-last="{{ $comments->lastPage() }}"
                                        data-current="{{ $comments->currentPage() }}">Load More <i
                                            class="fas fa-angle-right"></i></a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    @endif
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingl13234">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapsel3" aria-expanded="true"
                                aria-controls="collapsel3">Prescription</button>
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
                                        @if (@$patient->midline)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ ucfirst($patient->midline) }} Midline
                                            </p>
                                            @if (@$patient->midline_notes)
                                            <p class="text-muted mb-0">{{ $patient->midline_notes }}</p>
                                            @endif

                                        </li>
                                        @endif
                                        @if (@$patient->archform)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ ucfirst($patient->archform) }}
                                                Archform</p>
                                            @if (@$patient->archform_notes)
                                            <p class="text-muted mb-0">{{ $patient->archform_notes }}</p>
                                            @endif

                                        </li>
                                        @endif
                                        @if (@$patient->class)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ ucfirst($patient->class) }} Class</p>
                                            @if (@$patient->class_notes)
                                            <p class="text-muted mb-0">{{ $patient->class_notes }}</p>
                                            @endif

                                        </li>
                                        @endif
                                    </ul>







                                    <h5 class="card-title mt-2">Resolutions</h5>
                                    <ul class="list-group list-group-flush">
                                        @if (@$patient->tooth_size_issues)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ $patient->tooth_size_issues }}</p>

                                        </li>
                                        @endif
                                        @if (@$patient->location_upper)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ $patient->location_upper }} Location
                                                Upper
                                            </p>

                                        </li>
                                        @endif
                                        @if (@$patient->location_lower)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0"><i class="fas fa-check"></i>
                                                {{ $patient->location_lower }} Location
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
                                        @if (@$patient->resolutions_notes)
                                        <li class="list-group-item">

                                            <p class="text-muted mb-0">{{ $patient->resolutions_notes }}</p>

                                        </li>
                                        @endif
                                    </ul>


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
                                    @if (count($pcp_ur) > 0 || count($pcp_ul) > 0 || count($pcp_lr) > 0 ||
                                    count($pcp_ll) > 0)
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
                                                            <div
                                                                class="card-body d-flex justify-content-between left-jaw px-0 px-md-2">

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="pcp_ur" id="pcp_ur8" @if (in_array(8,
                                                                    $pcp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="pcp_ur" id="pcp_ur7" @if (in_array(7,
                                                                    $pcp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="pcp_ur" id="pcp_ur6" @if (in_array(6,
                                                                    $pcp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="pcp_ur" id="pcp_ur5" @if (in_array(5,
                                                                    $pcp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="pcp_ur" id="pcp_ur4" @if (in_array(4,
                                                                    $pcp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="pcp_ur" id="pcp_ur3" @if (in_array(3,
                                                                    $pcp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="pcp_ur" id="pcp_ur2" @if (in_array(2,
                                                                    $pcp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="pcp_ur" id="pcp_ur1" @if (in_array(1,
                                                                    $pcp_ur)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="pcp_ul" id="pcp_ul1" @if (in_array(1,
                                                                    $pcp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="pcp_ul" id="pcp_ul2" @if (in_array(2,
                                                                    $pcp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="pcp_ul" id="pcp_ul3" @if (in_array(3,
                                                                    $pcp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="pcp_ul" id="pcp_ul4" @if (in_array(4,
                                                                    $pcp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="pcp_ul" id="pcp_ul5" @if (in_array(5,
                                                                    $pcp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="pcp_ul" id="pcp_ul6" @if (in_array(6,
                                                                    $pcp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="pcp_ul" id="pcp_ul7" @if (in_array(7,
                                                                    $pcp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="pcp_ul" id="pcp_ul8" @if (in_array(8,
                                                                    $pcp_ul)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="pcp_lr" id="pcp_lr8" @if (in_array(8,
                                                                    $pcp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="pcp_lr" id="pcp_lr7" @if (in_array(7,
                                                                    $pcp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="pcp_lr" id="pcp_lr6" @if (in_array(6,
                                                                    $pcp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="pcp_lr" id="pcp_lr5" @if (in_array(5,
                                                                    $pcp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="pcp_lr" id="pcp_lr4" @if (in_array(4,
                                                                    $pcp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="pcp_lr" id="pcp_lr3" @if (in_array(3,
                                                                    $pcp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="pcp_lr" id="pcp_lr2" @if (in_array(2,
                                                                    $pcp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="pcp_lr" id="pcp_lr1" @if (in_array(1,
                                                                    $pcp_lr)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="pcp_ll" id="pcp_ll1" @if (in_array(1,
                                                                    $pcp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="pcp_ll" id="pcp_ll2" @if (in_array(2,
                                                                    $pcp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="pcp_ll" id="pcp_ll3" @if (in_array(3,
                                                                    $pcp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="pcp_ll" id="pcp_ll4" @if (in_array(4,
                                                                    $pcp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="pcp_ll" id="pcp_ll5" @if (in_array(5,
                                                                    $pcp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="pcp_ll" id="pcp_ll6" @if (in_array(6,
                                                                    $pcp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="pcp_ll" id="pcp_ll7" @if (in_array(7,
                                                                    $pcp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="pcp_ll" id="pcp_ll8" @if (in_array(8,
                                                                    $pcp_ll)) checked @endif disabled>
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
                                    @if (count($ctp_ur) > 0 || count($ctp_ul) > 0 || count($ctp_lr) > 0 ||
                                    count($ctp_ll) > 0)
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="ctp_ur" id="ctp_ur8" @if (in_array(8,
                                                                    $ctp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="ctp_ur" id="ctp_ur7" @if (in_array(7,
                                                                    $ctp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="ctp_ur" id="ctp_ur6" @if (in_array(6,
                                                                    $ctp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="ctp_ur" id="ctp_ur5" @if (in_array(5,
                                                                    $ctp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="ctp_ur" id="ctp_ur4" @if (in_array(4,
                                                                    $ctp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="ctp_ur" id="ctp_ur3" @if (in_array(3,
                                                                    $ctp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="ctp_ur" id="ctp_ur2" @if (in_array(2,
                                                                    $ctp_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="ctp_ur" id="ctp_ur1" @if (in_array(1,
                                                                    $ctp_ur)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="ctp_ul" id="ctp_ul1" @if (in_array(1,
                                                                    $ctp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="ctp_ul" id="ctp_ul2" @if (in_array(2,
                                                                    $ctp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="ctp_ul" id="ctp_ul3" @if (in_array(3,
                                                                    $ctp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="ctp_ul" id="ctp_ul4" @if (in_array(4,
                                                                    $ctp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="ctp_ul" id="ctp_ul5" @if (in_array(5,
                                                                    $ctp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="ctp_ul" id="ctp_ul6" @if (in_array(6,
                                                                    $ctp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="ctp_ul" id="ctp_ul7" @if (in_array(7,
                                                                    $ctp_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="ctp_ul" id="ctp_ul8" @if (in_array(8,
                                                                    $ctp_ul)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="ctp_lr" id="ctp_lr8" @if (in_array(8,
                                                                    $ctp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="ctp_lr" id="ctp_lr7" @if (in_array(7,
                                                                    $ctp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="ctp_lr" id="ctp_lr6" @if (in_array(6,
                                                                    $ctp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="ctp_lr" id="ctp_lr5" @if (in_array(5,
                                                                    $ctp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="ctp_lr" id="ctp_lr4" @if (in_array(4,
                                                                    $ctp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="ctp_lr" id="ctp_lr3" @if (in_array(3,
                                                                    $ctp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="ctp_lr" id="ctp_lr2" @if (in_array(2,
                                                                    $ctp_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="ctp_lr" id="ctp_lr1" @if (in_array(1,
                                                                    $ctp_lr)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="ctp_ll" id="ctp_ll1" @if (in_array(1,
                                                                    $ctp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="ctp_ll" id="ctp_ll2" @if (in_array(2,
                                                                    $ctp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="ctp_ll" id="ctp_ll3" @if (in_array(3,
                                                                    $ctp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="ctp_ll" id="ctp_ll4" @if (in_array(4,
                                                                    $ctp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="ctp_ll" id="ctp_ll5" @if (in_array(5,
                                                                    $ctp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="ctp_ll" id="ctp_ll6" @if (in_array(6,
                                                                    $ctp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="ctp_ll" id="ctp_ll7" @if (in_array(7,
                                                                    $ctp_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="ctp_ll" id="ctp_ll8" @if (in_array(8,
                                                                    $ctp_ll)) checked @endif disabled>
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
                                    @if (count($tmr_ur) > 0 || count($tmr_ul) > 0 || count($tmr_lr) > 0 ||
                                    count($tmr_ll) > 0)
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tmr_ur" id="tmr_ur8" @if (in_array(8,
                                                                    $tmr_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tmr_ur" id="tmr_ur7" @if (in_array(7,
                                                                    $tmr_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tmr_ur" id="tmr_ur6" @if (in_array(6,
                                                                    $tmr_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tmr_ur" id="tmr_ur5" @if (in_array(5,
                                                                    $tmr_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tmr_ur" id="tmr_ur4" @if (in_array(4,
                                                                    $tmr_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tmr_ur" id="tmr_ur3" @if (in_array(3,
                                                                    $tmr_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tmr_ur" id="tmr_ur2" @if (in_array(2,
                                                                    $tmr_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tmr_ur" id="tmr_ur1" @if (in_array(1,
                                                                    $tmr_ur)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tmr_ul" id="tmr_ul1" @if (in_array(1,
                                                                    $tmr_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tmr_ul" id="tmr_ul2" @if (in_array(2,
                                                                    $tmr_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tmr_ul" id="tmr_ul3" @if (in_array(3,
                                                                    $tmr_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tmr_ul" id="tmr_ul4" @if (in_array(4,
                                                                    $tmr_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tmr_ul" id="tmr_ul5" @if (in_array(5,
                                                                    $tmr_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tmr_ul" id="tmr_ul6" @if (in_array(6,
                                                                    $tmr_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tmr_ul" id="tmr_ul7" @if (in_array(7,
                                                                    $tmr_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tmr_ul" id="tmr_ul8" @if (in_array(8,
                                                                    $tmr_ul)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tmr_lr" id="tmr_lr8" @if (in_array(8,
                                                                    $tmr_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tmr_lr" id="tmr_lr7" @if (in_array(7,
                                                                    $tmr_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tmr_lr" id="tmr_lr6" @if (in_array(6,
                                                                    $tmr_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tmr_lr" id="tmr_lr5" @if (in_array(5,
                                                                    $tmr_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tmr_lr" id="tmr_lr4" @if (in_array(4,
                                                                    $tmr_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tmr_lr" id="tmr_lr3" @if (in_array(3,
                                                                    $tmr_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tmr_lr" id="tmr_lr2" @if (in_array(2,
                                                                    $tmr_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tmr_lr" id="tmr_lr1" @if (in_array(1,
                                                                    $tmr_lr)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tmr_ll" id="tmr_ll1" @if (in_array(1,
                                                                    $tmr_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tmr_ll" id="tmr_ll2" @if (in_array(2,
                                                                    $tmr_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tmr_ll" id="tmr_ll3" @if (in_array(3,
                                                                    $tmr_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tmr_ll" id="tmr_ll4" @if (in_array(4,
                                                                    $tmr_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tmr_ll" id="tmr_ll5" @if (in_array(5,
                                                                    $tmr_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tmr_ll" id="tmr_ll6" @if (in_array(6,
                                                                    $tmr_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tmr_ll" id="tmr_ll7" @if (in_array(7,
                                                                    $tmr_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tmr_ll" id="tmr_ll8" @if (in_array(8,
                                                                    $tmr_ll)) checked @endif disabled>
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
                                    @if (count($mut_ur) > 0 || count($mut_ul) > 0 || count($mut_lr) > 0 ||
                                    count($mut_ll) > 0)
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="mut_ur" id="mut_ur8" @if (in_array(8,
                                                                    $mut_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="mut_ur" id="mut_ur7" @if (in_array(7,
                                                                    $mut_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="mut_ur" id="mut_ur6" @if (in_array(6,
                                                                    $mut_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="mut_ur" id="mut_ur5" @if (in_array(5,
                                                                    $mut_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="mut_ur" id="mut_ur4" @if (in_array(4,
                                                                    $mut_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="mut_ur" id="mut_ur3" @if (in_array(3,
                                                                    $mut_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="mut_ur" id="mut_ur2" @if (in_array(2,
                                                                    $mut_ur)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="mut_ur" id="mut_ur1" @if (in_array(1,
                                                                    $mut_ur)) checked @endif disabled>
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


                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="mut_ul" id="mut_ul1" @if (in_array(1,
                                                                    $mut_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="mut_ul" id="mut_ul2" @if (in_array(2,
                                                                    $mut_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="mut_ul" id="mut_ul3" @if (in_array(3,
                                                                    $mut_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="mut_ul" id="mut_ul4" @if (in_array(4,
                                                                    $mut_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="mut_ul" id="mut_ul5" @if (in_array(5,
                                                                    $mut_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="mut_ul" id="mut_ul6" @if (in_array(6,
                                                                    $mut_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="mut_ul" id="mut_ul7" @if (in_array(7,
                                                                    $mut_ul)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="mut_ul" id="mut_ul8" @if (in_array(8,
                                                                    $mut_ul)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="mut_lr" id="mut_lr8" @if (in_array(8,
                                                                    $mut_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="mut_lr" id="mut_lr7" @if (in_array(7,
                                                                    $mut_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="mut_lr" id="mut_lr6" @if (in_array(6,
                                                                    $mut_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="mut_lr" id="mut_lr5" @if (in_array(5,
                                                                    $mut_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="mut_lr" id="mut_lr4" @if (in_array(4,
                                                                    $mut_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="mut_lr" id="mut_lr3" @if (in_array(3,
                                                                    $mut_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="mut_lr" id="mut_lr2" @if (in_array(2,
                                                                    $mut_lr)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="mut_lr" id="mut_lr1" @if (in_array(1,
                                                                    $mut_lr)) checked @endif disabled>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="mut_ll" id="mut_ll1" @if (in_array(1,
                                                                    $mut_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="mut_ll" id="mut_ll2" @if (in_array(2,
                                                                    $mut_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="mut_ll" id="mut_ll3" @if (in_array(3,
                                                                    $mut_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="mut_ll" id="mut_ll4" @if (in_array(4,
                                                                    $mut_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="mut_ll" id="mut_ll5" @if (in_array(5,
                                                                    $mut_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="mut_ll" id="mut_ll6" @if (in_array(6,
                                                                    $mut_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="mut_ll" id="mut_ll7" @if (in_array(7,
                                                                    $mut_ll)) checked @endif disabled>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="mut_ll" id="mut_ll8" @if (in_array(8,
                                                                    $mut_ll)) checked @endif disabled>
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
                                    @if (count($tbe_ur) > 0 || count($tbe_ul) > 0 || count($tbe_lr) > 0 ||
                                    count($tbe_ll) > 0)
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tbe_ur" id="tbe_ur8" @if (in_array(8,
                                                                    $tbe_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tbe_ur" id="tbe_ur7" @if (in_array(7,
                                                                    $tbe_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tbe_ur" id="tbe_ur6" @if (in_array(6,
                                                                    $tbe_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tbe_ur" id="tbe_ur5" @if (in_array(5,
                                                                    $tbe_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tbe_ur" id="tbe_ur4" @if (in_array(4,
                                                                    $tbe_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tbe_ur" id="tbe_ur3" @if (in_array(3,
                                                                    $tbe_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tbe_ur" id="tbe_ur2" @if (in_array(2,
                                                                    $tbe_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tbe_ur" id="tbe_ur1" @if (in_array(1,
                                                                    $tbe_ur)) checked @endif>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tbe_ul" id="tbe_ul1" @if (in_array(1,
                                                                    $tbe_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tbe_ul" id="tbe_ul2" @if (in_array(2,
                                                                    $tbe_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tbe_ul" id="tbe_ul3" @if (in_array(3,
                                                                    $tbe_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tbe_ul" id="tbe_ul4" @if (in_array(4,
                                                                    $tbe_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tbe_ul" id="tbe_ul5" @if (in_array(5,
                                                                    $tbe_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tbe_ul" id="tbe_ul6" @if (in_array(6,
                                                                    $tbe_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tbe_ul" id="tbe_ul7" @if (in_array(7,
                                                                    $tbe_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tbe_ul" id="tbe_ul8" @if (in_array(8,
                                                                    $tbe_ul)) checked @endif>
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tbe_lr" id="tbe_lr8" @if (in_array(8,
                                                                    $tbe_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tbe_lr" id="tbe_lr7" @if (in_array(7,
                                                                    $tbe_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tbe_lr" id="tbe_lr6" @if (in_array(6,
                                                                    $tbe_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tbe_lr" id="tbe_lr5" @if (in_array(5,
                                                                    $tbe_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tbe_lr" id="tbe_lr4" @if (in_array(4,
                                                                    $tbe_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tbe_lr" id="tbe_lr3" @if (in_array(3,
                                                                    $tbe_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tbe_lr" id="tbe_lr2" @if (in_array(2,
                                                                    $tbe_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tbe_lr" id="tbe_lr1" @if (in_array(1,
                                                                    $tbe_lr)) checked @endif>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tbe_ll" id="tbe_ll1" @if (in_array(1,
                                                                    $tbe_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tbe_ll" id="tbe_ll2" @if (in_array(2,
                                                                    $tbe_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tbe_ll" id="tbe_ll3" @if (in_array(3,
                                                                    $tbe_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tbe_ll" id="tbe_ll4" @if (in_array(4,
                                                                    $tbe_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tbe_ll" id="tbe_ll5" @if (in_array(5,
                                                                    $tbe_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tbe_ll" id="tbe_ll6" @if (in_array(6,
                                                                    $tbe_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tbe_ll" id="tbe_ll7" @if (in_array(7,
                                                                    $tbe_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tbe_ll" id="tbe_ll8" @if (in_array(8,
                                                                    $tbe_ll)) checked @endif>
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
                                            <div class="card overflow-hidden" style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_posterior_bite_turbos, PATHINFO_EXTENSION) !=
                                                'pdf')
                                                <div class="card-img-top text-center"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_posterior_bite_turbos) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_posterior_bite_turbos) }}"
                                                            alt="General Upload" /></a>
                                                </div>
                                                @else
                                                <p class="mb-0 ps-3"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_posterior_bite_turbos) }}"
                                                        download="">Download</a>
                                                </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Posterior Bite Turbos
                                                        @if(pathinfo($patient->fl_posterior_bite_turbos,
                                                        PATHINFO_EXTENSION) != 'pdf')
                                                        <a class="float-end text-dark"
                                                            href="javascript:;"><i
                                                                class="fa fa-print text-dark"></i></a>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($patient->fl_anterior_bite_turbos)
                                        <div class="col-xl-6 mb-3">
                                            <div class="card overflow-hidden" style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_anterior_bite_turbos, PATHINFO_EXTENSION) !=
                                                'pdf')
                                                <div class="card-img-top text-center"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_anterior_bite_turbos) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_anterior_bite_turbos) }}"
                                                            alt="General Upload" /></a>
                                                </div>
                                                @else
                                                <p class="mb-0 ps-3"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_anterior_bite_turbos) }}"
                                                        download="">Download</a>
                                                </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Anterior Bite Turbos
                                                        @if(pathinfo($patient->fl_anterior_bite_turbos,
                                                        PATHINFO_EXTENSION) != 'pdf')
                                                        <a class="float-end text-dark"
                                                            href="javascript:;"><i
                                                                class="fa fa-print text-dark"></i></a>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($patient->fl_bite_keeper)
                                        <div class="col-xl-6 mb-3">
                                            <div class="card overflow-hidden" style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_bite_keeper, PATHINFO_EXTENSION) != 'pdf')
                                                <div class="card-img-top text-center"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_bite_keeper) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_bite_keeper) }}"
                                                            alt="General Upload" /></a>
                                                </div>
                                                @else
                                                <p class="mb-0 ps-3"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_bite_keeper) }}"
                                                        download="">Download</a>
                                                </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Bite Keeper
                                                        @if(pathinfo($patient->fl_bite_keeper, PATHINFO_EXTENSION) !=
                                                        'pdf')
                                                        <a class="float-end text-dark"
                                                            href="javascript:;"><i
                                                                class="fa fa-print text-dark"></i></a>
                                                        @endif
                                                    </h5>

                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if ($patient->fl_notes)
                                        <div class="col-xl-6 mb-3">
                                            <div class="card overflow-hidden" style="padding: .75rem !important;">
                                                @if (pathinfo($patient->fl_notes, PATHINFO_EXTENSION) != 'pdf')
                                                <div class="card-img-top text-center"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_notes) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_notes) }}"
                                                            alt="General Upload" /></a>
                                                </div>
                                                @else
                                                <p class="mb-0 ps-3"><a
                                                        href="{{ asset('/storage/PatientDemoFiles/Patient' . $patient->patient_id . '/' . $patient->fl_notes) }}"
                                                        download="">Download</a>
                                                </p>
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">Notes @if(pathinfo($patient->fl_notes,
                                                        PATHINFO_EXTENSION) != 'pdf')
                                                        <a class="float-end text-dark"
                                                            href="javascript:;"><i
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
                                        if ($patient->additional_attachments != '' && $patient->additional_attachments != null) {
                                            $additional_attachments = unserialize($patient->additional_attachments);
                                        }
                                        @endphp
                                        @if(in_array("Posterior Bite Turbos", $additional_attachments))
                                        <li class="list-group-item">

                                            <p class="text-muted"><i class="fas fa-check"></i> Posterior Bite Turbos</p>

                                        </li>
                                        @endif
                                        @if(in_array("Anterior Bite Turbos", $additional_attachments))
                                        <li class="list-group-item">

                                            <p class="text-muted"><i class="fas fa-check"></i> Anterior Bite Turbos</p>

                                        </li>
                                        @endif
                                        @if(in_array("Bite Keeper", $additional_attachments))
                                        <li class="list-group-item">

                                            <p class="text-muted"><i class="fas fa-check"></i> Bite Keeper</p>

                                        </li>
                                        @endif
                                        @if(@$patient->additional_attachments_notes != null && @$patient->additional_attachments_notes != "")
                                        <li class="list-group-item">

                                            <p class="text-muted">{{$patient->additional_attachments_notes}}</p>

                                        </li>
                                        @endif
                                    </ul>
                                    <ul class="list-group list-group-flush">
                                        @if (@$patient->keep_already_placed_attachments == 1)
                                        <li class="list-group-item">

                                            <p class="text-muted"><i class="fas fa-check"></i> Keep Already Placed
                                                Attachments</p>

                                        </li>
                                        @endif
                                        <li class="list-group-item">

                                            <p class="text-muted">Trim Upper:</strong> {{ @$patient->trim_type_upper }}
                                            </p>

                                        </li>
                                        <li class="list-group-item">

                                            <p class="text-muted">Trim Lower:</strong> {{ @$patient->trim_type_lower }}
                                            </p>

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
                                    @if (count($tla_ur) > 0 || count($tla_ul) > 0 || count($tla_lr) > 0 ||
                                    count($tla_ll) > 0)
                                    <h5 class=" my-3 mt-2 card-title">Last tooth to cover</h5>
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tla_ur" id="tla_ur8" @if (in_array(8,
                                                                    $tla_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tla_ur" id="tla_ur7" @if (in_array(7,
                                                                    $tla_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tla_ur" id="tla_ur6" @if (in_array(6,
                                                                    $tla_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tla_ur" id="tla_ur5" @if (in_array(5,
                                                                    $tla_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tla_ur" id="tla_ur4" @if (in_array(4,
                                                                    $tla_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tla_ur" id="tla_ur3" @if (in_array(3,
                                                                    $tla_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tla_ur" id="tla_ur2" @if (in_array(2,
                                                                    $tla_ur)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tla_ur" id="tla_ur1" @if (in_array(1,
                                                                    $tla_ur)) checked @endif>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tla_ul" id="tla_ul1" @if (in_array(1,
                                                                    $tla_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tla_ul" id="tla_ul2" @if (in_array(2,
                                                                    $tla_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tla_ul" id="tla_ul3" @if (in_array(3,
                                                                    $tla_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tla_ul" id="tla_ul4" @if (in_array(4,
                                                                    $tla_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tla_ul" id="tla_ul5" @if (in_array(5,
                                                                    $tla_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tla_ul" id="tla_ul6" @if (in_array(6,
                                                                    $tla_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tla_ul" id="tla_ul7" @if (in_array(7,
                                                                    $tla_ul)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tla_ul" id="tla_ul8" @if (in_array(8,
                                                                    $tla_ul)) checked @endif>
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

                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tla_lr" id="tla_lr8" @if (in_array(8,
                                                                    $tla_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tla_lr" id="tla_lr7" @if (in_array(7,
                                                                    $tla_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tla_lr" id="tla_lr6" @if (in_array(6,
                                                                    $tla_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tla_lr" id="tla_lr5" @if (in_array(5,
                                                                    $tla_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tla_lr" id="tla_lr4" @if (in_array(4,
                                                                    $tla_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tla_lr" id="tla_lr3" @if (in_array(3,
                                                                    $tla_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tla_lr" id="tla_lr2" @if (in_array(2,
                                                                    $tla_lr)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tla_lr" id="tla_lr1" @if (in_array(1,
                                                                    $tla_lr)) checked @endif>
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

                                                                <input type="checkbox" class="tooth" data-number="1"
                                                                    name="tla_ll" id="tla_ll1" @if (in_array(1,
                                                                    $tla_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="2"
                                                                    name="tla_ll" id="tla_ll2" @if (in_array(2,
                                                                    $tla_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="3"
                                                                    name="tla_ll" id="tla_ll3" @if (in_array(3,
                                                                    $tla_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="4"
                                                                    name="tla_ll" id="tla_ll4" @if (in_array(4,
                                                                    $tla_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="5"
                                                                    name="tla_ll" id="tla_ll5" @if (in_array(5,
                                                                    $tla_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="6"
                                                                    name="tla_ll" id="tla_ll6" @if (in_array(6,
                                                                    $tla_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="7"
                                                                    name="tla_ll" id="tla_ll7" @if (in_array(7,
                                                                    $tla_ll)) checked @endif>
                                                                <input type="checkbox" class="tooth" data-number="8"
                                                                    name="tla_ll" id="tla_ll8" @if (in_array(8,
                                                                    $tla_ll)) checked @endif>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>


        @if (
        $patient->is_submitted != 0 &&
        Auth::user()->role == $patient->case_holder &&
        (Auth::user()->role != 'lab' ||
        DB::table('lab_requests')->where('treatment_plan_id', @$patient->id)->where('user_id',
        Auth::user()->id)->where('is_canceled', 0)->exists()))
        @if ($patient->is_rejected == 1 || $patient->is_cancelled == 1)
        @if($patient->is_cancelled == 1)
        <div class="card">
            <div class="card-body py-4">
                <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                    <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">Treatment plan has been <strong>cancelled</strong>! The setup is not
                        confirmed within 30 days after setup confirmation request.</p>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body py-4">
                <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                    <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">Treatment plan has been <strong>rejected</strong> by staff!</p>
                </div>
            </div>
        </div>
        @endif
        @else
        <div class="card" id="panel">
            <div class="card-body py-4">
                <div class="mb-3">
                    <label>Comment</label>
                    <textarea class="form-control" name="comment" id="comment" placeholder="Add a comment"></textarea>
                </div>

                @if (Auth::user()->role == 'doctor')
                @if ($patient->is_treatment_submitted == 1)
                @php
                $calculation = new \App\Http\Services\PriceCalculation();
                $final_deposit = $calculation->calc(Auth::user()->tier, $patient);

                @endphp

                <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span>
                    </div>
                    <p class="mb-0 flex-1">You have to pay final amount of
                        <strong>€{{ number_format($final_deposit, 2) }}</strong>. Click "Approve" to
                        complete case.
                    </p>

                </div>
                <div class="mb-3 ps-2">
                    {{-- <div class="form-check">
                        <input class="form-check-input" id="terms1" type="checkbox" name="terms1" value="1" />
                        <label class="form-check-label" for="terms1">Dear doctor, kindly request a setup modification, if you apply any changes to the current setup. </label>
                      </div> --}}
                      <div class="form-check">
                        <input class="form-check-input" id="terms2" type="checkbox" name="terms2" value="1"/>
                        <label class="form-check-label" for="terms2">I did not change the current set up. Please click on (<b class="text-danger">Request Modification</b>), if you apply any modifications to the current setup.</label>
                      </div>
                </div>
                @endif
                <div class="btn-group">
                    @if ($patient->is_treatment_submitted == 1)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action"
                        id="approve">
                        <span class="fas fa-check-circle me-1" data-fa-transform="shrink-3"></span>
                        Approve
                </button>
                    {{-- @else
                    <button class="btn btn-falcon-danger rounded-pill me-1 mb-1 btn-action" type="button"
                        id="doctor-send-to-staff">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to Staff
                    </button> --}}
                    @endif
                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action" type="button"
                        id="doctor-send-to-staff">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Request Modification
                    </button>
                </div>
                @endif
                @if (Auth::user()->role == 'lab')
                @if($patient->is_completed == 0)
                <div class="mb-3">
                    <label>Files Link</label>
                    <input class="form-control hyperlink" placeholder="https://" value="{{ $patient->treatment_link }}"
                        name="treatment_link" id="treatment_link">
                </div>
                <div class="mb-3">
                    <label>Iframe Link</label>
                    <input class="form-control hyperlink" placeholder="https://" value="{{ $patient->iframe_link }}"
                        name="iframe_link" id="iframe_link">
                </div>
                <div class="btn-group">
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action" type="button"
                        id="submit-treatment">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Submit
                        Treatment
                    </button>
                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action" type="button"
                        id="lab-cancel-request">
                        Cancel Request<span class="fas fa-tint-slash" data-fa-transform="shrink-3"></span>
                    </button>
                </div>
                @else
                {{-- SEND SETUP FILES AFTER CASE IS CONFIRMED --}}
                <div class="mb-3">
                    <label>Files Link</label>
                    <input class="form-control hyperlink" placeholder="https://" value="{{ $patient->setup_files_link }}"
                        name="setup_files_link" id="setup_files_link">
                </div>
                <div class="btn-group">
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action" type="button"
                        id="submit-setup-files">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Submit
                        Files
                    </button>
                </div>
                @endif
                @endif
                @if (Auth::user()->role == 'staff')
                @if (count($labs) != 0 && $patient->is_sent_to_lab == 0 && $patient->is_treatment_submitted == 0)
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
                @if ($patient->is_sent_to_lab == 1 && $patient->is_treatment_submitted == 1 && $patient->is_completed == 0)
                <div class="mb-3">
                    <label>No. of Steps (Aligner)</label>
                    <input type="number" name="no_of_steps" id="no_of_steps" @if ($patient->aligner_steps != 0)
                    value="{{ $patient->aligner_steps }}" @endif
                    class="form-control" placeholder="No. of Steps">
                </div>
                @endif
                {{-- @if($patient->is_completed == 1 && @$patient->setup_files_link) --}}
                @if($patient->is_completed == 1)
                <div class="mb-3">
                    <label>Tracking Nr.</label>
                    <input type="text" name="tracking_id" id="tracking_id" value="{{@$patient->tracking_id}}" placeholder="https://" class="form-control hyper link">
                </div>
                @endif
                <div class="btn-group">
                    @if($patient->is_completed == 0)
                    @if ($patient->is_treatment_submitted == 1)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action" type="button"
                        id="staff-send-to-doctor-for-approval">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to
                        Doctor for Approval
                    </button>
                    @else
                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action" type="button"
                        id="staff-send-to-doctor">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to
                        Doctor for
                        Modification
                    </button>
                    @endif

                    @if ($patient->is_sent_to_lab == 0 && $patient->is_treatment_submitted == 0)

                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action" type="button"
                        id="request-treatment">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send to
                        Lab
                    </button>
                    <button class="btn btn-danger rounded-pill me-1 mb-1 btn-action" type="button"
                        id="staff-reject-treatment">
                        <span class="fas fa-tint-slash me-1" data-fa-transform="shrink-3"></span>Reject Treatment
                    </button>
                    @else
                    @if ($patient->is_treatment_submitted == 1)
                    <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action" type="button"
                        id="send-to-lab-for-modification">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Send
                        to {{ @$patient->lab_first_name . ' ' . @$patient->lab_last_name }} for modification
                    </button>
                    @else
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action" type="button"
                        id="staff-send-to-lab">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>{{-- Send
                        to Lab --}} Request Files
                    </button>
                    @endif
                    @endif
                    @else
                    {{-- After Case In Production | SEND TO LAB TO REQUEST SETUP FILES --}}
                    @if(!@$patient->setup_files_link)
                    <button class="btn btn-success rounded-pill me-1 mb-1 btn-action" type="button"
                    id="request-setup-files">
                    <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span>Request Files
                </button>
                <button class="btn btn-warning rounded-pill me-1 mb-1 btn-action" type="button"
                        id="staff-submit-tracking-id">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span> Submit Tracking Nr.
                    </button>
                @else
                {{--AFTER SETUP FILES SENT BY LAB--}}
<button class="btn btn-success rounded-pill me-1 mb-1 btn-action" type="button"
                        id="staff-submit-tracking-id">
                        <span class="fas fa-share me-1" data-fa-transform="shrink-3"></span> Submit
                    </button>
                @endif
                    @endif
                    {{-- <button class="btn btn-falcon-danger rounded-pill me-1 mb-1 btn-action" type="button"
                        id="staff-cancel-treatment">
                        Cancel Treatment<span class="fas fa-tint-slash" data-fa-transform="shrink-3"></span>
                    </button> --}}
                </div>
                @endif
            </div>
        </div>
        @endif
        @endif
    </div>
</div>


</div>







{{-- <div class="modal fade" id="dataProcessingTemplate" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg mt-6" role="document">
      <div class="modal-content border-0">
        <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
          <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
            <div class="bg-light rounded-top-lg py-3 ps-4 pe-6">
                <h4 class="mb-1" id="staticBackdropLabel">Data Processing Agreement</h4>
                <p class="fs--2 mb-0"><a class="link-600 fw-semi-bold" href="#!"></a></p>
              </div>
           <div class="d-flex w-100 justify-content-center">
            <object data="{{asset('public/media/Data processing Al-Secret.pdf')}}" type="application/pdf" style="width: 100%;" height="750"> <p>It appears you don't have a PDF plugin for this browser. No biggie... you can <a href="{{asset('pblic/media/Data processing Al-Secret.pdf')}}">click here to download the PDF file.</a></p> </object>
           </div>
        </div>
      </div>
    </div>
  </div> --}}





<div class="current-view" style="display:none;"></div>
<div class="row mb-5"><br style="clear:both;" /></div>
<div id="current-module" style="display:none;"></div>
@stop


@section('javascript')
<script src="{{ asset('public') }}/dashboard/vendors/glightbox/glightbox.min.js"></script>
<script src="{{ asset('public') }}/dashboard/vendors/prism/prism.js"></script>

<script>
    var link_regex =
            /^(?:(?:https?|ftp):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[/?#]\S*)?$/
        $(document).ready(function() {

            $(document).on('click', '.update-package', function () {

                const current = $(this).attr('data-current');
                let message = "";
                if(current == 'AL-SECRET-CONFIDENCE') {
                    message = "Do you really want to change pricing package from "+current+" to "+" AL-SECRET-SELECT ?";
                } else {
                    message = "Do you really want to change pricing package from "+current+" to "+" AL-SECRET-CONFIDENCE ?";
                }
                const c = confirm(message);
                if(c) {
                    $.ajax({
                        type: "POST",
                        url: "{{url('/patient/case-overview/chane-pricing-package')}}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                        "treatment_plan_id": "{{ $patient->id }}", //treatment plan id
                        }
                    }).done(function (response) {
                        if(response.status == 200) {
                            window.location.reload();
                        } else {
                            toastError("Enable to change pricing package.");
                        }
                    }).fail(function (response) {
                        toastError("Enable to change pricing package.");
                    });
                }
            });
            $("#block-edit").on('click', function() {
                var $this = $(this);
                var data = $this.attr('data');
                var html = ``;
                if (data == '1') {
                    html = `<span class="fas fas fa-edit me-2"></span>Allow Edit`;
                } else {
                    html = `<span class="fas fas fa-edit me-2"></span>Disable Edit`;
                }
                $.ajax({
                    type: "POST",
                    url: "{{ url('/patient/case/allow-user-to-edit') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "treatment_plan_id": "{{ $patient->id }}", //treatment plan id
                    }
                }).done(function(response) {
                    $this.html(html);
                    $this.attr('data', data == '1' ? '0' : '1');
                    if (data == '1') {
                        toastSuccess("Case Edit Disabled");
                    } else {
                        toastSuccess("Case Edit Allowed")
                    }
                }).fail(function(response) {
                    toastError("Enable to proceed with request.");
                })
            });
            $(document).on('click', '#load-more-comments', function() {
                var $this = $(this);
                var page = $this.attr('data-current');
                var last = parseInt($this.attr('data-last'));
                var nextPage = (parseInt(page) + 1);
                $.ajax({
                    type: "GET",
                    url: "{{ url('/patient/case-overview/load-comments/' . $patient->id) }}?page=" +
                        nextPage,
                }).done(function(response) {
                    $("#case-overview-comments").append(response);
                    $this.attr('data-current', nextPage);
                    if (nextPage >= last) {
                        $this.remove();
                    }
                }).fail(function(response) {
                    toastError("Enable to load more comments.");
                });
            });
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

            $(document).on("input", "input[name='no_of_steps']", function() {
                var inputVal = $(this).val();
                inputVal = inputVal.replace(/[^0-9]/g, ''); // Remove non-numeric characters
                if (inputVal ==
                    '') { // If input is empty or 0, set value to an empty string || inputVal == '0'
                    inputVal = '';
                }
                $(this).val(inputVal); // Set input value
            });

            // $("input[name=terms2]").on('change', function () {
            //     if($(this).is(':checked')) {
            //         $("#dataProcessingTemplate").modal('show');
            //     }
            // })


        });
</script>
{{-- @if ($patient->fl_upper_arch && $patient->fl_lower_arch && $patient->is_treatment_submitted == 0)
<script type="module">
    import { STLLoader } from "{{asset('public/assets/three/examples/jsm/loaders/STLLoader.js')}}";
            import { OrbitControls } from '{{asset("public/assets/three/examples/jsm/controls/OrbitControls.js")}}';

 //initial setup (scene, camera, renderer, material, controls, etc)
 const container = document.getElementById( 'canvas' );
            const scene = new THREE.Scene();
            scene.name = 'myscene';
            scene.background = new THREE.Color( 0xf2f2f2 );
            const camera = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
            const renderer = new THREE.WebGLRenderer();
            const material = new THREE.MeshNormalMaterial();
            const controls = new OrbitControls(camera, renderer.domElement, { enableRotate: true });

            var filesLoaded = 0;
            var element = document.getElementById("progress-wrapper");
			var loadingBar = document.getElementById("loading-bar");
			const buttons = document.querySelectorAll('.step-control');
			// const labels = document.querySelectorAll('.step-trigger');

			var totalFiles = 2;
			var percentage = (100/totalFiles);
			var currentProgress = 0;

            THREE.Cache.enabled = true;

            //modify renderer
            renderer.setSize( window.innerWidth, window.innerHeight );

            //append renderer to body
            document.body.appendChild( renderer.domElement );

            //prepare STL Loader
            const loader = new STLLoader()

            //load upper arch STL file
            loader.load('<?php echo $upper_arch_stl; ?>',
            function (geometry) {
                const mesh = new THREE.Mesh(geometry, material)
                mesh.name = 'maxillary';
                mesh.tag = 'base';
                scene.add(mesh);
                filesLoaded++;
                currentProgress += percentage;
                loadingBar.style.width = currentProgress+'%';
                loadingBar.textContent = Math.floor(currentProgress)+'%';
                // console.log('scene updated');
                // Output the axis of the model
            },
            (xhr) => {
                // console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
            },
            (error) => {
                console.log(error)
            })
            loader.load('<?php echo $lower_arch_stl; ?>',
            function (geometry) {
                const mesh = new THREE.Mesh(geometry, material)
                mesh.name = 'mandibular';
                mesh.tag = 'base'
                scene.add(mesh);
                filesLoaded++;
                currentProgress += percentage;
                loadingBar.style.width = currentProgress+'%' + ' modules loaded';
                loadingBar.textContent = Math.floor(currentProgress)+'%';

                // console.log('scene updated');
                // console.log(scene);
            },
            (xhr) => {
                // console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
            },
            (error) => {
                console.log(error)
            });
            camera.position.z = 10;
            camera.position.x = 0;
            camera.position.y = -6;
            scene.scale.set(0.02,0.02,0.02);
            controls.update();
            const divs = document.querySelectorAll('.model-control');
			divs.forEach(el => el.addEventListener('click', event => {
			  console.log(event.target.getAttribute("id"));
			  const objectid = event.target.getAttribute("id");
			  const visible = event.target.getAttribute("data-visible");
			  const camera_z = event.target.getAttribute("data-cameraz");
			  const camera_x = event.target.getAttribute("data-camerax");
              jQuery('.current-view').text(camera_z+','+camera_x+','+objectid);
			  scene.traverse(function(object){
				        console.log(object);
				        if (object.visible === true && object.type === "Mesh"){
				        	document.getElementById('current-module').textContent = object.tag;
				        }
				        if (visible === '1'){
				        	if (object.tag === document.getElementById('current-module').textContent && object.type === "Mesh"){
					        	object.visible = true;
					        	camera.position.z = camera_z;
					            camera.position.x = camera_x;
					            camera.position.y = 0;
					        }
					        if (object.tag === document.getElementById('current-module').textContent && object.type === "Mesh" && object.visible == false){
					        	// alert(object.tag+' hidden');
					        	object.visible = true;
					        	camera.position.z = camera_z;
					            camera.position.x = camera_x;
					            camera.position.y = 0;
					        }
				        }
				        else{
				        	if (objectid != object.name && object.type == 'Mesh' && object.tag == document.getElementById('current-module').textContent){
				        		object.visible = false;
				        		console.log(object);
				        	}
				        	if (objectid == object.name && object.type == 'Mesh' && object.tag == document.getElementById('current-module').textContent){
				        		object.visible = true;
				        		camera.position.z = 0;
				        	    camera.position.x = 0;
				        	    camera.position.y = camera_x;
				        	    console.log(object);
				        	}
				        }
				    });
			}));
            var i = 0;
            var m = 0;
			// function loadModels() {
                for (let i = 0; i < buttons.length; i++) {
                    // setTimeout(function(){


                    loader.load(buttons[i].getAttribute("data-maxillary"),
                        function (geometry) {
                            const mesh = new THREE.Mesh(geometry, material)
                            mesh.name = 'maxillary';
                            mesh.visible = false;
                            mesh.tag = buttons[i].getAttribute("id");
                            scene.add(mesh);
                            filesLoaded++;
                            currentProgress += percentage;
                            loadingBar.style.width = currentProgress+'%';
                            loadingBar.textContent = Math.floor(currentProgress)+'%' + ' modules loaded';
                            console.log('scene updated');
                            console.log(scene);
                            if (currentProgress > 95){
                                jQuery('#progress-wrapper').remove();
                            }
                        },
                        (xhr) => {
                            console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
                        },
                        (error) => {
                            console.log(error)
                        }, (success) => {

                        });
                    loader.load(buttons[i].getAttribute("data-mandibular"),
                        function (geometry) {
                            const mesh = new THREE.Mesh(geometry, material)
                            mesh.name = 'mandibular';
                            mesh.visible = false;
                            mesh.tag = buttons[i].getAttribute("id");
                            scene.add(mesh);
                            filesLoaded++;
                            currentProgress += percentage;
                            loadingBar.style.width = currentProgress+'%';
                            loadingBar.textContent = Math.floor(currentProgress)+'%' + ' modules loaded';
                            console.log('scene updated');
                            console.log(scene);
                            if (currentProgress > 95){
                                jQuery('#progress-wrapper').remove();
                            }
                        },
                        (xhr) => {
                            console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
                        },
                        (error) => {
                            console.log(error)
                        }, (success) => {

                        });
                    // },i * 50);
                }



// jQuery('#slider').on('hover',function(){
// event.preventDefault();
// });

// document.getElementById('slider').addEventListener('mousedown', onDocumentMouseMove);
// document.getElementById('slider').addEventListener('mouseup', onDocumentMouseMove);
// document.getElementById('slider').addEventListener('mousemove', onDocumentMouseMove);


// document.getElementById('slider').addEventListener('mousedown', onDocumentMouseMove);
document.getElementById('slider').addEventListener('mousedown', function(event) {
    document.getElementById('slider').addEventListener('mousemove', onDocumentMouseMove);
    document.getElementById('slider').addEventListener('mouseout', function(event) {
        document.getElementById('slider').removeEventListener('mousemove', onDocumentMouseMove);
    });
});
document.addEventListener('mouseup', function(event) {
    document.getElementById('slider').removeEventListener('mousemove', onDocumentMouseMove);
});

var quaternion = new THREE.Quaternion();
function onDocumentMouseMove( event ) {
    quaternion.setFromAxisAngle( new THREE.Vector3( 1, 0, 0 ), event.clientX * Math.PI / 360 );
    scene.children.forEach(function(mesh) {
        mesh.rotation.setFromQuaternion(quaternion);
    });
}



			buttons.forEach(el => el.addEventListener('click', event => {
			  var camera_z = event.target.getAttribute("data-cameraz");
			  var camera_x = event.target.getAttribute("data-camerax");
			  var objectid = event.target.getAttribute("id");
			  camera.position.z = camera_z;
              camera.position.x = camera_x;
               objectid = event.target.getAttribute("id");
              // alert(camera.position.x);
              // alert(camera.position.z);
              if (jQuery('.current-view').text().length > 0){
                // camera.position.y = -6;
                var info = jQuery('.current-view').text().split(',');
                if (info[0] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                    camera.position.z = info[0];
                }
                else{
                    camera.position.z = 0;
                }
                if (info[1] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                   camera.position.x = info[1];
                }
                else{
                    // camera.position.x = 0;
                }
                if (info[2] === 'maxillary'){
                  var objectname = 'maxillary';
                }
                else if (info[2] === 'mandibular'){
                  var objectname = 'mandibular';
                }


              }
              else{
                camera.position.y = 0;
              }


	              scene.traverse(function(object){
                        if (object.visible === true && object.type === "Mesh"){
                            document.getElementById('current-module').textContent = objectid;
                        }
						if (object.type == 'Mesh' && object.tag == objectid){
							object.visible = true;
						}
						if (object.type == 'Mesh' && object.tag !== objectid){
							object.visible = false;
						}
                        if (objectname){
                            if (objectname === 'maxillary' && object.name === 'mandibular'){
                                object.visible = false;
                            }
                            if (objectname === 'mandibular' && object.name === 'maxillary'){
                                object.visible = false;
                            }

                            if (objectname === 'mandibular' && object.name === 'mandibular' && object.tag == document.getElementById('current-module').textContent){
                                object.visible = true;
                            }
                            if (objectname === 'maxillary' && object.name === 'maxillary' && object.tag == document.getElementById('current-module').textContent){
                                object.visible = true;
                            }
                        }
						console.log(object.tag);
				  });
              }));
              document.getElementById('play-button').addEventListener('click', event => {
                console.log(buttons)
			  		var i = 0;
	            	buttons.forEach((button) => {
						setTimeout(function(){

                                 // jQuery('label.step-trigger:nth-child('+i+')').addClass('active');
	        					 const camera_z = button.getAttribute("data-cameraz");
								  const camera_x = button.getAttribute("data-camerax");
								  const objectid = button.getAttribute("id");
								  console.log(camera_z+','+camera_x+','+objectid);
								  camera.position.z = camera_z;
					              camera.position.x = camera_x;
                                  if (jQuery('.current-view').text().length > 0){
                                    // camera.position.y = -6;
                                    var info = jQuery('.current-view').text().split(',');
                                    if (info[0] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                                        camera.position.z = info[0];
                                    }
                                    else{
                                        camera.position.z = 0;
                                    }
                                    if (info[1] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular'){
                                       camera.position.x = info[1];
                                    }
                                    else{
                                        // camera.position.x = 0;
                                    }
                                    if (info[2] === 'maxillary'){
                                      var objectname = 'maxillary';
                                    }
                                    else if (info[2] === 'mandibular'){
                                      var objectname = 'mandibular';
                                    }


                                  }
                                  else{
                                    camera.position.y = 0;
                                  }
					              scene.traverse(function(object){
										if (object.visible === true && object.type === "Mesh"){
                                            document.getElementById('current-module').textContent = objectid;
                                        }
                                        if (object.type == 'Mesh' && object.tag == objectid){
                                            object.visible = true;
                                        }
                                        if (object.type == 'Mesh' && object.tag !== objectid){
                                            object.visible = false;
                                        }
                                        if (objectname){
                                            if (objectname === 'maxillary' && object.name === 'mandibular'){
                                                object.visible = false;
                                            }
                                            if (objectname === 'mandibular' && object.name === 'maxillary'){
                                                object.visible = false;
                                            }

                                            if (objectname === 'mandibular' && object.name === 'mandibular' && object.tag == document.getElementById('current-module').textContent){
                                                object.visible = true;
                                            }
                                            if (objectname === 'maxillary' && object.name === 'maxillary' && object.tag == document.getElementById('current-module').textContent){
                                                object.visible = true;
                                            }
                                        }
								  });
                                  // jQuery('label.step-trigger:nth-child('+i+')').removeClass('active');
								  if (i === buttons.length){
								  	i = 0;
								  }
	        			},500 * i);
	        			i++;
					});

	            });

            function animate() {
                requestAnimationFrame( animate );
                container.appendChild( renderer.domElement );
                controls.update();
                renderer.render( scene, camera );

            };
            export const ZoomBar = () => {
                  return ('<div className="zoom-wrapper"><div className="zoom-bar"><div className="button" id="zoom-out">-</div><div className="button" id="zoom-in">+</div></div></div>');
                };
            animate();
            jQuery(document).ready(function(){
            	jQuery('#customRange2').on('input',function(){
            		var currentStep = parseInt(jQuery(this).val())+1
            		jQuery('.step-trigger[for="step-'+currentStep+'"]').click();
            	});
            	// jQuery('.x-rays-box > div').on('click',function(){
        		// 	jQuery('.image-open.col-lg-12').not(this).removeClass('image-open').removeClass('col-lg-12').addClass('col-lg-6');
        		// 	jQuery(this).toggleClass('col-lg-6 col-lg-12 image-open');

            	// });
                $('.review-photos img').on('click', function() {
                    $('#ModalImage').attr('src', $(this).attr('src'));
                });

            });
            var somethingChanged = false;
            jQuery(document).ready(function() {
               $('.acf-form input').change(function() {
                    somethingChanged = true;
               });
            });
            jQuery('form:not(#acf-form)').on('submit',function(event){
                if (somethingChanged){
                    if (confirm("You have unsaved notes. Do you want to proceed?")) {
                       //nothin
                    } else {
                       // do something else
                       jQuery('html, body').animate({
                            scrollTop: jQuery("#notes").offset().top
                        }, 2000);
                       jQuery('#submit_data').css('background-color','red');
                       return false;
                    }
                }
            });
</script>
@endif --}}
@stop
