
<?php
    use Illuminate\Support\Facades\DB;
    $upper_arch_stl = asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_arch);
    $lower_arch_stl = asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_arch);
?>

<?php
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
?>
<?php echo $__env->make('patients.case-overview.case_overview_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('patients.case-overview.card_body_for_iframe', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="row gx-2">
    <?php echo $__env->make('patients.case-overview.card_body_for_iframe_right', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->make('patients.case-overview.card_body_for_iframe_left', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>



<div class="modal fade" id="docSendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="<?php echo e(route('patient.alert')); ?>" id="patientAlert">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Treatment Plan to Patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="patient_id" value="<?php echo e($patient->patient_id); ?>">
                    <input type="hidden" name="patient_link" value="<?php echo e($patient->patient_link ?? ''); ?>" class="form-control">

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

<?php if(@$_GET['i'] == 'true'): ?>
    <script type="module">
        import {
            STLLoader
        } from "<?php echo e(asset('public/assets/three/examples/jsm/loaders/STLLoader.js')); ?>";
        import {
            PLYLoader
        } from "<?php echo e(asset('public/assets/three/examples/jsm/loaders/PLYLoader.js')); ?>";
        import {
            OrbitControls
        } from '<?php echo e(asset('public/assets/three/examples/jsm/controls/OrbitControls.js')); ?>';

        const container = document.getElementById('canvas');
        const scene = new THREE.Scene();
        scene.name = 'myscene';
        scene.background = new THREE.Color(0xaaaaaa);
        const camera = new THREE.PerspectiveCamera(10, 1420 / 764, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({
            antialias: true
        });
        <?php if(@$patient->fl_upper_arch): ?>
            <?php if(explode('.', @$patient->fl_upper_arch)[1] == 'stl'): ?>
                const material = new THREE.MeshNormalMaterial();
            <?php else: ?>
                const material = new THREE.MeshStandardMaterial({
                    vertexColors: THREE.VertexColors,
                    flatShading: true
                });
            <?php endif; ?>
        <?php endif; ?>
        const controls = new OrbitControls(camera, renderer.domElement, {
            enableRotate: true
        });
        controls.enableDamping = true;
        var filesLoaded = 0;
        var element = document.getElementById("progress-wrapper");
        var loadingBar = document.getElementById("loading-bar");
        const buttons = document.querySelectorAll('.step-control');

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

        <?php if(@$patient->fl_upper_arch): ?>
            <?php if(explode('.', @$patient->fl_upper_arch)[1] == 'stl'): ?>
                const loader = new STLLoader()
            <?php else: ?>
                const loader = new PLYLoader()
            <?php endif; ?>
        <?php endif; ?>

        loader.load('<?php echo $upper_arch_stl; ?>',
            function(geometry) {
                <?php if(@$patient->fl_upper_arch): ?>
                    <?php if(explode('.', @$patient->fl_upper_arch)[1] == 'ply'): ?>
                        geometry.computeVertexNormals();
                    <?php endif; ?>
                <?php endif; ?>
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
                <?php if(@$patient->fl_upper_arch): ?>
                    <?php if(explode('.', @$patient->fl_upper_arch)[1] == 'ply'): ?>
                        geometry.computeVertexNormals();
                    <?php endif; ?>
                <?php endif; ?>
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
            const divs = document.querySelectorAll('.model-control');
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
        jQuery(document).ready(function() {
            jQuery('#customRange2').on('input', function() {
                var currentStep = parseInt(jQuery(this).val()) + 1
                jQuery('.step-trigger[for="step-' + currentStep + '"]').click();
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
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const inputField = document.getElementById('patient-iframe');
        
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
<script type="text/javascript">     
    function authenticate(auth, url) {       
        var iframe = document.getElementById('nemoPortal');       
        iframe.contentWindow.postMessage(auth, url);     
    }     
    window.onmessage = function (event) {       
        console.log(event.data);     
    }   
</script>
<script>
    function syncNemoLink(selectEl) {
        const option = selectEl.value.trim();
        selectEl.classList.remove('dropdown-error');
    
        if (!option) {
            selectEl.classList.add('dropdown-error');
            return;
        }
        const url = "<?php echo e(route('patient.nemo.link', $hashids->encode($patient->patient_id))); ?>";
        window.location.href = `${url}?type=${option}`;
    }
</script>
<?php /**PATH /home/u531876341/domains/secretalign-user.com/public_html/resources/views/patients/case_overview_el.blade.php ENDPATH**/ ?>