
@php
    use Illuminate\Support\Facades\DB;
    $upper_arch_stl = asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_arch);
    $lower_arch_stl = asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_arch);
    $primaryExt = strtolower(pathinfo($patient->fl_upper_arch ?? '', PATHINFO_EXTENSION));

    $hasOptionalScansGlobal = !empty($patient->optional_fl_upper_arch) && !empty($patient->optional_fl_lower_arch);
    $optional_upper_arch_stl_global = $hasOptionalScansGlobal
        ? asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->optional_fl_upper_arch)
        : '';
    $optional_lower_arch_stl_global = $hasOptionalScansGlobal
        ? asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->optional_fl_lower_arch)
        : '';
    $optionalExt = strtolower(pathinfo($patient->optional_fl_upper_arch ?? '', PATHINFO_EXTENSION));
    $optionalViewerEnabled = $hasOptionalScansGlobal && ($patient->is_treatment_submitted == 0) && empty($patient->iframe_link);
@endphp

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
    if (
        $patient->fl_front &&
        $patient->fl_smile &&
        $patient->fl_profile &&
        $patient->fl_frontal &&
        $patient->fl_right_buccal &&
        $patient->fl_left_buccal &&
        $patient->fl_upper_occlusal &&
        $patient->fl_lower_occlusal &&
        $patient->fl_panorex &&
        $patient->fl_lateral_ceph
    ) {
        $fn3 = 1;
    }
    if ( ($patient->treat_upper_arch == 1 || $patient->treat_lower_arch == 1) && $patient->is_prescription_submitted == 1 ) {
        $fn4 = 1;
    }
@endphp
@include('patients.case-overview.case_overview_header')


<div class="row gx-2">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body py-4" id="card-body-for-iframe">

                <p><strong>Name:</strong> {{ $patient->first_name . ' ' . $patient->last_name }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->dob }}</p>
                <p><strong>Treatment Type:</strong> {{ $patient->treatment_type == 1 ? 'Treatment Plan Service' : 'Aligners Full-Service' }}</p>

                @php
                    $hasOptionalScans = !empty($patient->optional_fl_upper_arch) && !empty($patient->optional_fl_lower_arch);
                    $optional_upper_arch_stl = $hasOptionalScans
                        ? asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->optional_fl_upper_arch)
                        : '';
                    $optional_lower_arch_stl = $hasOptionalScans
                        ? asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->optional_fl_lower_arch)
                        : '';
                @endphp

                <div class="row">
                    <div class="{{ $hasOptionalScans ? 'col-md-6' : 'col-md-12' }}">
                        <h6 class="mb-2">Primary Scan</h6>
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
                                                <?php echo $step; ?>
                                            </label>
                                        </div>
                                        <div class="mb-3 mt-3 d-none">
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
                                        @if($role && ($role == 'staff' || $role == 'doctor') && $patient->is_approved != 1)
                                            @if($patient->status == 'Treatment Plan Completed' || $patient->status == 'Doctor requests a Modification to Setup 1' || $patient->status == 'Waiting Doctor’s Review' )
                                            <select id="patientOption" name="patient_option"
                                                class="form-select stylish-dropdown-half fw-medium border-0 shadow-sm"
                                                onchange="syncNemoLink(this)">
                                                <option value="">Please select option</option>
                                                <option value="view" {{ $patient->link_type == 'view' ? 'selected' : '' }}>Advanced Viewer</option>
                                                <option value="edit" {{ $patient->link_type == 'edit' ? 'selected' : '' }}>Editor</option>
                                            </select>
                                            @endif
                                        @endif
                                        @if($role && ($role == 'lab') && $patient->is_approved != 1)
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

                    @if ($hasOptionalScans)
                        <div class="col-md-6">
                            <h6 class="mb-2">Optional Scan</h6>
                            @if ($patient->is_treatment_submitted == 0 && !@$patient->iframe_link)
                                <div class="container-fluid mx-0 my-3" id="hide-on-paste-optional">
                                    <div class="row mb-3">
                                        <div class="col-xl-12 d-none">
                                            <div class="progress mb-3" id="progress-wrapper-optional" style="height: 30px;">
                                                <div id="loading-bar-optional" class="progress-bar bg-success progress-bar-striped"
                                                    role="progressbar" style="width: 2%" aria-valuenow="2" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="btn-group float-end view-btns" role="group"
                                                aria-label="Basic radio toggle button group">
                                                <input data-cameraz="10" data-camerax="0" data-visible="1" type="radio"
                                                    class="btn-check model-control" name="btnradio_optional" id="labial_optional"
                                                    autocomplete="off">
                                                <label class="btn btn-outline-primary btn-square" for="labial_optional">Front</label>
                                                <input data-camerax="-10" data-visible="1" type="radio"
                                                    class="btn-check model-control" name="btnradio_optional" id="right_buccal_optional"
                                                    autocomplete="off">
                                                <label class="btn btn-outline-primary btn-square" for="right_buccal_optional">Right
                                                    Buccal</label>
                                                <input data-camerax="10" data-visible="1" type="radio"
                                                    class="btn-check model-control" name="btnradio_optional" id="left_buccal_optional"
                                                    autocomplete="off">
                                                <label class="btn btn-outline-primary btn-square" for="left_buccal_optional">Left
                                                    Buccal</label>
                                                <input data-camerax="-10" type="radio" class="btn-check model-control"
                                                    name="btnradio_optional" id="maxillary_optional" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-square btn-square" for="maxillary_optional">Upper
                                                    Occlusal</label>
                                                <input data-camerax="10" type="radio" class="btn-check model-control"
                                                    name="btnradio_optional" id="mandibular_optional" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-square" for="mandibular_optional">Lower
                                                    Occlusal</label>
                                            </div>
                                            <div class="p-3">
                                                <h6 class="mb-3 mt-0">Rotate Vertically</h6>
                                                <input type="range" class="form-range" id="slider_optional">
                                            </div>

                                            @if (!@$patient->iframe_link)
                                                <div id="canvas_optional" class="canvas-bg"></div>
                                            @endif

                                            <div class="btn-group float-end btns-steps" role="group"
                                                aria-label="Basic radio toggle button group d-block"
                                                style="display:none !important;">
                                                <?php
                                                $optional_step = 1;
                                                ?>
                                                <input data-maxillary="<?php echo $optional_upper_arch_stl; ?>" data-mandibular="<?php echo $optional_lower_arch_stl; ?>"
                                                    data-cameraz="10" data-camerax="0" data-visible="1" type="radio"
                                                    class="btn-check step-control" name="step-trigger-optional"
                                                    id="step-optional-{{ $optional_step }}" autocomplete="off">
                                                <label class="btn btn-outline-primary btn-square step-trigger"
                                                    for="step-optional-<?php echo $optional_step; ?>">
                                                    <?php echo $optional_step; ?>
                                                </label>
                                            </div>
                                            <div class="mb-3 mt-3 d-none">
                                                <input value="0" type="range" class="form-range" min="0"
                                                    max="<?php echo 1 - 1; ?>" id="customRange2_optional" step="1">
                                            </div>
                                            <div class="btn-group d-none" aria-label="Basic example" role="group">
                                                <button id="play-button-optional" type="button" class="btn btn-outline-primary btn-square">
                                                    <i class="fas fa-play"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>


<!-- @include('patients.case-overview.card_body_for_iframe') -->

<div class="row gx-2">
    @include('patients.case-overview.card_body_for_iframe_right')

    @include('patients.case-overview.card_body_for_iframe_left')
</div>

{{-- </div>
</div>
</div>
</div>
</div>



</div>
</div>
</div> --}}

<div class="modal fade" id="docSendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('patient.alert') }}" id="patientAlert">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Treatment Plan to Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="{{ $patient->patient_id }}">
                    <input type="hidden" name="patient_link" value="{{ $patient->patient_link ?? '' }}" class="form-control">

                    <div class="mb-3">
                        <label class="form-label">Patient's Email</label>
                        <input type="email" class="form-control" name="email" placeholder="example@gmail.com" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send Treatment Plan to Patient</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="current-view" style="display:none;"></div>
<div class="row mb-5"><br style="clear:both;" /></div>
<div id="current-module" style="display:none;"></div>

@if (@$_GET['i'] == 'true')
    <script type="module">
        import {
            STLLoader
        } from "{{ asset('public/assets/three/examples/jsm/loaders/STLLoader.js') }}";
        import {
            PLYLoader
        } from "{{ asset('public/assets/three/examples/jsm/loaders/PLYLoader.js') }}";
        import {
            OrbitControls
        } from "{{ asset('public/assets/three/examples/jsm/controls/OrbitControls.js') }}";

        const container = document.getElementById('canvas');
        const scene = new THREE.Scene();
        scene.name = 'myscene';
        scene.background = new THREE.Color(0xaaaaaa);
        const camera = new THREE.PerspectiveCamera(10, 1420 / 764, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({
            antialias: true
        });
        const primaryExt = "{{ $primaryExt }}";
        const material = primaryExt === 'stl'
            ? new THREE.MeshNormalMaterial()
            : new THREE.MeshStandardMaterial({
                vertexColors: THREE.VertexColors,
                flatShading: true
            });
        const controls = new OrbitControls(camera, renderer.domElement, {
            enableRotate: true
        });
        controls.enableDamping = true;
        var filesLoaded = 0;
        var element = document.getElementById("progress-wrapper");
        var loadingBar = document.getElementById("loading-bar");
        // Scope step buttons to the primary viewer only (avoid optional buttons).
        const buttons = document.querySelectorAll('#hide-on-paste .step-control');

        var totalFiles = 2;
        var percentage = (100 / totalFiles);
        var currentProgress = 0;

        THREE.Cache.enabled = true;

        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
        scene.add(ambientLight);

        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(1, 1, 1).normalize();
        scene.add(directionalLight);

        const loader = primaryExt === 'stl' ? new STLLoader() : new PLYLoader();

        loader.load('<?php echo $upper_arch_stl; ?>',
            function(geometry) {
                if (primaryExt === 'ply') geometry.computeVertexNormals();
                const mesh = new THREE.Mesh(geometry, material)
                mesh.name = 'maxillary';
                mesh.tag = 'base';
                scene.add(mesh);
                filesLoaded++;
                currentProgress += percentage;
                loadingBar.style.width = currentProgress + '%';
                loadingBar.textContent = Math.floor(currentProgress) + '%';
            },
            (xhr) => {
            },
            (error) => {
                console.log(error)
            })
        loader.load('<?php echo $lower_arch_stl; ?>',
            function(geometry) {
                if (primaryExt === 'ply') geometry.computeVertexNormals();
                const mesh = new THREE.Mesh(geometry, material)
                mesh.name = 'mandibular';
                mesh.tag = 'base'
                scene.add(mesh);
                filesLoaded++;
                currentProgress += percentage;
                loadingBar.style.width = currentProgress + '%' + ' modules loaded';
                loadingBar.textContent = Math.floor(currentProgress) + '%';
            },
            (xhr) => {
            },
            (error) => {
                console.log(error)
            });
            camera.position.z = 10;
            camera.position.x = 0;
            camera.position.y = -6;
            scene.scale.set(0.02, 0.02, 0.02);
            controls.update();
            // Scope model-controls to the primary viewer only (avoid optional controls).
            const divs = document.querySelectorAll('#hide-on-paste .model-control');
            divs.forEach(el => el.addEventListener('click', event => {
                console.log(event.target.getAttribute("id"));
                const objectid = event.target.getAttribute("id");
                const visible = event.target.getAttribute("data-visible");
                const camera_z = event.target.getAttribute("data-cameraz");
                const camera_x = event.target.getAttribute("data-camerax");
                jQuery('.current-view').text(camera_z + ',' + camera_x + ',' + objectid);
                scene.traverse(function(object) {
                    console.log(object);
                    if (object.visible === true && object.type === "Mesh") {
                        document.getElementById('current-module').textContent = object.tag;
                    }
                    if (visible === '1') {
                        if (object.tag === document.getElementById('current-module').textContent && object
                            .type === "Mesh") {
                            object.visible = true;
                            camera.position.z = camera_z;
                            camera.position.x = camera_x;
                            camera.position.y = 0;
                        }
                        if (object.tag === document.getElementById('current-module').textContent && object
                            .type === "Mesh" && object.visible == false) {
                            // alert(object.tag+' hidden');
                            object.visible = true;
                            camera.position.z = camera_z;
                            camera.position.x = camera_x;
                            camera.position.y = 0;
                        }
                    } else {
                        if (objectid != object.name && object.type == 'Mesh' && object.tag == document
                            .getElementById('current-module').textContent) {
                            object.visible = false;
                            console.log(object);
                        }
                        if (objectid == object.name && object.type == 'Mesh' && object.tag == document
                            .getElementById('current-module').textContent) {
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
                    function(geometry) {
                        const mesh = new THREE.Mesh(geometry, material)
                        mesh.name = 'maxillary';
                        mesh.visible = false;
                        mesh.tag = buttons[i].getAttribute("id");
                        scene.add(mesh);
                        filesLoaded++;
                        currentProgress += percentage;
                        loadingBar.style.width = currentProgress + '%';
                        loadingBar.textContent = Math.floor(currentProgress) + '%' + ' modules loaded';
                        console.log('scene updated');
                        console.log(scene);
                        if (currentProgress > 95) {
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
                    function(geometry) {
                        const mesh = new THREE.Mesh(geometry, material)
                        mesh.name = 'mandibular';
                        mesh.visible = false;
                        mesh.tag = buttons[i].getAttribute("id");
                        scene.add(mesh);
                        filesLoaded++;
                        currentProgress += percentage;
                        loadingBar.style.width = currentProgress + '%';
                        loadingBar.textContent = Math.floor(currentProgress) + '%' + ' modules loaded';
                        console.log('scene updated');
                        console.log(scene);
                        if (currentProgress > 95) {
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

        function onDocumentMouseMove(event) {
            quaternion.setFromAxisAngle(new THREE.Vector3(1, 0, 0), event.clientX * Math.PI / 360);
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
            if (jQuery('.current-view').text().length > 0) {
                // camera.position.y = -6;
                var info = jQuery('.current-view').text().split(',');
                if (info[0] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular') {
                    camera.position.z = info[0];
                } else {
                    camera.position.z = 0;
                }
                if (info[1] !== 'null' && info[2] !== 'maxillary' && info[2] !== 'mandibular') {
                    camera.position.x = info[1];
                } else {
                    // camera.position.x = 0;
                }
                if (info[2] === 'maxillary') {
                    var objectname = 'maxillary';
                } else if (info[2] === 'mandibular') {
                    var objectname = 'mandibular';
                }


            } else {
                camera.position.y = 0;
            }


            scene.traverse(function(object) {
                if (object.visible === true && object.type === "Mesh") {
                    document.getElementById('current-module').textContent = objectid;
                }
                if (object.type == 'Mesh' && object.tag == objectid) {
                    object.visible = true;
                }
                if (object.type == 'Mesh' && object.tag !== objectid) {
                    object.visible = false;
                }
                if (objectname) {
                    if (objectname === 'maxillary' && object.name === 'mandibular') {
                        object.visible = false;
                    }
                    if (objectname === 'mandibular' && object.name === 'maxillary') {
                        object.visible = false;
                    }

                    if (objectname === 'mandibular' && object.name === 'mandibular' && object.tag ==
                        document.getElementById('current-module').textContent) {
                        object.visible = true;
                    }
                    if (objectname === 'maxillary' && object.name === 'maxillary' && object.tag ==
                        document.getElementById('current-module').textContent) {
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
                setTimeout(function() {

                    // jQuery('label.step-trigger:nth-child('+i+')').addClass('active');
                    const camera_z = button.getAttribute("data-cameraz");
                    const camera_x = button.getAttribute("data-camerax");
                    const objectid = button.getAttribute("id");
                    console.log(camera_z + ',' + camera_x + ',' + objectid);
                    camera.position.z = camera_z;
                    camera.position.x = camera_x;
                    if (jQuery('.current-view').text().length > 0) {
                        // camera.position.y = -6;
                        var info = jQuery('.current-view').text().split(',');
                        if (info[0] !== 'null' && info[2] !== 'maxillary' && info[2] !==
                            'mandibular') {
                            camera.position.z = info[0];
                        } else {
                            camera.position.z = 0;
                        }
                        if (info[1] !== 'null' && info[2] !== 'maxillary' && info[2] !==
                            'mandibular') {
                            camera.position.x = info[1];
                        } else {
                            // camera.position.x = 0;
                        }
                        if (info[2] === 'maxillary') {
                            var objectname = 'maxillary';
                        } else if (info[2] === 'mandibular') {
                            var objectname = 'mandibular';
                        }


                    } else {
                        camera.position.y = 0;
                    }
                    scene.traverse(function(object) {
                        if (object.visible === true && object.type === "Mesh") {
                            document.getElementById('current-module').textContent =
                            objectid;
                        }
                        if (object.type == 'Mesh' && object.tag == objectid) {
                            object.visible = true;
                        }
                        if (object.type == 'Mesh' && object.tag !== objectid) {
                            object.visible = false;
                        }
                        if (objectname) {
                            if (objectname === 'maxillary' && object.name ===
                                'mandibular') {
                                object.visible = false;
                            }
                            if (objectname === 'mandibular' && object.name ===
                                'maxillary') {
                                object.visible = false;
                            }

                            if (objectname === 'mandibular' && object.name ===
                                'mandibular' && object.tag == document.getElementById(
                                    'current-module').textContent) {
                                object.visible = true;
                            }
                            if (objectname === 'maxillary' && object.name === 'maxillary' &&
                                object.tag == document.getElementById('current-module')
                                .textContent) {
                                object.visible = true;
                            }
                        }
                    });
                    // jQuery('label.step-trigger:nth-child('+i+')').removeClass('active');
                    if (i === buttons.length) {
                        i = 0;
                    }
                }, 500 * i);
                i++;
            });

        });

        function animate() {
            requestAnimationFrame(animate);
            container.appendChild(renderer.domElement);
            controls.update();
            renderer.render(scene, camera);

        };
        export const ZoomBar = () => {
            return (
                '<div className="zoom-wrapper"><div className="zoom-bar"><div className="button" id="zoom-out">-</div><div className="button" id="zoom-in">+</div></div></div>');
        };
        animate();

        function initOptionalViewer() {
            const enabled = "{{ $optionalViewerEnabled ? '1' : '0' }}" === '1';
            if (!enabled) return;

            const containerOptional = document.getElementById('canvas_optional');
            if (!containerOptional) return;

            const optionalExt = "{{ $optionalExt }}";
            const upperUrlOptional = "{{ $optional_upper_arch_stl_global }}";
            const lowerUrlOptional = "{{ $optional_lower_arch_stl_global }}";

            const sceneOptional = new THREE.Scene();
            sceneOptional.name = 'optional_myscene';
            sceneOptional.background = new THREE.Color(0xaaaaaa);

            const cameraOptional = new THREE.PerspectiveCamera(10, 1420 / 764, 0.1, 1000);
            const rendererOptional = new THREE.WebGLRenderer({ antialias: true });

            const materialOptional = optionalExt === 'stl'
                ? new THREE.MeshNormalMaterial()
                : new THREE.MeshStandardMaterial({ vertexColors: THREE.VertexColors, flatShading: true });

            const controlsOptional = new OrbitControls(cameraOptional, rendererOptional.domElement, { enableRotate: true });
            controlsOptional.enableDamping = true;

            const buttonsOptional = document.querySelectorAll('#hide-on-paste-optional .step-control');
            const modelControlsOptional = document.querySelectorAll('#hide-on-paste-optional .model-control');
            const loadingBarOptional = document.getElementById("loading-bar-optional");

            const totalLoads = 2 + (buttonsOptional.length * 2);
            const percentage = totalLoads > 0 ? (100 / totalLoads) : 0;
            let currentProgressOptional = 0;

            rendererOptional.setSize(window.innerWidth, window.innerHeight);
            document.body.appendChild(rendererOptional.domElement);

            sceneOptional.add(new THREE.AmbientLight(0xffffff, 0.5));
            const dirLight = new THREE.DirectionalLight(0xffffff, 1);
            dirLight.position.set(1, 1, 1).normalize();
            sceneOptional.add(dirLight);

            const loaderOptional = optionalExt === 'stl' ? new STLLoader() : new PLYLoader();

            loaderOptional.load(upperUrlOptional, function(geometry) {
                if (optionalExt === 'ply') geometry.computeVertexNormals();
                const mesh = new THREE.Mesh(geometry, materialOptional);
                mesh.name = 'maxillary';
                mesh.tag = 'base';
                sceneOptional.add(mesh);
                currentProgressOptional += percentage;
                if (loadingBarOptional) {
                    loadingBarOptional.style.width = currentProgressOptional + '%';
                    loadingBarOptional.textContent = Math.floor(currentProgressOptional) + '%';
                }
            });

            loaderOptional.load(lowerUrlOptional, function(geometry) {
                if (optionalExt === 'ply') geometry.computeVertexNormals();
                const mesh = new THREE.Mesh(geometry, materialOptional);
                mesh.name = 'mandibular';
                mesh.tag = 'base';
                sceneOptional.add(mesh);
                currentProgressOptional += percentage;
                if (loadingBarOptional) {
                    loadingBarOptional.style.width = currentProgressOptional + '%';
                    loadingBarOptional.textContent = Math.floor(currentProgressOptional) + '%';
                }
            });

            cameraOptional.position.z = 10;
            cameraOptional.position.x = 0;
            cameraOptional.position.y = -6;
            sceneOptional.scale.set(0.02, 0.02, 0.02);
            controlsOptional.update();

            modelControlsOptional.forEach(el => el.addEventListener('click', event => {
                let objectid = event.target.getAttribute("id");
                const visible = event.target.getAttribute("data-visible");
                const camera_z = event.target.getAttribute("data-cameraz");
                const camera_x = event.target.getAttribute("data-camerax");

                if (objectid === 'maxillary_optional') objectid = 'maxillary';
                if (objectid === 'mandibular_optional') objectid = 'mandibular';

                jQuery('.current-view').text(camera_z + ',' + camera_x + ',' + objectid);
                sceneOptional.traverse(function(object) {
                    if (object.visible === true && object.type === "Mesh") {
                        document.getElementById('current-module').textContent = object.tag;
                    }
                    if (visible === '1') {
                        if (object.tag === document.getElementById('current-module').textContent && object.type === "Mesh") {
                            object.visible = true;
                            cameraOptional.position.z = camera_z;
                            cameraOptional.position.x = camera_x;
                            cameraOptional.position.y = 0;
                        }
                    } else {
                        if (objectid != object.name && object.type == 'Mesh' && object.tag == document.getElementById('current-module').textContent) {
                            object.visible = false;
                        }
                        if (objectid == object.name && object.type == 'Mesh' && object.tag == document.getElementById('current-module').textContent) {
                            object.visible = true;
                            cameraOptional.position.z = 0;
                            cameraOptional.position.x = 0;
                            cameraOptional.position.y = camera_x;
                        }
                    }
                });
            }));

            for (let i = 0; i < buttonsOptional.length; i++) {
                loaderOptional.load(buttonsOptional[i].getAttribute("data-maxillary"), function(geometry) {
                    const mesh = new THREE.Mesh(geometry, materialOptional);
                    mesh.name = 'maxillary';
                    mesh.visible = false;
                    mesh.tag = buttonsOptional[i].getAttribute("id");
                    sceneOptional.add(mesh);
                    currentProgressOptional += percentage;
                    if (loadingBarOptional) {
                        loadingBarOptional.style.width = currentProgressOptional + '%';
                        loadingBarOptional.textContent = Math.floor(currentProgressOptional) + '%';
                    }
                    if (loadingBarOptional && currentProgressOptional > 95) jQuery('#progress-wrapper-optional').remove();
                });

                loaderOptional.load(buttonsOptional[i].getAttribute("data-mandibular"), function(geometry) {
                    const mesh = new THREE.Mesh(geometry, materialOptional);
                    mesh.name = 'mandibular';
                    mesh.visible = false;
                    mesh.tag = buttonsOptional[i].getAttribute("id");
                    sceneOptional.add(mesh);
                    currentProgressOptional += percentage;
                    if (loadingBarOptional) {
                        loadingBarOptional.style.width = currentProgressOptional + '%';
                        loadingBarOptional.textContent = Math.floor(currentProgressOptional) + '%';
                    }
                    if (loadingBarOptional && currentProgressOptional > 95) jQuery('#progress-wrapper-optional').remove();
                });
            }

            const sliderOptional = document.getElementById('slider_optional');
            const quaternionOptional = new THREE.Quaternion();
            function onMouseMoveOptional(event) {
                quaternionOptional.setFromAxisAngle(new THREE.Vector3(1, 0, 0), event.clientX * Math.PI / 360);
                sceneOptional.children.forEach(function(mesh) {
                    mesh.rotation.setFromQuaternion(quaternionOptional);
                });
            }
            if (sliderOptional) {
                sliderOptional.addEventListener('mousedown', function() {
                    sliderOptional.addEventListener('mousemove', onMouseMoveOptional);
                    sliderOptional.addEventListener('mouseout', function() {
                        sliderOptional.removeEventListener('mousemove', onMouseMoveOptional);
                    });
                });
                document.addEventListener('mouseup', function() {
                    sliderOptional.removeEventListener('mousemove', onMouseMoveOptional);
                });
            }

            const playBtnOptional = document.getElementById('play-button-optional');
            if (playBtnOptional) {
                playBtnOptional.addEventListener('click', () => {
                    let i = 0;
                    buttonsOptional.forEach((button) => {
                        setTimeout(function() {
                            const camera_z = button.getAttribute("data-cameraz");
                            const camera_x = button.getAttribute("data-camerax");
                            const objectid = button.getAttribute("id");
                            cameraOptional.position.z = camera_z;
                            cameraOptional.position.x = camera_x;

                            sceneOptional.traverse(function(object) {
                                if (object.visible === true && object.type === "Mesh") {
                                    document.getElementById('current-module').textContent = objectid;
                                }
                                if (object.type == 'Mesh' && object.tag == objectid) object.visible = true;
                                if (object.type == 'Mesh' && object.tag !== objectid) object.visible = false;
                            });
                            if (i === buttonsOptional.length) i = 0;
                            i++;
                        }, 500 * i);
                    });
                });
            }

            function animateOptional() {
                requestAnimationFrame(animateOptional);
                containerOptional.appendChild(rendererOptional.domElement);
                controlsOptional.update();
                rendererOptional.render(sceneOptional, cameraOptional);
            }
            animateOptional();

            jQuery(document).ready(function() {
                jQuery('#customRange2_optional').on('input', function() {
                    const currentStep = parseInt(jQuery(this).val()) + 1;
                    jQuery('.step-trigger[for="step-optional-' + currentStep + '"]').click();
                });
            });
        }

        jQuery(document).ready(function() {
            jQuery('#customRange2').on('input', function() {
                var currentStep = parseInt(jQuery(this).val()) + 1
                jQuery('.step-trigger[for="step-' + currentStep + '"]').click();
            });
            initOptionalViewer();
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
        jQuery('form:not(#acf-form)').on('submit', function(event) {
            if (somethingChanged) {
                if (confirm("You have unsaved notes. Do you want to proceed?")) {
                    //nothin
                } else {
                    // do something else
                    jQuery('html, body').animate({
                        scrollTop: jQuery("#notes").offset().top
                    }, 2000);
                    jQuery('#submit_data').css('background-color', 'red');
                    return false;
                }
            }
        });
        $(document).ready(function() {
            // When an advisor is selected
            $("#advisor").on("change", function() {
                if ($(this).val() !== "") {
                    $("#additionalDivs").removeClass("d-none");
                    $("#consultant_agreement").attr("required", true); // Make checkbox required
                } else {
                    $("#additionalDivs").addClass("d-none");
                    $("#consultant_agreement").removeAttr(
                    "required"); // Remove required if no advisor is selected
                }
            });
            $("#advisor2").on("change", function() {
                if ($(this).val() !== "") {
                    $("#additionalDivs").removeClass("d-none");
                    $("#consultant_agreement").attr("required", true); // Make checkbox required
                } else {
                    $("#additionalDivs").addClass("d-none");
                    $("#consultant_agreement").removeAttr(
                    "required"); // Remove required if no advisor is selected
                }
            });

            $(document).on("click", "#doctor-advisor-submit-btn", function(e) {
                e.preventDefault(); // Prevent form submission before validation

                // Check if terms and conditions are accepted
                if ($("input[name=terms_and_conditions]").is(":checked")) {
                    const advisor = $("#advisor2").val();
                    const comment = $("#comment_advisor").val(); // Get advisor selection
                    const consultantAgreementChecked = $("#consultant_agreement").is(":checked");

                    // Validate consultant agreement checkbox if advisor is selected
                    if (advisor && !consultantAgreementChecked) {
                        toastError("You must agree to the additional consultation terms.");
                        return;
                    }

                    // Append hidden inputs to the form
                    $("#sendToAdvisor").find("input[name=advisor]").remove(); // Ensure no duplicates
                    $("#sendToAdvisor").find("input[name=comment]").remove(); // Ensure no duplicates

                    $("#sendToAdvisor").append(`<input type="hidden" name="advisor" value="${advisor}" />`);
                    $("#sendToAdvisor").append(`<input type="hidden" name="comment" value="${comment}" />`);

                    // Submit the form after inputs are appended
                    $("#sendToAdvisor").submit();
                } else {
                    toastError("You must accept the terms and conditions.");
                }
            });

        });
    </script>
@endif

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const inputField = document.getElementById('iframe_link');

        if (inputField) {
            inputField.addEventListener('input', function() {
                const newLink = inputField.value;
                let iframeContainer = document.getElementById('iframe-container');
                let canvas = document.getElementById('hide-on-paste');
                if (canvas) {
                    canvas.remove();
                }


                if (!iframeContainer) {
                    iframeContainer = document.createElement('div');
                    iframeContainer.id = 'iframe-container';
                    iframeContainer.innerHTML = `
                    <iframe src="${newLink}" width="100%" height="700" style="min-height: 700px;"></iframe>
                `;
                    document.getElementById('card-body-for-iframe').appendChild(iframeContainer);
                } else {
                    iframeContainer.querySelector('iframe').src = newLink;
                }
            });
        }
    });

    function copyToClipboard() {
        // Get the input element
        const inputField = document.getElementById('patientLinkInput');

        // Create a temporary input to hold the value (disabled fields cannot be selected)
        const tempInput = document.createElement('input');
        tempInput.value = inputField.value;
        document.body.appendChild(tempInput);

        // Select the temporary input value
        tempInput.select();
        tempInput.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text to clipboard
        document.execCommand('copy');

        // Remove the temporary input
        document.body.removeChild(tempInput);

        // Optional: Show a toast or alert
        alert('Copied to clipboard!');
    }

    document.querySelectorAll('.download-multi').forEach(btn => {
        btn.addEventListener('click', () => {
            const files = JSON.parse(btn.dataset.files || '[]');
            $('.my-loader').show();
            let chain = Promise.resolve();

            files.forEach((url, index) => {
                if (!url) return;

                chain = chain.then(() => {
                    return new Promise(resolve => {
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = ''; // trigger download
                        a.target = ''; // needed for Drive
                        document.body.appendChild(a);
                        a.click();
                        a.remove();

                        // wait 1-2s before next file
                        setTimeout(resolve, 4000);
                    });
                });
            });

            chain.then(() => $('.my-loader').hide());
        });
    });

</script>
