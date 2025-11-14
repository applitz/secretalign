@extends('layouts.app_base_horizontal')

@section('css')
<link rel="stylesheet" href="{{ asset('public/') }}/filepond/dist/filepond.css">
<link rel="stylesheet" href="{{ asset('public/') }}/filepond/dist/filepond-plugin-image-preview.css">
<link rel="stylesheet" href="{{ asset('public/assets') }}/restrictions.css">

<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

<!-- Lightbox JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" defer></script>
@stop

@section('content')
<style>
    .lb-data .lb-close {
    display: block;
    /* float: right; */
    position: fixed;
    right: 25px;
    top: 17px;
}
.lb-nav a.lb-next,.lb-nav a.lb-prev {
opacity:1;

}
</style>
<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url('/patients')}}">Patients</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('patient/case-overview/'.$patient->id) }}">Case Overview</a></li>
                        <li class="breadcrumb-item active">Documentation</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>



    <div class="row gx-0">
        <div class="col-12 ">
            <div class="card">

                <div class="card-body py-4">


                    <ul class="nav nav-pills gap-3" id="pill-myTab" role="tablist">
                        <li class="nav-item"><a class="nav-link text-900 active" id="pill-tab-li1" data-bs-toggle="tab"
                                href="#pill-tab-div1" role="tab" aria-controls="pill-tab-div1" aria-selected="true">Before</a></li>

                        <li class="nav-item"><a class="nav-link text-900" id="pill-tab-li2" data-bs-toggle="tab"
                                href="#pill-tab-div2" role="tab" aria-controls="pill-tab-div2" aria-selected="true">After</a></li>
                    </ul>

                    <div class="tab-content p-3 mt-3" id="pill-myTabContent">


                        <div class="tab-pane show active fade" id="pill-tab-div1" role="tabpanel" aria-labelledby="pill-tab-li1">
                            {{-- <div class="row mb-3">
                                <div class="col-xxl-6 col-12">
                                    <label class="form-label" for="fl_upper_arch">Upper Arch</label>
                                    <input class="filepond " id="key1" file="{{@$before->fl_upper_arch}}" data-field="1"
                                        type="file">
                                </div>
                                <div class="col-xxl-6 col-12">
                                    <label class="form-label" for="fl_lower_arch">Lower Arch</label>
                                    <input class="filepond " id="key2" file="{{@$before->fl_lower_arch}}" data-field="2"
                                        type="file">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Front</label>
                                    <input class="filepond " id="key3" file="{{@$before->fl_front}}" data-field="3"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Smile</label>
                                    <input class="filepond " id="key4" file="{{@$before->fl_smile}}" data-field="4"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Profile</label>
                                    <input class="filepond " id="key5" file="{{@$before->fl_profile}}" data-field="5"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Frontal (Intraoral)</label>
                                    <input class="filepond " id="key6" file="{{@$before->fl_frontal}}" data-field="6"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Right Buccal</label>
                                    <input class="filepond " id="key7" file="{{@$before->fl_right_buccal}}"
                                        data-field="7" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Left Buccal</label>
                                    <input class="filepond " id="key8" file="{{@$before->fl_left_buccal}}" data-field="8"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Upper Occlusal</label>
                                    <input class="filepond " id="key9" file="{{@$before->fl_upper_occlusal}}"
                                        data-field="9" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Lower Occlusal</label>
                                    <input class="filepond " id="key10" file="{{@$before->fl_lower_occlusal}}"
                                        data-field="10" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Panorex</label>
                                    <input class="filepond " id="key11" file="{{@$before->fl_panorex}}" data-field="11"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Lateral Ceph</label>
                                    <input class="filepond " id="key12" file="{{@$before->fl_lateral_ceph}}"
                                        data-field="12" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">General Upload</label>
                                    <input class="filepond " id="key13" file="{{@$before->fl_general_upload}}"
                                        data-field="13" type="file">
                                </div>

                            </div>
                            <div class="mb-3">
                                <button class="btn btn-falcon-default" type="button" onclick="window.location.reload();">Save
                                    Changes</button>
                            </div> --}}
                            <div class="row mb-3">
                                <div class="col-md-8">
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
                                                    @if ($before->fl_upper_arch)
                                                    <a href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_upper_arch) }}"
                                                        target="_blank" class="btn btn-link btn-sm ps-0 mt-2">Upper Arch <i
                                                            class="fas fa-angle-right"></i></a>
                                                    @endif
                                                    @if ($before->fl_upper_arch)
                                                    <a href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_lower_arch) }}"
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

                                                        @if ($before->fl_frontal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_frontal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Frontal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_frontal) }}?d={{rand(0,10000)}}"
                                                                            alt="Frontal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Frontal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id.'?type=overview&file='.$before->fl_frontal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_upper_occlusal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_upper_occlusal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Upper Occlusal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_upper_occlusal) }}?d={{rand(0,10000)}}"
                                                                            alt="Upper Occlusal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Upper Occlusal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id . '?type=overview&file='.$before->fl_upper_occlusal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_lower_occlusal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_lower_occlusal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Lower Occlusal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_lower_occlusal) }}?d={{rand(0,10000)}}"
                                                                            alt="Lower Occlusal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Lower Occlusal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id .'?type=overview&file='.$before->fl_lower_occlusal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_right_buccal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_right_buccal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Right Buccal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_right_buccal) }}?d={{rand(0,10000)}}"
                                                                            alt="Right Buccal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Right Buccal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$patient->id .'?type=overview&file='.$before->fl_right_buccal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_left_buccal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_left_buccal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Left Buccal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_left_buccal) }}?d={{rand(0,10000)}}"
                                                                            alt="Left Buccal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Left Buccal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=overview&file='.$before->fl_left_buccal)}}">Edit Photo</a>
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
                                                        @if ($before->fl_front)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_front) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Front"><img style="width: 100%" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_front) }}?d={{rand(0,10000)}}"
                                                                            alt="Front" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Front</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=overview&file='.$before->fl_front)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_profile)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_profile) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Profile"><img style="width: 100%" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_profile) }}?d={{rand(0,10000)}}"
                                                                            alt="Profile" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Profile</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=overview&file='.$before->fl_profile)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_smile)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_smile) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Smile"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_smile) }}?d={{rand(0,10000)}}"
                                                                            alt="Smile" /> </a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Smile</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=overview&file='.$before->fl_smile)}}">Edit Photo</a>
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
                                                        @if ($before->fl_panorex)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_panorex) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Panorex"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_panorex) }}?d={{rand(0,10000)}}"
                                                                            alt="Panorex" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Panorex</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/' . $patient->id . '?type=overview&file='.$before->fl_panorex)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_lateral_ceph)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_lateral_ceph) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="Lateral Ceph"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_lateral_ceph) }}?d={{rand(0,10000)}}"
                                                                            alt="Lateral Ceph" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Lateral Ceph</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=overview&file='.$before->fl_lateral_ceph)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($before->fl_general_upload)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                @if (pathinfo($before->fl_general_upload, PATHINFO_EXTENSION) != 'pdf')
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_general_upload) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-1" data-title="General Upload"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_general_upload) }}??d={{rand(0,10000)}}"
                                                                            alt="General Upload" /></a>
                                                                </div>
                                                                @else
                                                                <p class="mb-0 ps-3"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $before->fl_general_upload) }}"
                                                                        download="">Download</a>
                                                                </p>
                                                                @endif
                                                                <div class="card-body">
                                                                    <h5 class="card-title">General Upload
                                                                    </h5>
                                                                    @if(pathinfo($before->fl_general_upload, PATHINFO_EXTENSION) != 'pdf')
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/' . $patient->id . '?type=overview&file='.$before->fl_general_upload)}}">Edit Photo</a>
                                                                    @endif
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
                        </div>

                        <div class="tab-pane fade" id="pill-tab-div2" role="tabpanel" aria-labelledby="pill-tab-li2">
                            <div class="row mb-3">
                                <div class="col-xxl-6 col-12">
                                    <label class="form-label" for="fl_upper_arch">Upper Arch</label>
                                    <input class="filepond " id="key14" file="{{@$after->fl_upper_arch}}" data-field="14"
                                        type="file">
                                </div>
                                <div class="col-xxl-6 col-12">
                                    <label class="form-label" for="fl_lower_arch">Lower Arch</label>
                                    <input class="filepond " id="key15" file="{{@$after->fl_lower_arch}}" data-field="15"
                                        type="file">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Front</label>
                                    <input class="filepond " id="key16" file="{{@$after->fl_front}}" data-field="16"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Smile</label>
                                    <input class="filepond " id="key17" file="{{@$after->fl_smile}}" data-field="17"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Profile</label>
                                    <input class="filepond " id="key18" file="{{@$after->fl_profile}}" data-field="18"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Frontal (Intraoral)</label>
                                    <input class="filepond " id="key19" file="{{@$after->fl_frontal}}" data-field="19"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Right Buccal</label>
                                    <input class="filepond " id="key20" file="{{@$after->fl_right_buccal}}"
                                        data-field="20" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Left Buccal</label>
                                    <input class="filepond " id="key21" file="{{@$after->fl_left_buccal}}" data-field="21"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Upper Occlusal</label>
                                    <input class="filepond " id="key22" file="{{@$after->fl_upper_occlusal}}"
                                        data-field="22" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Lower Occlusal</label>
                                    <input class="filepond " id="key23" file="{{@$after->fl_lower_occlusal}}"
                                        data-field="23" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Panorex</label>
                                    <input class="filepond " id="key24" file="{{@$after->fl_panorex}}" data-field="24"
                                        type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">Lateral Ceph</label>
                                    <input class="filepond " id="key25" file="{{@$after->fl_lateral_ceph}}"
                                        data-field="25" type="file">
                                </div>
                                <div class="col-xxl-3 col-lg-4 col-md-4 col-sm-6 col-12">
                                    <label class="form-label" for="filepond">General Upload</label>
                                    <input class="filepond " id="key26" file="{{@$after->fl_general_upload}}"
                                        data-field="26" type="file">
                                </div>

                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary waves-effect waves-light" type="button" onclick="window.location.reload();">Save
                                    Changes</button>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-8">
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
                                                    @if ($after->fl_upper_arch)
                                                    <a href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_upper_arch) }}"
                                                        target="_blank" class="btn btn-link btn-sm ps-0 mt-2">Upper Arch <i
                                                            class="fas fa-angle-right"></i></a>
                                                    @endif
                                                    @if ($after->fl_upper_arch)
                                                    <a href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_lower_arch) }}"
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

                                                        @if ($after->fl_frontal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_frontal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1" data-lightbox="gallery-2" data-title="Frontal"> <img style="width: 100%;"  class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_frontal) }}?d={{rand(0,10000)}}"
                                                                            alt="Frontal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Frontal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_frontal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_upper_occlusal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_upper_occlusal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Upper Occlusal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_upper_occlusal) }}?d={{rand(0,10000)}}"
                                                                            alt="Upper Occlusal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Upper Occlusal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_upper_occlusal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_lower_occlusal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_lower_occlusal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Lower Occlusal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_lower_occlusal) }}?d={{rand(0,10000)}}"
                                                                            alt="Lower Occlusal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Lower Occlusal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_lower_occlusal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_right_buccal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_right_buccal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Right Buccal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_right_buccal) }}?d={{rand(0,10000)}}"
                                                                            alt="Right Buccal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Right Buccal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_right_buccal)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_left_buccal)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_left_buccal) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Left Buccal"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_left_buccal) }}?d={{rand(0,10000)}}"
                                                                            alt="Left Buccal" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Left Buccal</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_left_buccal)}}">Edit Photo</a>
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
                                                        @if ($after->fl_front)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_front) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Front"><img style="width: 100%" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_front) }}?d={{rand(0,10000)}}"
                                                                            alt="Front" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Front</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_front)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_profile)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_profile) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Profile"><img style="width: 100%" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_profile) }}?d={{rand(0,10000)}}"
                                                                            alt="Profile" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Profile</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_profile)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_smile)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_smile) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Smile"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_smile) }}?d={{rand(0,10000)}}"
                                                                            alt="Smile" /> </a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Smile</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_smile)}}">Edit Photo</a>
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
                                                        @if ($after->fl_panorex)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_panorex) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Panorex"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_panorex) }}?d={{rand(0,10000)}}"
                                                                            alt="Panorex" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Panorex</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_panorex)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_lateral_ceph)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_lateral_ceph) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="Lateral Ceph"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_lateral_ceph) }}?d={{rand(0,10000)}}"
                                                                            alt="Lateral Ceph" /></a>
                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title">Lateral Ceph</h5>
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_lateral_ceph)}}">Edit Photo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        @if ($after->fl_general_upload)
                                                        <div class="col-xl-4 mb-3">
                                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                                @if (pathinfo($after->fl_general_upload, PATHINFO_EXTENSION) != 'pdf')
                                                                <div class="card-img-top text-center"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_general_upload) }}?d={{rand(0,10000)}}"
                                                                        data-gallery="gallery-1"  data-lightbox="gallery-2" data-title="General Upload"><img style="width: 100%;" class="img-fluid"
                                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_general_upload) }}?d={{rand(0,10000)}}"
                                                                            alt="General Upload" /></a>
                                                                </div>
                                                                @else
                                                                <p class="mb-0 ps-3"><a
                                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/documentation/' . $after->fl_general_upload) }}"
                                                                        download="">Download</a>
                                                                </p>
                                                                @endif
                                                                <div class="card-body">
                                                                    <h5 class="card-title">General Upload
                                                                    </h5>
                                                                    @if(pathinfo($after->fl_general_upload, PATHINFO_EXTENSION) != 'pdf')
                                                                    <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'. $patient->id .'?type=history&file='.$after->fl_general_upload)}}">Edit Photo</a>
                                                                    @endif
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>



@stop


@section('javascript')

@include('layouts.page_scripts')
<script src="{{ asset('public/filepond/dist') }}/filepond.min.js"></script>
<script src="{{ asset('public/filepond/dist') }}/filepond.jquery.js"></script>
<script src="{{ asset('public/filepond/dist') }}/filepond-plugin-image-preview.js"></script>
<script src="{{ asset('public/filepond/dist') }}/filepond-plugin-image-exif-orientation.js"></script>
<script src="{{ asset('public/filepond/dist') }}/filepond-plugin-file-validate-size.js"></script>
<script src="{{ asset('public/filepond/dist') }}/filepond-plugin-image-edit.js"></script>
<script src="{{ asset('public/filepond/dist') }}/filepond-plugin-file-validate-type.js"></script>
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
                // Get the ID of the clicked tab
                var targetTab = $(this).attr('href');

                // Update the URL hash to match the clicked tab
                window.location.hash = targetTab;





                if (targetTab == '#pill-tab-div5') {
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

            // Check if URL has a hash value and activate the corresponding tab
            if (window.location.hash) {
                $('ul.nav-pills a[href="' + window.location.hash + '"]').tab('show');
            }



        });
</script>
<script>
    const mode = "";
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
<script>
    $(function() {
            'use-strict';
            const fp = flatpickr($(".pickr"), {});
            //filepond
            var files = [];
            var inputElements = $(".filepond");
            inputElements.each((index) => {

                let load_files = [

                ];
                var inputElement = inputElements.eq(index)
                var id = inputElement.attr('data-field')
                var file = inputElement.attr('file')

                var acceptedFiles = ['image/*'];
                if (id == 1 || id == 2 || id == 14 || id == 15) {
                    acceptedFiles = [];
                }
                if (id == 13 || id == 26) {
                    acceptedFiles = ['application/pdf', 'image/*'];
                }
                if (file != '') {
                    load_files.push({
                        options: {
                            type: 'local',
                        },
                        source: file
                    });
                    files.push(id + "__" + file);
                }
                FilePond.registerPlugin(
                    FilePondPluginImagePreview,
                    FilePondPluginImageExifOrientation,
                    FilePondPluginFileValidateSize,
                    FilePondPluginImageEdit,
                    FilePondPluginFileValidateType
                );
                // create a FilePond instance at the input element location
                FilePond.create(

                    document.querySelector('#key' + id), {
                        name: 'attachment',
                        oninit: () => {
                            // Add a `data-file` attribute to the element
                            document.querySelector('#key' + id).setAttribute('file', file);
                        },
                        allowMultiple: false,
                        allowImagePreview: true,
                        imagePreviewFilterItem: false,
                        imagePreviewMarkupFilter: false,
                        //dataMaxFileSize:"20MB",
                        acceptedFileTypes: acceptedFiles,
                        fileValidateTypeDetectType: (source, type) =>
                            new Promise((resolve, reject) => {
                                // Do custom type detection here and return with promise

                                resolve(type);
                            }),
                        // server
                        server: {
                            process: {
                                url: '{{ url('/patient/documentation/upload/' . $patient->patient_id . '/' . $patient->id) }}?id=' +
                                    id,
                                method: 'POST',
                                headers: {
                                    'x-customheader': 'Processing File'
                                },
                                onload: (response) => {
                                    response = response;
                                    $('#key' + id).attr('file', response);
                                    files.push(id + '__' + response);
                                    return response;

                                },
                                onerror: (response) => {
                                    console.log(response)
                                    return response
                                },
                                ondata: (formData) => {
                                    //console.log(formData)
                                    window.h = formData;

                                    return formData;
                                }
                            },
                            revert: (uniqueFileId, load, error) => {
                                const formData = new FormData();
                                formData.append("key", uniqueFileId);
                                files = files.filter(function(ele) {
                                    return ele != id + '__' + uniqueFileId;
                                });

                                fetch(`{{ url('/patient/documentation/revert/' . $patient->patient_id . '/' . $patient->id) }}?key=${uniqueFileId}&id=` +
                                        id, {
                                            method: "DELETE",
                                            body: formData,
                                        }).then(res => res.json())
                                    .then(json => {
                                        // Should call the load method when done, no parameters required
                                        $('#key' + id).attr('file', '');
                                        load();

                                    })
                                    .catch(err => {
                                        // Can call the error method if something is wrong, should exit after
                                        error(err.message);
                                    })
                            },

                            load: (uniqueFileId, load, error, progress, abort, headers) => {
                                // implement logic to load file from server here
                                // https://pqina.nl/filepond/docs/patterns/api/server/#load-1

                                let controller = new AbortController();
                                let signal = controller.signal;
                                var XMLHttpRequest1 = new XMLHttpRequest();
                                fetch(`{{ url('/patient/documentation/load/' . $patient->patient_id) }}?key=${uniqueFileId}`, {
                                        method: "GET",
                                        signal,
                                    })
                                    .then(res => {

                                        window.c = res
                                        console.log(res)
                                        return res.blob();
                                    })
                                    .then(blob => {


                                        const imageFileObj = new File([blob],
                                            `${uniqueFileId}`, {
                                                type: blob.type
                                            })
                                        //console.log(imageFileObj)
                                        progress(true, 0, blob.size);

                                        load(imageFileObj)


                                    })
                                    .catch(err => {



                                    })

                                return {
                                    abort: () => {
                                        // User tapped cancel, abort our ongoing actions here
                                        controller.abort();
                                        // Let FilePond know the request has been cancelled
                                        abort();
                                    }
                                };
                            },

                            remove: (uniqueFileId, load, error) => {
                                // Should somehow send `source` to server so server can remove the file with this source
                                files = files.filter(function(ele) {
                                    return ele != id + '__' + uniqueFileId;
                                });


                                // Should call the load method when done, no parameters required
                                load();
                            },


                        },
                        onactivatefile: function(file) {
                            var win = window.open("{{ asset('public/files_pond') }}/" + file
                                .source, '_blank');
                            win.focus();
                        },
                        //files array
                        files: load_files,
                    }
                );
            })
        });

        $(document).ready(function() {

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
                    url: "{{ url('/patient/images/save') }}",
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
                    toastError("Select your preferred treatment either upper or lower arch or both.");
                    return false;
                }
                //midline
                var midline = $("input[name=midline]:checked").val() || '';
                fd.append("midline", midline);
                var midline_notes = $("textarea[name=midline_notes]").val();
                fd.append("midline_notes", midline_notes);
                if (midline == '' || midline == undefined || midline == null) {
                    toastError("Midline section is required.");
                    return false;
                }
                //archform
                var archform = $("input[name=archform]:checked").val() || '';
                fd.append("archform", archform);
                var archform_notes = $("textarea[name=archform_notes]").val();
                fd.append("archform_notes", archform_notes);
                if (archform == '' || archform == undefined || archform == null) {
                    toastError("Archform section is required.");
                    return false;
                }
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
                    toastError("Class section is required.");
                    return false;
                }
                //resolutions
                var size_issues = $("input[name=size_issues]:checked").val() || '';
                fd.append("size_issues", size_issues);
                if (size_issues == '' || size_issues == undefined || size_issues == null) {
                    toastError("Resolve tooth size issues section is required. Select atleast an option.");
                    return false;
                }
                var location_upper = $("select[name=location_upper]").val();
                fd.append("location_upper", location_upper);
                var location_lower = $("select[name=location_lower]").val();
                fd.append("location_lower", location_lower);
                if (location_lower == '' || location_upper == '' || location_lower == undefined ||
                    location_lower == null || location_upper == undefined || location_upper == null) {
                    toastError("Select upper and lower locations.");
                    return false;
                }
                var limits = $("input[name=limits]").val();
                fd.append("limits", limits);
                if (limits == '' || limits == undefined || limits == null) {
                    toastError("Enter Maximum Ant. IPR/Contact limit.");
                    return false;
                }
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
                    toastError("Occlusal plan section is required.");
                    return false;
                }
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
                    toastError("Aligner trim type lower and upper are required.");
                    return false;
                }
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
                    $("#pill-tab-li5").click();
                    toastSuccess("Prescription Saved");
                }).fail(function(response) {
                    $("#submit-prescription").attr('fn', 0);
                    toastError("Enable to save prescription");
                });
            });
        });
</script>
@stop
