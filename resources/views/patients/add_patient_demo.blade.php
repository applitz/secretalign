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
        background: rgba(59, 77, 88, 0.975);
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
  </style>
@stop

@section('content')
<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        {{-- <li class="breadcrumb-item"><a href="{{url('/patients/view')}}">Patients</a></li> --}}
                        <li class="breadcrumb-item active">Create New Demo Patient</li>
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
if ($patient->fl_front && $patient->fl_smile && $patient->fl_profile && $patient->fl_frontal &&
$patient->fl_right_buccal && $patient->fl_left_buccal && $patient->fl_upper_occlusal && $patient->fl_lower_occlusal &&
$patient->fl_panorex && $patient->fl_lateral_ceph) {
$fn3 = 1;
}
if (($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1) {
$fn4 = 1;
}
@endphp


<div class="row gx-0" id="patient-wizard">
    <div class="col-12 ">
        <div class="card">

            <div class="card-body">
                <h4 class="card-title">Add Your Patient Information</h4>
                <p class="card-title-desc">You must complete all steps</p>

                <ul class="nav nav-pills gap-3" id="pill-myTab" role="tablist">
                    <li class="nav-item flex-grow-1"><a class="nav-link text-900 active " id="pill-tab-li1" data-bs-toggle="tab"
                            href="#pill-tab-div1" role="tab" aria-controls="pill-tab-div1" aria-selected="true">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">1</span>
                            Patient
                            Info</a></li>
                    <li class="nav-item flex-grow-1"><a class="nav-link text-900" id="pill-tab-li2" data-bs-toggle="tab"
                            href="#pill-tab-div2" role="tab" aria-controls="pill-tab-div2" aria-selected="true">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">2</span>
                            Scan
                            Data</a></li>
                    <li class="nav-item flex-grow-1"><a class="nav-link text-900" id="pill-tab-li3" data-bs-toggle="tab"
                            href="#pill-tab-div3" role="tab" aria-controls="pill-tab-div3" aria-selected="true">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">3</span>
                            Images /
                            X-Rays</a></li>
                    <li class="nav-item flex-grow-1"><a class="nav-link text-900" id="pill-tab-li4" data-bs-toggle="tab"
                            href="#pill-tab-div4" role="tab" aria-controls="pill-tab-div4"
                            aria-selected="true">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">4</span>
                            Prescription</a></li>
                    <li class="nav-item flex-grow-1"><a class="nav-link text-900" id="pill-tab-li5" data-bs-toggle="tab"
                            href="#pill-tab-div5" role="tab" aria-controls="pill-tab-div5" aria-selected="true">
                            <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">5</span>
                            Case Overview</a></li>
                            <li class="nav-item flex-grow-1"><a class="nav-link text-900" id="pill-tab-li6" data-bs-toggle="tab"
                                href="#pill-tab-div6" role="tab" aria-controls="pill-tab-div6" aria-selected="true">
                                <span class="rounded-circle border border-white me-2" style="padding: 4px 8px;">6</span>
                                Confirm
                                & Submit</a></li>
                </ul>
                <div class="tab-content p-3 mt-3" id="pill-myTabContent">
                    <div class="tab-pane fade show active" id="pill-tab-div1" role="tabpanel"
                        aria-labelledby="pill-tab-li1">
                        <div class="mb-3">
                            <label class="form-label" for="first_name">First Name</label>
                            <input class="form-control " id="first_name" type="text" placeholder="First Name"
                                name="first_name" value="{{ @$patient->first_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="last_name">Last Name</label>
                            <input class="form-control " id="last_name" type="text" placeholder="Last Name"
                                name="last_name" value="{{ @$patient->last_name }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="dob">Date of Birth</label>
                            <input class="form-control pickr" id="dob" name="dob" value="{{ @$patient->dob }}"
                                type="text" placeholder="d/m/y"
                                data-options='{"dateFormat":"d/m/y","disableMobile":true}' />
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-patient-info" @if (@$patient->first_name
                                && @$patient->last_name && @$patient->dob) fn="1"
                                @else
                                fn="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pill-tab-div2" role="tabpanel" aria-labelledby="pill-tab-li2">
                        <div class="alert alert-warning border-2 d-flex align-items-center" role="alert">
                            <div class="bg-warning me-3 icon-item"><span
                                    class="fas fa-exclamation-circle text-white fs-3"></span></div>
                            <p class="mb-0 flex-1">You must upload the scan data!</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="1">
                                <input class="d-none" name="file1" id="key1" file="{{ @$patient->fl_upper_arch }}" data-field="1" type="file">
                                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="upper-jaw-box" key="1" style="background-image: url('{{asset('public/assets/vector/upper-jaw.png')}}')">
                                    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text></span>
                                        <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                                        <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Uploading...</span>
                                        <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Delete file</span>
                                        <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                                    </div>
                                </div>
                                <label class="form-label mb-3" for="fl_upper_arch">Upper Arch</label>
                                <div class="mb-3 mx-1" id="stl-upper-arch-preview">

                                </div>
                            </div>


                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="2">
                                <input class="d-none" name="file2" id="key2" file="{{ @$patient->fl_lower_arch }}" data-field="2" type="file">
                                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" id="lower-jaw-box" key="2" style="background-image: url('{{asset('public/assets/vector/down-jaw.png')}}')">
                                    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text></span>
                                        <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                                        <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Uploading...</span>
                                        <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Delete file</span>
                                        <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                                    </div>
                                </div>
                                <label class="form-label mb-3" for="fl_lower_arch">Lower Arch</label>
                                    <div class="mb-3 mx-1" id="stl-lower-arch-preview">

                                    </div>
                            </div>
                        </div>




                        <div class="mb-3 text-end">
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li1">Previous</button>
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-scan-data" @if (@$patient->fl_upper_arch
                                && @$patient->fl_lower_arch) fn="1"
                                @else
                                fn="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pill-tab-div3" role="tabpanel" aria-labelledby="pill-tab-li3">
                        <div class="row mb-3">
                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="3">
                                <input class="d-none" name="file3" id="key3" file="{{ @$patient->fl_front }}" data-field="3" type="file">
                                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="3" style="background-image: url('{{asset('public/assets/vector/head-sad.png')}}')">
                                    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text></span>
                                        <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                                        <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Uploading...</span>
                                        <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Delete file</span>
                                        <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                                    </div>

                                </div>
                                <label class="form-label mb-3" for="filepond">Front</label>
                            </div>
                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="4">
                                <input class="d-none" name="file4" id="key4" file="{{ @$patient->fl_smile }}" data-field="4" type="file">
                                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="4" style="background-image: url('{{asset('public/assets/vector/head-front.png')}}')">
                                    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text></span>
                                        <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                                        <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Uploading...</span>
                                        <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                                    </div>
                                    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                                        <span class="text-white fw-semibold" data-text>Delete file</span>
                                        <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                                    </div>
                                </div>
                                <label class="form-label mb-3" for="filepond">Smile</label>
                            </div>

                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="5">

                                <input class="d-none" name="file5" id="key5" file="{{ @$patient->fl_profile }}" data-field="5" type="file">
                                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="5" style="background-image: url('{{asset('public/assets/vector/head-side.jpg')}}')
                                ">
                                <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                                    <span class="text-white fw-semibold" data-text></span>
                                    <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                                </div>
                                <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                                    <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                                    <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                                </div>
                                <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                                    <span class="text-white fw-semibold" data-text>Uploading...</span>
                                    <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                                </div>
                                <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                                    <span class="text-white fw-semibold" data-text>Delete file</span>
                                    <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                                </div>
                            </div>
                            <label class="form-label mb-1" for="filepond">Profile</label>
                        </div>

                        <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="6">

                            <input class="d-none" name="file6" id="key6" file="{{ @$patient->fl_frontal }}" data-field="6"
                            type="file">
                            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="6" style="background-image: url('{{asset('public/assets/vector/jaw.png')}}')
                            ">
                            <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                                <span class="text-white fw-semibold" data-text></span>
                                <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                            </div>
                            <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                                <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                                <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                            </div>
                            <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                                <span class="text-white fw-semibold" data-text>Uploading...</span>
                                <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                            </div>
                            <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                                <span class="text-white fw-semibold" data-text>Delete file</span>
                                <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                            </div>
                        </div>
                        <label class="form-label mb-3" for="filepond">Frontal (Intraoral)</label>
                    </div>

                    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="7">

                        <input class="d-none" name="file7" id="key7" file="{{ @$patient->fl_right_buccal }}" data-field="7"
                        type="file">
                        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="7" style="background-image: url('{{asset('public/assets/vector/jaw-side-left-angle.png')}}')
                        ">
                        <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                            <span class="text-white fw-semibold" data-text></span>
                            <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                        </div>
                        <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                            <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                            <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                        </div>
                        <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                            <span class="text-white fw-semibold" data-text>Uploading...</span>
                            <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                        </div>
                        <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                            <span class="text-white fw-semibold" data-text>Delete file</span>
                            <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                        </div>
                    </div>
                    <label class="form-label mb-3" for="filepond">Right Buccal</label>
                </div>

                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="8">

                    <input class="d-none" name="file8" id="key8" file="{{ @$patient->fl_left_buccal }}" data-field="8"
                    type="file">
                    <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="8" style="background-image: url('{{asset('public/assets/vector/jaw-side-right-angle.png')}}')
                    ">
                    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text></span>
                        <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                    </div>
                    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                        <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                    </div>
                    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Uploading...</span>
                        <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                    </div>
                    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                        <span class="text-white fw-semibold" data-text>Delete file</span>
                        <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                    </div>
                </div>
                <label class="form-label mb-3" for="filepond">Left Buccal</label>
            </div>


            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="9">

                <input class="d-none" name="file9" id="key9" file="{{ @$patient->fl_upper_occlusal }}" data-field="9"
                type="file">
                <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="9" style="background-image: url('{{asset('public/assets/vector/upper-jaw.png')}}')
                ">
                <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text></span>
                    <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                    <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Uploading...</span>
                    <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
                </div>
                <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                    <span class="text-white fw-semibold" data-text>Delete file</span>
                    <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
                </div>
            </div>
            <label class="form-label mb-3" for="filepond">Upper Occlusal</label>
        </div>


        <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="10">

            <input class="d-none" name="file10" id="key10" file="{{ @$patient->fl_lower_occlusal }}" data-field="10"
            type="file">
            <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="10" style="background-image: url('{{asset('public/assets/vector/down-jaw.png')}}')
            ">
            <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
                <span class="text-white fw-semibold" data-text></span>
                <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
            </div>
            <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
                <span class="text-white fw-semibold" data-text>Drag & drop file</span>
                <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
            </div>
            <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
                <span class="text-white fw-semibold" data-text>Uploading...</span>
                <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
            </div>
            <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
                <span class="text-white fw-semibold" data-text>Delete file</span>
                <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
            </div>
        </div>
        <label class="form-label mb-3" for="filepond">Lower Occlusal</label>
    </div>


    <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="11">

        <input class="d-none" name="file11" id="key11" file="{{ @$patient->fl_panorex }}" data-field="11"
        type="file">
        <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="11" style="background-image: url('{{asset('public/assets/vector/x-ray-jaw-front.png')}}')
        ">
        <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text></span>
            <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
        </div>
        <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text>Drag & drop file</span>
            <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
        </div>
        <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text>Uploading...</span>
            <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
        </div>
        <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
            <span class="text-white fw-semibold" data-text>Delete file</span>
            <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
        </div>
    </div>
    <label class="form-label mb-3" for="filepond">Panorex</label>
</div>

<div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="12">

    <input class="d-none" name="file12" id="key12" file="{{ @$patient->fl_lateral_ceph }}" data-field="12"
    type="file">
    <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="12" style="background-image: url('{{asset('public/assets/vector/x-ray-jaw-side.png')}}')
    ">
    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text></span>
        <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
    </div>
    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
        <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
    </div>
    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text>Uploading...</span>
        <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
    </div>
    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text>Delete file</span>
        <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
    </div>
</div>
<label class="form-label mb-3" for="filepond">Lateral Ceph</label>
</div>


<div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12 _dropzone_template" template-key="13">

    <input class="d-none" name="file13" id="key13" file="{{ @$patient->fl_general_upload }}" data-field="13"
    type="file">
    <div class="p-2 border border-primary border-2 d-block mb-1 _dropzone" key="13" style="background-image: url('{{asset('public/assets/no-image.png')}}')
    ">
    <div class="_dropzone_added _dropzone_added_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text></span>
        <img src="{{asset('public/assets')}}/check-mark.png" style="width: 50px;height: 50px;">
    </div>
    <div class="_dropzone_hover _dropzone_hover_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text>Drag & drop file</span>
        <img src="{{asset('public/assets')}}/download-circular-button.png" style="width: 50px;height: 50px;">
    </div>
    <div class="_dropzone_loading _dropzone_loading_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text>Uploading...</span>
        <img src="{{asset('public/assets')}}/circle-loading.png" class="_dropzone_loading_animation" style="width: 50px;height: 50px;">
    </div>
    <div class="_dropzone_remove _dropzone_remove_hidden d-flex flex-column align-items-center justify-content-center">
        <span class="text-white fw-semibold" data-text>Delete file</span>
        <img src="{{asset('public/assets')}}/x-mark.png" style="width: 50px; height: 50px;">
    </div>
</div>
<label class="form-label mb-3" for="filepond">General Upload</label>
</div>

                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                <label class="form-label" for="general_upload_hyperlink">General Upload (Drive
                                    Link)</label>
                                <input class="form-control hyperlink" placeholder="https://"
                                    value="{{ @$patient->fl_general_upload_drive_link }}"
                                    name="general_upload_hyperlink" id="general_upload_hyperlink">
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li2">Previous</button>
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-images" @if ( @$patient->fl_front &&
                                @$patient->fl_smile &&
                                @$patient->fl_profile &&
                                @$patient->fl_frontal &&
                                @$patient->fl_right_buccal &&
                                @$patient->fl_left_buccal &&
                                @$patient->fl_upper_occlusal &&
                                @$patient->fl_lower_occlusal &&
                                @$patient->fl_panorex &&
                                @$patient->fl_lateral_ceph) fn="1"
                                @else
                                fn="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pill-tab-div4" role="tabpanel" aria-labelledby="pill-tab-li4">
                        <h3>Your preferred treatment instructions.</h3>
                        <div class="mb-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="treat_upper_arch" name="upper_arch" type="checkbox"
                                    value="1" @if ($patient->treat_upper_arch == 1) checked @endif />
                                <label class="form-check-label" for="treat_upper_arch">Treat Upper Arch</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" id="treat_lower_arch" name="lower_arch" type="checkbox"
                                    value="1" @if ($patient->treat_lower_arch == 1) checked @endif />
                                <label class="form-check-label" for="treat_lower_arch">Treat Lower Arch</label>
                            </div>

                        </div>
                        <div class="accordion border-x border-top rounded mb-3" id="accordionFaq">
                            <div class="card shadow-none border-bottom rounded-bottom-0 mb-0">
                                <div class="card-header p-0" id="faqAccordionHeading1">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion1"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion1"><span
                                            class="fas fa-caret-right accordion-icon me-3"
                                            data-fa-transform="shrink-2"></span><span
                                            class="fw-medium font-sans-serif text-900">Midline</span></button>
                                </div>
                                <div class="collapse bg-light" id="collapseFaqAccordion1"
                                    aria-labelledby="faqAccordionHeading1" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="midline1" type="checkbox"
                                                    name="midline" value="maintain" @if ($patient->midline ==
                                                'maintain') checked @endif />
                                                <label class="form-check-label" for="midline1">Maintain</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="midline2" type="checkbox"
                                                    name="midline" value="Move Upper to Lower" @if ($patient->midline == 'Move Upper to Lower')
                                                checked @endif />
                                                <label class="form-check-label" for="midline2">Move Upper to Lower</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="midline3" type="checkbox"
                                                    name="midline" value="Move Lower to Upper" @if ($patient->midline == 'Move Lower to Upper')
                                                checked @endif />
                                                <label class="form-check-label" for="midline3">Move Lower to Upper</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="midline4" type="checkbox"
                                                    name="midline" value="Independent (move both)" @if ($patient->midline == 'Independent (move both)')
                                                checked @endif />
                                                <label class="form-check-label" for="midline4">Independent (move both)*</label> <span class="mb-0 text-danger" >*Please describe in Notes</span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3 d-none">
                                            <div class="form-check form-check-inline mb-2">
                                                <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline1" value="Maintain" {{$patient->align_to_facial_midline == 'Maintain' ? 'checked' : ''}} {{$patient->align_to_facial_midline == "" || $patient->align_to_facial_midline == null ? 'checked' : ''}}>
                                                <label class="form-check-label" for="align_to_facial_midline1">
                                                    Maintain
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline mb-2">
                                                <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline2" value="Move Upper to Lower" {{$patient->align_to_facial_midline == 'Move Upper to Lower' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="align_to_facial_midline2">
                                                    Move Upper to Lower
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline mb-2">
                                                <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline3" value="Move Lower to Upper" {{$patient->align_to_facial_midline == 'Move Lower to Upper' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="align_to_facial_midline3">
                                                    Move Lower to Upper
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline mb-2">
                                                <input class="form-check-input" type="radio" name="align_to_facial_midline" id="align_to_facial_midline4" value="Independent (move both)" {{$patient->align_to_facial_midline == 'Independent (move both)' ? 'checked' : ''}}>
                                                <label class="form-check-label" for="align_to_facial_midline4">
                                                    Independent (move both)*
                                                    <span class="mb-0 text-danger" >*Please describe in Notes</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea class="form-control" id="midline_notes"
                                                name="midline_notes">{{ $patient->midline_notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom rounded-0 mb-0">
                                <div class="card-header p-0" id="faqAccordionHeading2">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion2"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion2"><span
                                            class="fas fa-caret-right accordion-icon me-3"
                                            data-fa-transform="shrink-2"></span><span
                                            class="fw-medium font-sans-serif text-900">Archform</span></button>
                                </div>
                                <div class="collapse bg-light" id="collapseFaqAccordion2"
                                    aria-labelledby="faqAccordionHeading2" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="archform1" type="checkbox"
                                                    name="archform" value="maintain" @if ($patient->archform ==
                                                'maintain') checked @endif />
                                                <label class="form-check-label" for="archform1">Maintain</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="archform2" type="checkbox"
                                                    name="archform" value="correct" @if ($patient->archform ==
                                                'correct') checked @endif />
                                                <label class="form-check-label" for="archform2">Correct</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea class="form-control" id="archform_notes"
                                                name="archform_notes">{{ $patient->archform_notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom rounded-0 mb-0">
                                <div class="card-header p-0" id="faqAccordionHeading3">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion3"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion3"><span
                                            class="fas fa-caret-right accordion-icon me-3"
                                            data-fa-transform="shrink-2"></span><span
                                            class="fw-medium font-sans-serif text-900">Class</span></button>
                                </div>
                                <div class="collapse bg-light" id="collapseFaqAccordion3"
                                    aria-labelledby="faqAccordionHeading3" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="class1" type="checkbox" name="class"
                                                    value="maintain" @if ($patient->class == 'maintain') checked @endif
                                                />
                                                <label class="form-check-label" for="class1">Maintain</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="class2" type="checkbox" name="class"
                                                    value="correct" @if ($patient->class == 'correct') checked @endif />
                                                <label class="form-check-label" for="class2">Correct</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5 class="text-center mb-3">Precision Cuts Placement</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    U
                                                                </div>
                                                                <div class="direction-label left">
                                                                    R
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $pcp_ur = [];
                                                                    if ($patient->pcp_ur != '' && $patient->pcp_ur !=
                                                                    null) {
                                                                    $pcp_ur = unserialize($patient->pcp_ur);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="pcp_ur" id="pcp_ur8" @if (in_array(8,
                                                                        $pcp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="pcp_ur" id="pcp_ur7" @if (in_array(7,
                                                                        $pcp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="pcp_ur" id="pcp_ur6" @if (in_array(6,
                                                                        $pcp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="pcp_ur" id="pcp_ur5" @if (in_array(5,
                                                                        $pcp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="pcp_ur" id="pcp_ur4" @if (in_array(4,
                                                                        $pcp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="pcp_ur" id="pcp_ur3" @if (in_array(3,
                                                                        $pcp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="pcp_ur" id="pcp_ur2" @if (in_array(2,
                                                                        $pcp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="pcp_ur" id="pcp_ur1" @if (in_array(1,
                                                                        $pcp_ur)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $pcp_ul = [];
                                                                    if ($patient->pcp_ul != '' && $patient->pcp_ul !=
                                                                    null) {
                                                                    $pcp_ul = unserialize($patient->pcp_ul);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="pcp_ul" id="pcp_ul1" @if (in_array(1,
                                                                        $pcp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="pcp_ul" id="pcp_ul2" @if (in_array(2,
                                                                        $pcp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="pcp_ul" id="pcp_ul3" @if (in_array(3,
                                                                        $pcp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="pcp_ul" id="pcp_ul4" @if (in_array(4,
                                                                        $pcp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="pcp_ul" id="pcp_ul5" @if (in_array(5,
                                                                        $pcp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="pcp_ul" id="pcp_ul6" @if (in_array(6,
                                                                        $pcp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="pcp_ul" id="pcp_ul7" @if (in_array(7,
                                                                        $pcp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="pcp_ul" id="pcp_ul8" @if (in_array(8,
                                                                        $pcp_ul)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    U
                                                                </div>
                                                                <div class="direction-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    L
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $pcp_lr = [];
                                                                    if ($patient->pcp_lr != '' && $patient->pcp_lr !=
                                                                    null) {
                                                                    $pcp_lr = unserialize($patient->pcp_lr);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="pcp_lr" id="pcp_lr8" @if (in_array(8,
                                                                        $pcp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="pcp_lr" id="pcp_lr7" @if (in_array(7,
                                                                        $pcp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="pcp_lr" id="pcp_lr6" @if (in_array(6,
                                                                        $pcp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="pcp_lr" id="pcp_lr5" @if (in_array(5,
                                                                        $pcp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="pcp_lr" id="pcp_lr4" @if (in_array(4,
                                                                        $pcp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="pcp_lr" id="pcp_lr3" @if (in_array(3,
                                                                        $pcp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="pcp_lr" id="pcp_lr2" @if (in_array(2,
                                                                        $pcp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="pcp_lr" id="pcp_lr1" @if (in_array(1,
                                                                        $pcp_lr)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $pcp_ll = [];
                                                                    if ($patient->pcp_ll != '' && $patient->pcp_ll !=
                                                                    null) {
                                                                    $pcp_ll = unserialize($patient->pcp_ll);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="pcp_ll" id="pcp_ll1" @if (in_array(1,
                                                                        $pcp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="pcp_ll" id="pcp_ll2" @if (in_array(2,
                                                                        $pcp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="pcp_ll" id="pcp_ll3" @if (in_array(3,
                                                                        $pcp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="pcp_ll" id="pcp_ll4" @if (in_array(4,
                                                                        $pcp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="pcp_ll" id="pcp_ll5" @if (in_array(5,
                                                                        $pcp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="pcp_ll" id="pcp_ll6" @if (in_array(6,
                                                                        $pcp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="pcp_ll" id="pcp_ll7" @if (in_array(7,
                                                                        $pcp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="pcp_ll" id="pcp_ll8" @if (in_array(8,
                                                                        $pcp_ll)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    L
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="text-center my-3">Cutouts Placement</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    U
                                                                </div>
                                                                <div class="direction-label left">
                                                                    R
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $ctp_ur = [];
                                                                    if ($patient->ctp_ur != '' && $patient->ctp_ur !=
                                                                    null) {
                                                                    $ctp_ur = unserialize($patient->ctp_ur);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="ctp_ur" id="ctp_ur8" @if (in_array(8,
                                                                        $ctp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="ctp_ur" id="ctp_ur7" @if (in_array(7,
                                                                        $ctp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="ctp_ur" id="ctp_ur6" @if (in_array(6,
                                                                        $ctp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="ctp_ur" id="ctp_ur5" @if (in_array(5,
                                                                        $ctp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="ctp_ur" id="ctp_ur4" @if (in_array(4,
                                                                        $ctp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="ctp_ur" id="ctp_ur3" @if (in_array(3,
                                                                        $ctp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="ctp_ur" id="ctp_ur2" @if (in_array(2,
                                                                        $ctp_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="ctp_ur" id="ctp_ur1" @if (in_array(1,
                                                                        $ctp_ur)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $ctp_ul = [];
                                                                    if ($patient->ctp_ul != '' && $patient->ctp_ul !=
                                                                    null) {
                                                                    $ctp_ul = unserialize($patient->ctp_ul);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="ctp_ul" id="ctp_ul1" @if (in_array(1,
                                                                        $ctp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="ctp_ul" id="ctp_ul2" @if (in_array(2,
                                                                        $ctp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="ctp_ul" id="ctp_ul3" @if (in_array(3,
                                                                        $ctp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="ctp_ul" id="ctp_ul4" @if (in_array(4,
                                                                        $ctp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="ctp_ul" id="ctp_ul5" @if (in_array(5,
                                                                        $ctp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="ctp_ul" id="ctp_ul6" @if (in_array(6,
                                                                        $ctp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="ctp_ul" id="ctp_ul7" @if (in_array(7,
                                                                        $ctp_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="ctp_ul" id="ctp_ul8" @if (in_array(8,
                                                                        $ctp_ul)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    U
                                                                </div>
                                                                <div class="direction-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    L
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $ctp_lr = [];
                                                                    if ($patient->ctp_lr != '' && $patient->ctp_lr !=
                                                                    null) {
                                                                    $ctp_lr = unserialize($patient->ctp_lr);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="ctp_lr" id="ctp_lr8" @if (in_array(8,
                                                                        $ctp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="ctp_lr" id="ctp_lr7" @if (in_array(7,
                                                                        $ctp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="ctp_lr" id="ctp_lr6" @if (in_array(6,
                                                                        $ctp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="ctp_lr" id="ctp_lr5" @if (in_array(5,
                                                                        $ctp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="ctp_lr" id="ctp_lr4" @if (in_array(4,
                                                                        $ctp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="ctp_lr" id="ctp_lr3" @if (in_array(3,
                                                                        $ctp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="ctp_lr" id="ctp_lr2" @if (in_array(2,
                                                                        $ctp_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="ctp_lr" id="ctp_lr1" @if (in_array(1,
                                                                        $ctp_lr)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $ctp_ll = [];
                                                                    if ($patient->ctp_ll != '' && $patient->ctp_ll !=
                                                                    null) {
                                                                    $ctp_ll = unserialize($patient->ctp_ll);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="ctp_ll" id="ctp_ll1" @if (in_array(1,
                                                                        $ctp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="ctp_ll" id="ctp_ll2" @if (in_array(2,
                                                                        $ctp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="ctp_ll" id="ctp_ll3" @if (in_array(3,
                                                                        $ctp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="ctp_ll" id="ctp_ll4" @if (in_array(4,
                                                                        $ctp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="ctp_ll" id="ctp_ll5" @if (in_array(5,
                                                                        $ctp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="ctp_ll" id="ctp_ll6" @if (in_array(6,
                                                                        $ctp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="ctp_ll" id="ctp_ll7" @if (in_array(7,
                                                                        $ctp_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="ctp_ll" id="ctp_ll8" @if (in_array(8,
                                                                        $ctp_ll)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    L
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea class="form-control" id="class_notes"
                                                name="class_notes">{{ $patient->class_notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom mb-0">
                                <div class="card-header p-0" id="faqAccordionHeading4">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion4"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion4"><span
                                            class="fas fa-caret-right accordion-icon me-3"
                                            data-fa-transform="shrink-2"></span><span
                                            class="fw-medium font-sans-serif text-900">Resolutions</span></button>
                                </div>
                                <div class="collapse bg-light" id="collapseFaqAccordion4"
                                    aria-labelledby="faqAccordionHeading4" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        <h5>Resolve Tooth Size Issues</h5>
                                        <div class="mb-3">
                                            <label>Please select one of the following options.</label>
                                            <div class="form-check">
                                                <input class="form-check-input" id="size_issues1" type="radio"
                                                    name="size_issues" value="IPR" @if ($patient->tooth_size_issues ==
                                                'IPR') checked @endif />
                                                <label class="form-check-label" for="size_issues1">IPR</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="size_issues2" type="radio"
                                                    name="size_issues" value="Restorative (No IPR)"
                                                    @if($patient->tooth_size_issues == 'Restorative (No IPR)')
                                                checked=""
                                                @endif />
                                                <label class="form-check-label" for="size_issues2">Restorative (No
                                                    IPR)</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" id="size_issues3" type="radio"
                                                    name="size_issues" value="Accept best fit (No IPR/Restorative)"
                                                    @if($patient->tooth_size_issues == 'Accept best fit (No
                                                IPR/Restorative)') checked @endif />
                                                <label class="form-check-label" for="size_issues3">Accept best fit (No
                                                    IPR/Restorative)</label>
                                            </div>
                                        </div>
                                        <hr>
                                     <div id="presc-location-section" class="{{ $patient->tooth_size_issues == 'IPR' ? '' : 'd-none'}}">
                                        <h5>Location</h5>
                                        <div class="mb-3">
                                            <label>Upper</label>
                                            <select id="location_upper" name="location_upper" class="form-select">
                                                <option value="" selected disabled>Select</option>
                                                <option value="3-3" @if ($patient->location_upper == '3-3') selected
                                                    @endif>3-3</option>
                                                <option value="4-4" @if ($patient->location_upper == '4-4') selected
                                                    @endif>4-4</option>
                                                <option value="6-6" @if ($patient->location_upper == '6-6') selected
                                                    @endif>6-6</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Lower</label>
                                            <select id="location_lower" name="location_lower" class="form-select">
                                                <option value="" selected disabled>Select</option>
                                                <option value="3-3" @if ($patient->location_lower == '3-3') selected
                                                    @endif>3-3</option>
                                                <option value="4-4" @if ($patient->location_lower == '4-4') selected
                                                    @endif>4-4</option>
                                                <option value="6-6" @if ($patient->location_lower == '6-6') selected
                                                    @endif>6-6</option>
                                            </select>
                                        </div>
                                        <hr>
                                     </div>
                                        <div id="pres-limits-section"  class="{{ $patient->tooth_size_issues == 'IPR' ? '' : 'd-none'}}">
                                            <h5>Limits</h5>
                                            <div class="mb-3">
                                                <label>Maximum Ant. IPR/Contact 0.1-0.6mm</label>
                                                <input class="form-control" type="number" name="limits"
                                                    value="{{ $patient->limits }}" id="limits" step="0.05" min="0.1"
                                                    max="0.6">
                                            </div>
                                            <hr>
                                        </div>
                                        <h5 class="text-center mb-3">Tooth Movement Restrictions</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    U
                                                                </div>
                                                                <div class="direction-label left">
                                                                    R
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $tmr_ur = [];
                                                                    if ($patient->tmr_ur != '' && $patient->tmr_ur !=
                                                                    null) {
                                                                    $tmr_ur = unserialize($patient->tmr_ur);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="tmr_ur" id="tmr_ur8" @if (in_array(8,
                                                                        $tmr_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="tmr_ur" id="tmr_ur7" @if (in_array(7,
                                                                        $tmr_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="tmr_ur" id="tmr_ur6" @if (in_array(6,
                                                                        $tmr_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="tmr_ur" id="tmr_ur5" @if (in_array(5,
                                                                        $tmr_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="tmr_ur" id="tmr_ur4" @if (in_array(4,
                                                                        $tmr_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="tmr_ur" id="tmr_ur3" @if (in_array(3,
                                                                        $tmr_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="tmr_ur" id="tmr_ur2" @if (in_array(2,
                                                                        $tmr_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="tmr_ur" id="tmr_ur1" @if (in_array(1,
                                                                        $tmr_ur)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $tmr_ul = [];
                                                                    if ($patient->tmr_ul != '' && $patient->tmr_ul !=
                                                                    null) {
                                                                    $tmr_ul = unserialize($patient->tmr_ul);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="tmr_ul" id="tmr_ul1" @if (in_array(1,
                                                                        $tmr_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="tmr_ul" id="tmr_ul2" @if (in_array(2,
                                                                        $tmr_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="tmr_ul" id="tmr_ul3" @if (in_array(3,
                                                                        $tmr_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="tmr_ul" id="tmr_ul4" @if (in_array(4,
                                                                        $tmr_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="tmr_ul" id="tmr_ul5" @if (in_array(5,
                                                                        $tmr_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="tmr_ul" id="tmr_ul6" @if (in_array(6,
                                                                        $tmr_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="tmr_ul" id="tmr_ul7" @if (in_array(7,
                                                                        $tmr_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="tmr_ul" id="tmr_ul8" @if (in_array(8,
                                                                        $tmr_ul)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    U
                                                                </div>
                                                                <div class="direction-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    L
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $tmr_lr = [];
                                                                    if ($patient->tmr_lr != '' && $patient->tmr_lr !=
                                                                    null) {
                                                                    $tmr_lr = unserialize($patient->tmr_lr);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="tmr_lr" id="tmr_lr8" @if (in_array(8,
                                                                        $tmr_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="tmr_lr" id="tmr_lr7" @if (in_array(7,
                                                                        $tmr_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="tmr_lr" id="tmr_lr6" @if (in_array(6,
                                                                        $tmr_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="tmr_lr" id="tmr_lr5" @if (in_array(5,
                                                                        $tmr_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="tmr_lr" id="tmr_lr4" @if (in_array(4,
                                                                        $tmr_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="tmr_lr" id="tmr_lr3" @if (in_array(3,
                                                                        $tmr_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="tmr_lr" id="tmr_lr2" @if (in_array(2,
                                                                        $tmr_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="tmr_lr" id="tmr_lr1" @if (in_array(1,
                                                                        $tmr_lr)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 bottom right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $tmr_ll = [];
                                                                    if ($patient->tmr_ll != '' && $patient->tmr_ll !=
                                                                    null) {
                                                                    $tmr_ll = unserialize($patient->tmr_ll);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="tmr_ll" id="tmr_ll1" @if (in_array(1,
                                                                        $tmr_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="tmr_ll" id="tmr_ll2" @if (in_array(2,
                                                                        $tmr_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="tmr_ll" id="tmr_ll3" @if (in_array(3,
                                                                        $tmr_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="tmr_ll" id="tmr_ll4" @if (in_array(4,
                                                                        $tmr_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="tmr_ll" id="tmr_ll5" @if (in_array(5,
                                                                        $tmr_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="tmr_ll" id="tmr_ll6" @if (in_array(6,
                                                                        $tmr_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="tmr_ll" id="tmr_ll7" @if (in_array(7,
                                                                        $tmr_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="tmr_ll" id="tmr_ll8" @if (in_array(8,
                                                                        $tmr_ll)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    L
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="text-center my-3">Missing or Unerupted teeth</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    U
                                                                </div>
                                                                <div class="direction-label left">
                                                                    R
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $mut_ur = [];
                                                                    if ($patient->mut_ur != '' && $patient->mut_ur !=
                                                                    null) {
                                                                    $mut_ur = unserialize($patient->mut_ur);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="mut_ur" id="mut_ur8" @if (in_array(8,
                                                                        $mut_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="mut_ur" id="mut_ur7" @if (in_array(7,
                                                                        $mut_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="mut_ur" id="mut_ur6" @if (in_array(6,
                                                                        $mut_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="mut_ur" id="mut_ur5" @if (in_array(5,
                                                                        $mut_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="mut_ur" id="mut_ur4" @if (in_array(4,
                                                                        $mut_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="mut_ur" id="mut_ur3" @if (in_array(3,
                                                                        $mut_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="mut_ur" id="mut_ur2" @if (in_array(2,
                                                                        $mut_ur)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="mut_ur" id="mut_ur1" @if (in_array(1,
                                                                        $mut_ur)) checked @endif>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 top right tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $mut_ul = [];
                                                                    if ($patient->mut_ul != '' && $patient->mut_ul !=
                                                                    null) {
                                                                    $mut_ul = unserialize($patient->mut_ul);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="mut_ul" id="mut_ul1" @if (in_array(1,
                                                                        $mut_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="mut_ul" id="mut_ul2" @if (in_array(2,
                                                                        $mut_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="mut_ul" id="mut_ul3" @if (in_array(3,
                                                                        $mut_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="mut_ul" id="mut_ul4" @if (in_array(4,
                                                                        $mut_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="mut_ul" id="mut_ul5" @if (in_array(5,
                                                                        $mut_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="mut_ul" id="mut_ul6" @if (in_array(6,
                                                                        $mut_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="mut_ul" id="mut_ul7" @if (in_array(7,
                                                                        $mut_ul)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="mut_ul" id="mut_ul8" @if (in_array(8,
                                                                        $mut_ul)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    U
                                                                </div>
                                                                <div class="direction-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $mut_lr = [];
                                                                    if ($patient->mut_lr != '' && $patient->mut_lr !=
                                                                    null) {
                                                                    $mut_lr = unserialize($patient->mut_lr);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="mut_lr" id="mut_lr8" @if (in_array(8,
                                                                        $mut_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="mut_lr" id="mut_lr7" @if (in_array(7,
                                                                        $mut_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="mut_lr" id="mut_lr6" @if (in_array(6,
                                                                        $mut_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="mut_lr" id="mut_lr5" @if (in_array(5,
                                                                        $mut_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="mut_lr" id="mut_lr4" @if (in_array(4,
                                                                        $mut_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="mut_lr" id="mut_lr3" @if (in_array(3,
                                                                        $mut_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="mut_lr" id="mut_lr2" @if (in_array(2,
                                                                        $mut_lr)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="mut_lr" id="mut_lr1" @if (in_array(1,
                                                                        $mut_lr)) checked @endif>
                                                                </div>
                                                                <div class="side-label left">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 tw bottom right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $mut_ll = [];
                                                                    if ($patient->mut_ll != '' && $patient->mut_ll !=
                                                                    null) {
                                                                    $mut_ll = unserialize($patient->mut_ll);
                                                                    }
                                                                    @endphp
                                                                    <input type="checkbox" class="tooth" data-number="1"
                                                                        name="mut_ll" id="mut_ll1" @if (in_array(1,
                                                                        $mut_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="2"
                                                                        name="mut_ll" id="mut_ll2" @if (in_array(2,
                                                                        $mut_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="3"
                                                                        name="mut_ll" id="mut_ll3" @if (in_array(3,
                                                                        $mut_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="4"
                                                                        name="mut_ll" id="mut_ll4" @if (in_array(4,
                                                                        $mut_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="5"
                                                                        name="mut_ll" id="mut_ll5" @if (in_array(5,
                                                                        $mut_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="6"
                                                                        name="mut_ll" id="mut_ll6" @if (in_array(6,
                                                                        $mut_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="7"
                                                                        name="mut_ll" id="mut_ll7" @if (in_array(7,
                                                                        $mut_ll)) checked @endif>
                                                                    <input type="checkbox" class="tooth" data-number="8"
                                                                        name="mut_ll" id="mut_ll8" @if (in_array(8,
                                                                        $mut_ll)) checked @endif>
                                                                </div>
                                                                <div class="side-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <h5 class="text-center my-3">To be Extracted</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    U
                                                                </div>
                                                                <div class="direction-label left">
                                                                    R
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $tbe_ur = [];
                                                                    if ($patient->tbe_ur != '' && $patient->tbe_ur !=
                                                                    null) {
                                                                    $tbe_ur = unserialize($patient->tbe_ur);
                                                                    }
                                                                    @endphp
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
                                                    <div class="col-xs-6 col-sm-6 tw top right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $tbe_ul = [];
                                                                    if ($patient->tbe_ul != '' && $patient->tbe_ul !=
                                                                    null) {
                                                                    $tbe_ul = unserialize($patient->tbe_ul);
                                                                    }
                                                                    @endphp
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
                                                                <div class="side-label right">
                                                                    U
                                                                </div>
                                                                <div class="direction-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $tbe_lr = [];
                                                                    if ($patient->tbe_lr != '' && $patient->tbe_lr !=
                                                                    null) {
                                                                    $tbe_lr = unserialize($patient->tbe_lr);
                                                                    }
                                                                    @endphp
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
                                                                <div class="side-label left">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 tw bottom right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $tbe_ll = [];
                                                                    if ($patient->tbe_ll != '' && $patient->tbe_ll !=
                                                                    null) {
                                                                    $tbe_ll = unserialize($patient->tbe_ll);
                                                                    }
                                                                    @endphp
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
                                                                <div class="side-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea name="resolution_notes" id="resolution_notes"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom mb-0">
                                <div class="card-header p-0" id="faqAccordionHeading5">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion5"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion5"><span
                                            class="fas fa-caret-right accordion-icon me-3"
                                            data-fa-transform="shrink-2"></span><span
                                            class="fw-medium font-sans-serif text-900">Occlusal
                                            Plane</span></button>
                                </div>
                                <div class="collapse bg-light" id="collapseFaqAccordion5"
                                    aria-labelledby="faqAccordionHeading5" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="occlusal_plan1" type="checkbox"
                                                    name="occlusal_plan" value="maintain" @if ($patient->occlusal_plane
                                                == 'maintain') checked @endif />
                                                <label class="form-check-label" for="occlusal_plan1">Maintain</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="occlusal_plan2" type="checkbox"
                                                    name="occlusal_plan" value="correct" @if ($patient->occlusal_plane
                                                == 'correct') checked @endif />
                                                <label class="form-check-label" for="occlusal_plan2">Correct</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea class="form-control" name="occlusal_plane_notes"
                                                id="occlusal_plane_notes"
                                                placeholder="Leveling as needed">{{ $patient->occlusal_plane_notes }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card shadow-none border-bottom mb-0">
                                <div class="card-header p-0" id="faqAccordionHeading6">
                                    <button
                                        class="accordion-button btn btn-link text-decoration-none d-block w-100 py-2 px-3 collapsed border-0 text-start"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFaqAccordion6"
                                        aria-expanded="false" aria-controls="collapseFaqAccordion6"><span
                                            class="fas fa-caret-right accordion-icon me-3"
                                            data-fa-transform="shrink-2"></span><span
                                            class="fw-medium font-sans-serif text-900">Special
                                            Instructions</span></button>
                                </div>
                                <div class="collapse bg-light" id="collapseFaqAccordion6"
                                    aria-labelledby="faqAccordionHeading6" data-parent="#accordionFaq">
                                    <div class="card-body">
                                        {{-- <div class="row">
                                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                <label class="form-label" for="filepond">Posterior Bite Turbos</label>
                                                <input class="filepond " id="key14"
                                                    file="{{ @$patient->fl_posterior_bite_turbos }}" data-field="14"
                                                    type="file">
                                            </div>
                                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                <label class="form-label" for="filepond">Anterior Bite Turbos</label>
                                                <input class="filepond " id="key15"
                                                    file="{{ @$patient->fl_anterior_bite_turbos }}" data-field="15"
                                                    type="file">
                                            </div>
                                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                <label class="form-label" for="filepond">Bite Keeper</label>
                                                <input class="filepond " id="key16"
                                                    file="{{ @$patient->fl_bite_keeper }}" data-field="16" type="file">
                                            </div>
                                            <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                                <label class="form-label" for="filepond">Notes</label>
                                                <input class="filepond " id="key17" file="{{ @$patient->fl_notes }}"
                                                    data-field="17" type="file">
                                            </div>
                                        </div> --}}
                                        <h5 class="">Additional Attachments</h5>
                                        <div class="mb-3">
                                            @php
                                                                    $additional_attachments = [];
                                                                    if ($patient->additional_attachments != '' && $patient->additional_attachments !=
                                                                    null) {
                                                                    $additional_attachments = unserialize($patient->additional_attachments);
                                                                    }
                                                                    @endphp
                                            <div class="form-check">
                                                <input class="form-check-input" id="additional_attachments1" name="additional_attachments" type="checkbox" value="Posterior Bite Turbos" @if(in_array("Posterior Bite Turbos", $additional_attachments)) checked @endif />
                                                <label class="form-check-label" for="additional_attachments1">Posterior Bite Turbos</label>
                                              </div>
                                              <div class="form-check">
                                                <input class="form-check-input" id="additional_attachments2" name="additional_attachments" type="checkbox" value="Anterior Bite Turbos" @if(in_array("Anterior Bite Turbos", $additional_attachments)) checked @endif />
                                                <label class="form-check-label" for="additional_attachments2">Anterior Bite Turbos</label>
                                              </div>
                                              <div class="form-check">
                                                <input class="form-check-input" id="additional_attachments3" name="additional_attachments" type="checkbox" value="Bite Keeper" @if(in_array("Bite Keeper", $additional_attachments)) checked @endif />
                                                <label class="form-check-label" for="additional_attachments3">Bite Keeper</label>
                                              </div>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label>Notes</label>
                                            <textarea class="form-control" name="additional_attachments_notes"
                                                id="additional_attachments_notes"
                                                placeholder="Notes">{{ @$patient->additional_attachments_notes }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" id="keep_already_placed_attachments"
                                                    value="1" type="checkbox" name="keep_already_placed_attachments"
                                                    @if($patient->keep_already_placed_attachments == 1) checked @endif
                                                />
                                                <label class="form-check-label"
                                                    for="keep_already_placed_attachments">Keep already placed
                                                    attachments</label>
                                            </div>
                                        </div>
                                        <h5>Aligner Trim Type</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label>Upper</label>
                                                <select id="trim_type_upper" name="trim_type_upper"
                                                    class="form-control">
                                                    <option value="Straight" @if ($patient->trim_type_upper ==
                                                        'Straight') selected @endif>Straight
                                                    </option>
                                                    <option value="Scalloped" @if ($patient->trim_type_upper ==
                                                        'Scalloped') selected @endif>Scalloped
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label>Lower</label>
                                                <select id="trim_type_lower" name="trim_type_lower"
                                                    class="form-control">
                                                    <option value="Straight" @if ($patient->trim_type_lower ==
                                                        'Straight') selected @endif>Straight
                                                    </option>
                                                    <option value="Scalloped" @if ($patient->trim_type_lower ==
                                                        'Scalloped') selected @endif>Scalloped
                                                    </option>
                                                </select>
                                            </div>
                                        </div>


                                        <h5 class="text-center my-3">Please Mark the last tooth you want the aligners to cover</h5>
                                        <div class="row justify-content-center">
                                            <div class="col-8">
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6  top left tw">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div class="side-label left">
                                                                    U
                                                                </div>
                                                                <div class="direction-label left">
                                                                    R
                                                                </div>
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $tla_ur = [];
                                                                    if ($patient->tla_ur != '' && $patient->tla_ur !=
                                                                    null) {
                                                                    $tla_ur = unserialize($patient->tla_ur);
                                                                    }
                                                                    @endphp
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
                                                    <div class="col-xs-6 col-sm-6 tw top right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $tla_ul = [];
                                                                    if ($patient->tla_ul != '' && $patient->tla_ul !=
                                                                    null) {
                                                                    $tla_ul = unserialize($patient->tla_ul);
                                                                    }
                                                                    @endphp
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
                                                                <div class="side-label right">
                                                                    U
                                                                </div>
                                                                <div class="direction-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-sm-6 tw bottom left">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between left-jaw">
                                                                    @php
                                                                    $tla_lr = [];
                                                                    if ($patient->tla_lr != '' && $patient->tla_lr !=
                                                                    null) {
                                                                    $tla_lr = unserialize($patient->tla_lr);
                                                                    }
                                                                    @endphp
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
                                                                <div class="side-label left">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-sm-6 tw bottom right">
                                                        <div class="teeth-wrapper">
                                                            <div class="card border-0">
                                                                <div
                                                                    class="card-body d-flex justify-content-between right-jaw">
                                                                    @php
                                                                    $tla_ll = [];
                                                                    if ($patient->tla_ll != '' && $patient->tla_ll !=
                                                                    null) {
                                                                    $tla_ll = unserialize($patient->tla_ll);
                                                                    }
                                                                    @endphp
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
                                                                <div class="side-label right">
                                                                    L
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li3">Previous</button>
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" id="submit-prescription"
                                @if(($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) &&
                                $patient->is_prescription_submitted == 1) fn="1"
                                @else
                                fn="0" @endif>Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pill-tab-div5" role="tabpanel" aria-labelledby="pill-tab-li5">

                        <div id="iframe-container">
                            <iframe src="{{ url('/demo/patient/case-overview/'.$patient->id.'?i=true') }}" width="100%" height="6700"
                                style="min-height: 700px;"></iframe>
                        </div>


                        <div class="mb-3 text-end">
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li4">Previous</button>
                            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 next-tab" data-target="#pill-tab-li6">Next</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pill-tab-div6" role="tabpanel" aria-labelledby="pill-tab-li6">
                        <div class="mb-3 notifications" @if ($fn1==1 && $fn2==1 && $fn3==1 && $fn4==1)
                            style="display: none;" @endif>
                            @if ($fn1 == 0)
                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span
                                        class="fas fa-times-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1">Patient Info section is not complete!</p>
                            </div>
                            @endif
                            @if ($fn2 == 0)
                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span
                                        class="fas fa-times-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1">Scan Data section is not complete!</p>
                            </div>
                            @endif
                            @if ($fn3 == 0)
                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span
                                        class="fas fa-times-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1">Images / X-Rays section is not complete!</p>
                            </div>
                            @endif
                            @if ($fn4 == 0)
                            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                <div class="bg-danger me-3 icon-item"><span
                                        class="fas fa-times-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1">Prescription section is not complete!</p>
                            </div>
                            @endif
                        </div>

                        <div class="mb-3 finish" @if ($fn1==0 || $fn2==0 || $fn3==0 || $fn4==0) style="display: none;"
                            @endif>
                            <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                                <div class="bg-success me-3 icon-item"><span
                                        class="fas fa-check-circle text-white fs-3"></span></div>
                                <p class="mb-0 flex-1">Submit case for dr to see!
                                </p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nemotech Link</label>
                                <input type="text" class="form-control" name="nemotech_link" value="{{@$patient->iframe_link}}">
                            </div>

                            <div class="mb-3">
                                <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li5">Previous</button>
                                <button class="btn btn-primary btn-sm waves-effect waves-light px-3" type="button"
                                    id="final-confirm-and-submit-btn">Confirm &
                                    Submit</button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<form method="POST" action="{{ url('/demo/patient/submit') }}" id="final-submit-form">
    @csrf
    <input type="hidden" name="client_preferred_package" value="select">
    <input type="hidden" name="iframe_link" >
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
@stop

@section('javascript')
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
            $("._dropzone_template #key"+key).val('')
            $('._dropzone_template #key'+key).attr('file', '')
            if(message != "") {
                toastError(message);
            }
        }

        let dropzone_active_state = (key, fileName, message = "") => {
            dropzone_state["key"+key] = 'active'
            $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_added").removeClass('_dropzone_added_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_loading").addClass('_dropzone_loading_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_added [data-text]").html(fileName)
            if(message != "") {
                toastError(message);
            }
        }

        let dropzone_uploading_state = (key, message = "") => {
            dropzone_state["key"+key] = 'uploading'
            $(`._dropzone[key='${key}']`).find("._dropzone_hover").addClass('_dropzone_hover_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_added").addClass('_dropzone_added_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_loading").removeClass('_dropzone_loading_hidden')
            $(`._dropzone[key='${key}']`).find("._dropzone_remove").addClass('_dropzone_remove_hidden')
            if(message != "") {
                toastError(message);
            }
        }

        let dropzone_destroy_state = (key, message = "") => {
            $.ajax({
                type: "POST",
                url: "{{url('/demo/patient/file/revert/'.$patient->patient_id.'/'.$patient->id)}}",
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

        let dropzone_upload = (key, file) => {
            let formData = new FormData();
            formData.append('file'+key, file)
            $.ajax({
                url: '{{url('/demo/patient/file/upload/'.$patient->patient_id.'/'.$patient->id)}}?key='+key,
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
                        if(key == 1) {
                            window.previewUpperStlFile('{{asset('storage')}}/PatientFiles/Patient{{$patient->patient_id}}/'+response.fileName)
                        }
                        if(key == 2) {
                            window.previewLowerStlFile('{{asset('storage')}}/PatientFiles/Patient{{$patient->patient_id}}/'+response.fileName)
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

        let openImageEditor = (file, callback) => {
            var editor = document.createElement('div');
            editor.style.position = 'fixed';
            editor.style.left = 0;
            editor.style.right = 0;
            editor.style.top = 0;
            editor.style.bottom = 0;
            editor.style.zIndex = 9999;
            editor.style.backgroundColor = '#000';
            document.body.appendChild(editor);

            var buttonConfirm = document.createElement('button');
            buttonConfirm.style.position = 'absolute';
            buttonConfirm.style.left = '10px';
            buttonConfirm.style.top = '10px';
            buttonConfirm.style.zIndex = 9999;
            buttonConfirm.textContent = 'Confirm';
            editor.appendChild(buttonConfirm);

            buttonConfirm.addEventListener('click', function() {
                document.body.removeChild(editor);
                var croppedImageData = cropper.getCroppedCanvas().toDataURL(file.type);
                var blob = dataURItoBlob(croppedImageData);
                var croppedFile = new File([blob], file.name, { type: file.type });
                callback(croppedFile);
            });

            var image = new Image();
            image.src = URL.createObjectURL(file);
            editor.appendChild(image);

            var cropper = new Cropper(image, { aspectRatio: 1 });
        }

        let dataURItoBlob = (dataURI) => {
            var byteString = atob(dataURI.split(',')[1]);
            var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i < byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            var blob = new Blob([ab], { type: mimeString });
            return blob;
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


                    if(key == '1' || key == '2') {
                        dropzone_upload(key, file)
                        return false;
                    }
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
        })

        $(document).on('click', '._dropzone', function (e) {
            const key = $(this).attr('key')
            if(dropzone_state["key"+key] == 'inactive') {
                $("._dropzone_template #key"+key).trigger('click')
            }
            if(dropzone_state["key"+key] == 'active') {
                dropzone_destroy_state(key)
            }
        })

        $(document).on('change', '._dropzone_template input[data-field]', async function () {
            const key = $(this).attr('data-field')
            var file = this.files[0];
            if (file) {
                var fileSize = file.size / 1024 / 1024; // in MB
                var fileType = file.type.split('/').shift(); // get file type

                var fileName = file.name;
                var fileExtension = fileName.split('.').pop().toLowerCase(); // get file extension

                if(key == '1' || key == '2') {
                    dropzone_upload(key, file)
                    return false;
                }

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
                    //     if(confirm) {
                    //         openImageEditor(file, function(croppedFile) {
                    //             dropzone_upload(key, croppedFile)
                    //         });
                    //     } else {
                    //         dropzone_upload(key, file)
                    //     }
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
<script type="module">
    import { STLLoader } from "{{asset('public/assets/three/examples/jsm/loaders/STLLoader.js')}}";
                import { OrbitControls } from '{{asset("public/assets/three/examples/jsm/controls/OrbitControls.js")}}';




    var container1, scene1, camera1, renderer1, material1, controls1,
    container2, scene2, camera2, renderer2, material2, controls2;


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
    // Remove the renderer's DOM element from the container
    container1.removeChild(renderer1.domElement);

    // Dispose of the geometry and material to free up resources
    scene1.traverse((object) => {
        if (object.isMesh) {
            object.geometry.dispose();
            object.material.dispose();
        }
    });

    // Dispose of the controls to prevent memory leaks
    controls1.dispose();

    // Optionally, dispose of other resources specific to your application
    // ...

    // Set variables to null to release references
    container1 = null;
    scene1 = null;
    camera1 = null;
    renderer1 = null;
    material1 = null;
    controls1 = null;
}

window.destroyPreview1 = destroyPreview1;

function destroyPreview2() {
    // Remove the renderer's DOM element from the container
    container2.removeChild(renderer2.domElement);

    // Dispose of the geometry and material to free up resources
    scene2.traverse((object) => {
        if (object.isMesh) {
            object.geometry.dispose();
            object.material.dispose();
        }
    });

    // Dispose of the controls to prevent memory leaks
    controls2.dispose();

    // Optionally, dispose of other resources specific to your application
    // ...

    // Set variables to null to release references
    container2 = null;
    scene2 = null;
    camera2 = null;
    renderer2 = null;
    material2 = null;
    controls2 = null;
}

window.destroyPreview2 = destroyPreview2;

            function previewUpperStlFile(file_upper)
            {
                container1 = document.getElementById( 'stl-upper-arch-preview' );
                scene1 = new THREE.Scene();
                scene1.name = 'myscene1';
                scene1.background = new THREE.Color( 0xf2f2f2 );
                camera1 = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
                renderer1 = new THREE.WebGLRenderer();
            material1 = new THREE.MeshNormalMaterial();
                controls1 = new OrbitControls(camera1, renderer1.domElement, { enableRotate: true });

                THREE.Cache.enabled = true;

                const width = $("#upper-jaw-box").width();
                const height = $("#upper-jaw-box").height();


    //modify renderer
    renderer1.setSize( width, height );

    //append renderer to body
    document.body.appendChild( renderer1.domElement );
    //prepare STL Loader
    const loader1 = new STLLoader()

    //load upper arch STL file
    loader1.load(file_upper,
    function (geometry) {
        const mesh = new THREE.Mesh(geometry, material1)

        mesh.tag = 'base';
        scene1.add(mesh);

         console.log('scene updated');
        // Output the axis of the model
    },
    (xhr) => {
        // console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
    },
    (error) => {
        console.log(error)
    })
    camera1.position.z = 10;
                camera1.position.x = 0;
                camera1.position.y = -6;
                scene1.scale.set(0.02,0.02,0.02);

                    controls1.update();
                    animate1();
            }



            window.previewUpperStlFile = previewUpperStlFile;

            function previewLowerStlFile(file_lower)
            {

                container2 = document.getElementById( 'stl-lower-arch-preview' );
                scene2 = new THREE.Scene();
                scene2.name = 'myscene2';
                scene2.background = new THREE.Color( 0xf2f2f2 );
                camera2 = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
                renderer2 = new THREE.WebGLRenderer();
            material2 = new THREE.MeshNormalMaterial();
                controls2 = new OrbitControls(camera2, renderer2.domElement, { enableRotate: true });

                THREE.Cache.enabled = true;


                const width = $("#upper-jaw-box").width();
                const height = $("#upper-jaw-box").height();

    //modify renderer
    renderer2.setSize( width, height );

    //append renderer to body
    document.body.appendChild( renderer2.domElement );
    //prepare STL Loader
    const loader2 = new STLLoader()

    //load upper arch STL file
    loader2.load(file_lower,
    function (geometry) {
        const mesh = new THREE.Mesh(geometry, material2)

        mesh.tag = 'base';
        scene2.add(mesh);

         console.log('scene updated');
        // Output the axis of the model
    },
    (xhr) => {
        // console.log((xhr.loaded / xhr.total) * 100 + '% loaded')
    },
    (error) => {
        console.log(error)
    })
    camera2.position.z = 10;
                camera2.position.x = 0;
                camera2.position.y = -6;
                scene2.scale.set(0.02,0.02,0.02);

                    controls2.update();
                    animate2();
            }
            window.previewLowerStlFile = previewLowerStlFile;
            // @if(@$patient->fl_upper_arch)
            // previewUpperStlFile("{{asset("/storage/PatientFiles/Patient" . $patient->patient_id)}}/{{@$patient->fl_upper_arch}}")
            // @endif
            // @if(@$patient->fl_lower_arch)
            // previewLowerStlFile("{{asset("/storage/PatientFiles/Patient" . $patient->patient_id)}}/{{@$patient->fl_lower_arch}}")
            // @endif

            function downloadStlFiles($case_id, $hash_upper, $hash_lower)
        {
            $.ajax({
                type: "POST",
                url: "{{url('/demo/patient/file/download-3shape')}}",
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
                        dropzone_active_state('1', response.upper)
                        previewUpperStlFile('{{asset("/storage/PatientFiles/Patient" . $patient->patient_id)}}/'+response.upper)
                    }
                    if(response.lower) {
                        $('#key2').attr('file', response.lower);
                        dropzone_active_state('2', response.lower)
                        previewLowerStlFile('{{asset("/storage/PatientFiles/Patient" . $patient->patient_id)}}/'+response.lower)
                    }
                    $("#3shape-section").addClass('d-none');
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
    $("#select-from-3shape").on('click', function () {
                $("#3shape-section").removeClass('d-none');
                $("#patient-wizard").addClass('d-none');
            });

            $("#cancel-3shape-select").on('click', function () {
                $("#3shape-section").addClass('d-none');
                $("#patient-wizard").removeClass('d-none');
            });

            $(document).on('click', '.download-3shape-stl-files',function () {
                const hash_upper = $(this).attr('hash-upper'),
                hash_lower = $(this).attr('hash-lower'),
                case_id = $(this).attr('case-id');
                downloadStlFiles(case_id, hash_upper, hash_lower);
            });

            $("#3shape-search").on('submit', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const case_id = $("#3shape-search input[name=_case_id]").val(),
                patient_id = $("#3shape-search input[name=_patient_id]").val(),
                three_shape_case_id = $("#3shape-search input[name=_three_shape_case_id]").val(),
                three_shape_search_for_case = $("#3shape-search input[name=_three_shape_search_for_case]").val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('/demo/integrations/3shape-search-cases') }}",
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

            $(document).on('click', '.previous-tab', function () {
                $(`${$(this).attr('data-target')}`).click();
            });
            $(document).on('click', '.next-tab', function () {
                $(`${$(this).attr('data-target')}`).click();
            });

            $(document).on('click', '#final-confirm-and-submit-btn', function () {
                $("input[name=iframe_link]").val($("input[name=nemotech_link]").val())
                setTimeout(() => {
                    $("#final-submit-form").submit();
                }, 200);


            });
});

</script>

<script>
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



            // Listen for click events on tab links
            $('ul.nav-pills a').on('click', async function(e) {
                e.preventDefault();

                var targetTab = $(this).attr('href');
                var newUrl = window.location.pathname + '?tab=' + targetTab.substring(1);
      window.history.pushState({}, '', newUrl);



if(targetTab == '#pill-tab-div5') {
    $("#iframe-container").html('<iframe src="{{ url('/demo/patient/case-overview/'.$hashids->encode($patient->id).'?i=true') }}" width="100%" height="700" style="min-height: 700px;"></iframe>');
}

                if (targetTab == '#pill-tab-div6') {
                    let responseCall = await $.ajax({
                        type: "POST",
                        url: "{{ url('/demo/patient/validate-data') }}",
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

            @if(@$_GET['tab'])
                fetchOverview()
                 $('ul.nav-pills a[href="#{{$_GET['tab']}}"]').tab('show');
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
            const fp = flatpickr($(".pickr"), {});
            $(document).on('change', 'input[name=pricing_package]', function () {
                if($(this).is(":checked")) {
                    $("input[name=client_preferred_package]").val($(this).val());
                }
            });

            //
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
                    url: "{{ url('/demo/patient/patient-info/save') }}",
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
                    $("#pill-tab-li2").click();
                    toastSuccess("Patient Info Saved");
                }).fail(function(response) {
                    $("#submit-prescription").attr('fn', 0);
                    toastError("Enable to save patient info");
                });
            });
            //
            $("#submit-scan-data").on('click', function() {
                var fl_upper_arch = $("#fl_upper_arch").val();
                var fl_lower_arch = $("#fl_lower_arch").val();
                if ($("#key1").attr('file') == '' || $("#key2").attr('file') == '') {
                    toastError("Upload scan data files.");
                    $("#submit-prescription").attr('fn', 0);
                    return false;
                }
                $("#submit-prescription").attr('fn', 1);
                $("#pill-tab-li3").click();
                toastSuccess("Scan data Saved");
                // $.ajax({
                //     type: "POST",
                //     url: "{{ url('/demo/patient/scan-data/save') }}",
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
                if ($("#key3").attr('file') == '' || $("#key4").attr('file') == '' || $("#key5").attr(
                        'file') == '' || $("#key6").attr('file') == '' || $("#key7").attr('file') == '' ||
                    $("#key8").attr('file') == '' || $("#key9").attr('file') == '' || $("#key10").attr(
                        'file') == '' || $("#key11").attr('file') == '' || $("#key12").attr('file') == '') {
                    $("#submit-images").attr('fn', 0);
                    toastError("Upload all required images.");
                } else {
                    const hyperlink = $("#general_upload_hyperlink").val();
                    if(hyperlink == '') {
                        $("#submit-images").attr('fn', 1);
                    $("#pill-tab-li4").click();
                    toastSuccess("Images / X-Rays saved");
                    } else {
                        $.ajax({
                    type: "POST",
                    url: "{{ url('/demo/patient/images/save') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "hyperlink": hyperlink,
                        "treatment_plan_id": "{{ $patient->id }}",
                        "patient_id": "{{ $patient->patient_id }}"
                    },
                }).done(function(response) {
                    $("#submit-images").attr('fn', 1);
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

                //csrf & id
                fd.append("_token", "{{ csrf_token() }}");
                fd.append("patient_id", "{{ $patient->patient_id }}");
                fd.append("treatment_plan_id", "{{ $patient->id }}");
                $.ajax({
                    type: "POST",
                   url: "{{ url('/demo/patient/prescription/save') }}",
                    data: fd,
                    processData: false,
                    contentType: false,
                }).done(function(response) {
                    $("#submit-prescription").attr('fn', 1);
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

        });


</script>

@stop
