<div class="col-md-8">
        <div class="card">
            <div class="card-body p-0">
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
                                    <a href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_arch) }}"
                                        target="_blank" class="btn btn-link btn-sm ps-0 mt-2">Upper Arch <i
                                            class="fas fa-angle-right"></i></a>
                                @endif
                                @if ($patient->fl_upper_arch)
                                    <a href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_arch) }}"
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
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Frontal"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_frontal) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_frontal) }}?v={{ rand(0, 1000) }}"
                                                            alt="Frontal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Frontal</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_upper_occlusal)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Upper Occlusal"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_occlusal) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_occlusal) }}?v={{ rand(0, 1000) }}"
                                                            alt="Upper Occlusal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Upper Occlusal</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_upper_occlusal)}}">Edit Photo</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_lower_occlusal)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Lower Occlusal"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_occlusal) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_occlusal) }}?v={{ rand(0, 1000) }}"
                                                            alt="Lower Occlusal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Lower Occlusal</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_lower_occlusal)}}">Edit Photo</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_right_buccal)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Right Buccal"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_right_buccal) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_right_buccal) }}?v={{ rand(0, 1000) }}"
                                                            alt="Right Buccal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Right Buccal</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_right_buccal)}}">Edit Photo</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_left_buccal)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Left Buccal"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_left_buccal) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_left_buccal) }}?v={{ rand(0, 1000) }}"
                                                            alt="Left Buccal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Left Buccal</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_left_buccal)}}">Edit Photo</a> --}}
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
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Front"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_front) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_front) }}?v={{ rand(0, 1000) }}"
                                                            alt="Front" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Front</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_profile)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Profile"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_profile) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_profile) }}?v={{ rand(0, 1000) }}"
                                                            alt="Profile" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Profile</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_profile)}}">Edit Photo</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_smile)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Smile"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_smile) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_smile) }}?v={{ rand(0, 1000) }}"
                                                            alt="Smile" /> </a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Smile</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_smile)}}">Edit Photo</a> --}}
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
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_panorex) }}"
                                                        data-gallery="gallery-1" data-lightbox="gallery-1"
                                                        data-title="Panorex"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_panorex) }}?v={{ rand(0, 1000) }}"
                                                            alt="Panorex" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Panorex</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_panorex)}}">Edit Photo</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_lateral_ceph)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Lateral Ceph"
                                                        href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lateral_ceph) }}"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lateral_ceph) }}?v={{ rand(0, 1000) }}"
                                                            alt="Lateral Ceph" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Lateral Ceph</h5>
                                                    {{-- <a class="btn btn-sm btn-falcon- default px-0" href="{{url('/patient/images/edit/'.$hashids->encode($patient->id).'?type=overview&file='.$patient->fl_lateral_ceph)}}">Edit Photo</a> --}}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if ($patient->fl_general_upload)
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                @if (pathinfo($patient->fl_general_upload, PATHINFO_EXTENSION) != 'pdf')
                                                    <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                            data-title="General Upload"
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload) }}"
                                                            data-gallery="gallery-1"><img style="width: 100%;"
                                                                class="img-fluid"
                                                                src="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload) }}?v={{ rand(0, 1000) }}"
                                                                alt="General Upload" /></a>
                                                    </div>
                                                @else
                                                    <p class="mb-0 ps-3"><a
                                                            href="{{ asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload) }}"
                                                            download="">Download</a>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (@$patient->fl_general_upload_drive_link)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading10">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse10" aria-expanded="true"
                                    aria-controls="collapse8">General Upload Link</button>
                            </h2>
                            <div class="accordion-collapse collapse " id="collapse10" aria-labelledby="heading10"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    <div class="card mb-3">
                                        <div class="card-body py-4">
                                            @if (@$patient->fl_general_upload_drive_link)
                                                <div class="container-fluid mt-3">
                                                    <p class="fw-bold">Please click the link below to view the
                                                        uploaded drive link</p>
                                                    <a href="{{ $patient->fl_general_upload_drive_link }}"
                                                        class="btn btn-link btn-sm ps-0 mt-2" target="_blank">Uploaded
                                                        Link <i class="fas fa-angle-right"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                    @if (@$patient->iframe_link && $patient->is_treatment_submitted == 1)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading8">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse8" aria-expanded="true"
                                    aria-controls="collapse8">Treatment
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
                                                        class="btn btn-link btn-sm ps-0 mt-2"
                                                        target="_blank">Treatment Plan <i
                                                            class="fas fa-angle-right"></i></a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @if (@$patient->treatment_link && !empty($stl_files))
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading8">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#treatment-files" aria-expanded="true"
                                        aria-controls="treatment-files">Treatment Files</button>
                                </h2>
                                <div class="accordion-collapse collapse " id="treatment-files"
                                    aria-labelledby="heading8" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="card">
                                            <div class="card-body" style="padding: 10px !important;">
                                                @if (@$patient->treatment_link && !empty($stl_files))
                                                    <div class="d-flex flex-wrap gap-2 justify-content-start">
                                                        @php
                                                            $groupedSteps = [];
                                                            $retGroup = [];
                                                            foreach ($stl_files as $file) {

                                                                $parts = extractStepParts($file->name);
                                                                if (!$parts) continue;

                                                                $step = $parts['step'];

                                                                $dir = $parts['direction'];
                                                                $ext = strtolower(pathinfo($file->name, PATHINFO_EXTENSION));

                                                                // 🔹 If this is RET step → put into a separate group
                                                                if (strtolower($step) === 'ret') {
                                                                    Log::info($file->name);
                                                                    if (!isset($retGroup[$dir])) {
                                                                        $retGroup[$dir] = [];
                                                                    }
                                                                    $retGroup[$dir][$ext] = $file;
                                                                    continue;
                                                                }
                                                                if (!isset($groupedSteps[$step])) {
                                                                    $groupedSteps[$step] = [];
                                                                }
                                                                if (!isset($groupedSteps[$step][$dir])) {
                                                                    $groupedSteps[$step][$dir] = [];
                                                                }

                                                                $groupedSteps[$step][$dir][$ext] = $file; // e.g. ['stl' => file, 'pts' => file]
                                                            }
                                                            ksort($groupedSteps);
                                                            ksort($retGroup);

                                                        @endphp

                                                        @foreach ($groupedSteps as $step => $sides)
                                                            <div class="mt-3 d-flex gap-2 flex-wrap align-items-center pt-2">

                                                                {{-- Upper (U) --}}
                                                                @if (isset($sides['U']))
                                                                    @php $u = $sides['U']; @endphp
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-primary download-multi"
                                                                            data-files='@json(array_filter([
                                                                                $u["stl"]->webContentLink ?? null,
                                                                                $u["pts"]->webContentLink ?? null
                                                                            ]))'
                                                                            title="U{{ $step }}">
                                                                        <strong>U{{ $step }}</strong>
                                                                    </button>
                                                                @endif

                                                                {{-- Lower (L) --}}
                                                                @if (isset($sides['L']))
                                                                    @php $l = $sides['L']; @endphp
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-success download-multi"
                                                                            style="background-color: #80C6C7"
                                                                            data-files='@json(array_filter([
                                                                                $l["stl"]->webContentLink ?? null,
                                                                                $l["pts"]->webContentLink ?? null
                                                                            ]))'
                                                                            title="L{{ $step }}">
                                                                        <strong>L{{ $step }}</strong>
                                                                    </button>
                                                                @endif

                                                            </div>
                                                        @endforeach

                                                        @if (!empty($retGroup))
                                                            <div class="mt-3 d-flex gap-2 flex-wrap align-items-center pt-2">
                                                                {{-- RU --}}
                                                                @if (isset($retGroup['U']))
                                                                    @php $u = $retGroup['U']; @endphp
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-primary download-multi"
                                                                        data-files='@json(array_filter([
                                                                            $u["stl"]->webContentLink ?? null,
                                                                            $u["pts"]->webContentLink ?? null
                                                                        ]))'
                                                                        title="RU">
                                                                        <strong>RU</strong>
                                                                    </button>
                                                                @endif

                                                                {{-- RL --}}
                                                                @if (isset($retGroup['L']))
                                                                    @php $l = $retGroup['L']; @endphp
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-success download-multi"
                                                                        style="background-color: #80C6C7"
                                                                        data-files='@json(array_filter([
                                                                            $l["stl"]->webContentLink ?? null,
                                                                            $l["pts"]->webContentLink ?? null
                                                                        ]))'
                                                                        title="RL">
                                                                        <strong>RL</strong>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        @endif
                                                        @csrf
                                                        {{-- @foreach ($groupedSteps as $step => $sides)
                                                            <div class="mb-2">
                                                                @if (isset($sides['U']))
                                                                    <a class="btn btn-sm btn-primary"
                                                                    href="{{ $sides['U']->webContentLink }}"
                                                                    target="_blank" download
                                                                    title="{{ $sides['U']->name }}">
                                                                        <strong>U{{ $step }}</strong>
                                                                    </a>
                                                                @endif

                                                                @if (isset($sides['L']))
                                                                    <a class="btn btn-sm btn-success" style="background-color: #80C6C7"
                                                                    href="{{ $sides['L']->webContentLink }}"
                                                                    target="_blank" download
                                                                    title="{{ $sides['L']->name }}">
                                                                        <strong>L{{ $step }}</strong>
                                                                    </a>
                                                                @endif
                                                            </div><br><br>
                                                        @endforeach --}}

                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
