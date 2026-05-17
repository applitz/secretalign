<div class="row gx-2">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-body py-4" id="card-body-for-iframe">

                <p><strong>Name:</strong> {{ $patient->first_name . ' ' . $patient->last_name }}</p>
                <p><strong>Date of Birth:</strong> {{ $patient->dob }}</p>
                <p><strong>Treatment Type :</strong> {{ $patient->treatment_type == 1 ? 'Treatment Plan Service' : 'Aligners Full-Service' }}</p>
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
                        @if($patient->primary_movix_link != null)
                            <iframe src="{{ $patient->primary_movix_link }}" width="100%" height="700" style="min-height: 700px;"></iframe>
                        @else
                            @if ($patient->fl_upper_arch && $patient->fl_lower_arch && $patient->is_treatment_submitted == 0 )
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
                        @endif
                    </div>
                    @if ($hasOptionalScans)
                        <div class="col-md-6">
                            <h6 class="mb-2">Optional Scan</h6>
                            @if($patient->optional_scan_movix_link != null)
                                <iframe src="{{ $patient->optional_scan_movix_link }}" width="100%" height="700" style="min-height: 700px;"></iframe>
                            @else
                                @if ($patient->is_treatment_submitted == 0 )
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


                                                <div id="canvas_optional" class="canvas-bg"></div>


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
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if ($hasOptionalScans && $patient->is_treatment_submitted == 0 )
    <script type="module">
        import {
            STLLoader
        } from "{{ asset('public/assets/three/examples/jsm/loaders/STLLoader.js') }}";
        import {
            PLYLoader
        } from "{{ asset('public/assets/three/examples/jsm/loaders/PLYLoader.js') }}";
        import {
            OrbitControls
        } from '{{ asset('public/assets/three/examples/jsm/controls/OrbitControls.js') }}';

        // Optional scan viewer: completely separate from primary scan
        (function initOptionalViewer() {
            const containerOptional = document.getElementById('canvas_optional');
            if (!containerOptional) return;

            const optionalExt = "{{ pathinfo($patient->optional_fl_upper_arch, PATHINFO_EXTENSION) }}";
            const upperUrlOptional = "<?php echo $optional_upper_arch_stl; ?>";
            const lowerUrlOptional = "<?php echo $optional_lower_arch_stl; ?>";

            const sceneOptional = new THREE.Scene();
            sceneOptional.name = 'optional_myscene';
            sceneOptional.background = new THREE.Color(0xaaaaaa);

            const cameraOptional = new THREE.PerspectiveCamera(10, 1420 / 764, 0.1, 1000);
            const rendererOptional = new THREE.WebGLRenderer({
                antialias: true
            });

            const materialOptional = optionalExt === 'stl'
                ? new THREE.MeshNormalMaterial()
                : new THREE.MeshStandardMaterial({
                    vertexColors: THREE.VertexColors,
                    flatShading: true
                });

            const controlsOptional = new OrbitControls(cameraOptional, rendererOptional.domElement, {
                enableRotate: true
            });
            controlsOptional.enableDamping = true;

            const buttonsOptional = document.querySelectorAll('#hide-on-paste-optional .step-control');
            const modelControlsOptional = document.querySelectorAll('#hide-on-paste-optional .model-control');
            const loadingBarOptional = document.getElementById("loading-bar-optional");

            const totalLoads = 2 + (buttonsOptional.length * 2);
            const percentage = totalLoads > 0 ? (100 / totalLoads) : 0;
            let currentProgressOptional = 0;

            const getOptionalSize = () => {
                const width = containerOptional.clientWidth || window.innerWidth;
                const height = containerOptional.clientHeight || window.innerHeight;
                return {
                    width,
                    height
                };
            };

            const {
                width: optWidth,
                height: optHeight
            } = getOptionalSize();
            rendererOptional.setSize(optWidth, optHeight);
            containerOptional.appendChild(rendererOptional.domElement);

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
                controlsOptional.update();
                rendererOptional.render(sceneOptional, cameraOptional);
            }
            animateOptional();

            jQuery(function() {
                jQuery('#customRange2_optional').on('input', function() {
                    const currentStep = parseInt(jQuery(this).val()) + 1;
                    jQuery('.step-trigger[for="step-optional-' + currentStep + '"]').click();
                });
            });
        })();
    </script>
@endif
