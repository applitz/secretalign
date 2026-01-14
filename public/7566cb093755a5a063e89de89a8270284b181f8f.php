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
                                <?php if($patient->fl_upper_arch): ?>
                                    <a href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_arch)); ?>"
                                        target="_blank" class="btn btn-link btn-sm ps-0 mt-2">Upper Arch <i
                                            class="fas fa-angle-right"></i></a>
                                <?php endif; ?>
                                <?php if($patient->fl_upper_arch): ?>
                                    <a href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_arch)); ?>"
                                        target="_blank" class="btn btn-link btn-sm ps-0 mt-2">Lower Arch <i
                                            class="fas fa-angle-right"></i></a>
                                <?php endif; ?>
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
                                    <?php if($patient->fl_frontal): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Frontal"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_frontal)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_frontal)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Frontal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Frontal</h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_upper_occlusal): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Upper Occlusal"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_occlusal)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_upper_occlusal)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Upper Occlusal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Upper Occlusal</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_lower_occlusal): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Lower Occlusal"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_occlusal)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lower_occlusal)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Lower Occlusal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Lower Occlusal</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_right_buccal): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Right Buccal"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_right_buccal)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_right_buccal)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Right Buccal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Right Buccal</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_left_buccal): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Left Buccal"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_left_buccal)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_left_buccal)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Left Buccal" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Left Buccal</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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
                                    <?php if($patient->fl_front): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Front"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_front)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_front)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Front" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Front</h5>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_profile): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Profile"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_profile)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_profile)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Profile" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Profile</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_smile): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Smile"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_smile)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_smile)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Smile" /> </a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Smile</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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
                                    <?php if($patient->fl_panorex): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_panorex)); ?>"
                                                        data-gallery="gallery-1" data-lightbox="gallery-1"
                                                        data-title="Panorex"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_panorex)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Panorex" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Panorex</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_lateral_ceph): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                        data-title="Lateral Ceph"
                                                        href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lateral_ceph)); ?>"
                                                        data-gallery="gallery-1"><img style="width: 100%;"
                                                            class="img-fluid"
                                                            src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_lateral_ceph)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                            alt="Lateral Ceph" /></a>
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title">Lateral Ceph</h5>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if($patient->fl_general_upload): ?>
                                        <div class="col-xl-4 mb-3">
                                            <div class="card overflow-hidden" style="padding: 1.5rem !important;">
                                                <?php if(pathinfo($patient->fl_general_upload, PATHINFO_EXTENSION) != 'pdf'): ?>
                                                    <div class="card-img-top text-center"><a data-lightbox="gallery-1"
                                                            data-title="General Upload"
                                                            href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload)); ?>"
                                                            data-gallery="gallery-1"><img style="width: 100%;"
                                                                class="img-fluid"
                                                                src="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload)); ?>?v=<?php echo e(rand(0, 1000)); ?>"
                                                                alt="General Upload" /></a>
                                                    </div>
                                                <?php else: ?>
                                                    <p class="mb-0 ps-3"><a
                                                            href="<?php echo e(asset('/storage/PatientFiles/Patient' . $patient->patient_id . '/' . $patient->fl_general_upload)); ?>"
                                                            download="">Download</a>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(@$patient->fl_general_upload_drive_link): ?>
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
                                            <?php if(@$patient->fl_general_upload_drive_link): ?>
                                                <div class="container-fluid mt-3">
                                                    <p class="fw-bold">Please click the link below to view the
                                                        uploaded drive link</p>
                                                    <a href="<?php echo e($patient->fl_general_upload_drive_link); ?>"
                                                        class="btn btn-link btn-sm ps-0 mt-2" target="_blank">Uploaded
                                                        Link <i class="fas fa-angle-right"></i></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(@$patient->iframe_link && $patient->is_treatment_submitted == 1): ?>
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
                                            <?php if(@$patient->treatment_link): ?>
                                                <div class="container-fluid mt-3">
                                                    <p class="fw-bold">Please click the link below to view the treatment plan</p>
                                                    <?php if($role && $role == 'staff'): ?>
                                                        <?php if(!$treatmentCheck): ?>
                                                        <a href="<?php echo e($patient->treatment_link); ?>"
                                                            class="btn btn-link btn-sm ps-0 mt-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#treatmentModal"
                                                            onclick="window.open(this.href, '_blank');">
                                                            Treatment Plan <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <?php else: ?>
                                                        <a href="<?php echo e($patient->treatment_link); ?>"
                                                            class="btn btn-link btn-sm ps-0 mt-2"
                                                            target="_blank">
                                                            Treatment Plan <i class="fas fa-angle-right"></i>
                                                        </a>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <a href="<?php echo e($patient->treatment_link); ?>"
                                                            class="btn btn-link btn-sm ps-0 mt-2"
                                                            target="_blank">
                                                            Treatment Plan <i class="fas fa-angle-right"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php if(@$patient->treatment_link && !empty($stl_files)): ?>
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
                                                <?php if(@$patient->treatment_link && !empty($stl_files)): ?>
                                                    <div class="d-flex flex-wrap gap-2 justify-content-start">
                                                        <?php
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

                                                        ?>

                                                        <?php $__currentLoopData = $groupedSteps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $step => $sides): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="mt-3 d-flex gap-2 flex-wrap align-items-center pt-2">

                                                                
                                                                <?php if(isset($sides['U'])): ?>
                                                                    <?php $u = $sides['U']; ?>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-primary download-multi"
                                                                            data-files='<?php echo json_encode(array_filter([
                                                                                $u["stl"]->webContentLink ?? null, $u["pts"]->webContentLink ?? null
                                                                            ]), 512) ?>'
                                                                            title="U<?php echo e($step); ?>">
                                                                        <strong>U<?php echo e($step); ?></strong>
                                                                    </button>
                                                                <?php endif; ?>

                                                                
                                                                <?php if(isset($sides['L'])): ?>
                                                                    <?php $l = $sides['L']; ?>
                                                                    <button type="button"
                                                                            class="btn btn-sm btn-success download-multi"
                                                                            style="background-color: #80C6C7"
                                                                            data-files='<?php echo json_encode(array_filter([
                                                                                $l["stl"]->webContentLink ?? null, $l["pts"]->webContentLink ?? null
                                                                            ]), 512) ?>'
                                                                            title="L<?php echo e($step); ?>">
                                                                        <strong>L<?php echo e($step); ?></strong>
                                                                    </button>
                                                                <?php endif; ?>

                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        <?php if(!empty($retGroup)): ?>
                                                            <div class="mt-3 d-flex gap-2 flex-wrap align-items-center pt-2">
                                                                
                                                                <?php if(isset($retGroup['U'])): ?>
                                                                    <?php $u = $retGroup['U']; ?>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-primary download-multi"
                                                                        data-files='<?php echo json_encode(array_filter([
                                                                            $u["stl"]->webContentLink ?? null, $u["pts"]->webContentLink ?? null
                                                                        ]), 512) ?>'
                                                                        title="RU">
                                                                        <strong>RU</strong>
                                                                    </button>
                                                                <?php endif; ?>

                                                                
                                                                <?php if(isset($retGroup['L'])): ?>
                                                                    <?php $l = $retGroup['L']; ?>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-success download-multi"
                                                                        style="background-color: #80C6C7"
                                                                        data-files='<?php echo json_encode(array_filter([
                                                                            $l["stl"]->webContentLink ?? null, $l["pts"]->webContentLink ?? null
                                                                        ]), 512) ?>'
                                                                        title="RL">
                                                                        <strong>RL</strong>
                                                                    </button>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php echo csrf_field(); ?>
                                                        

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<!----Treatment check module ----->
<div class="modal fade" id="treatmentModal" tabindex="-1" aria-labelledby="treatmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <form id="treatmentForm" method="POST" action="<?php echo e(route('treatment.check.save')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="treatmentModalLabel">KONTROLLBLATT</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="fw-bold mb-2">VOR DRUCK</h6>
                    <div class="row gy-2">
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>1. Attachements am Modell?</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="attachments_model"  <?php echo e(isset($treatmentCheck) && $treatmentCheck->attachments_model ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>2. Bars am Modell? (Mitte)</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="bars_model" <?php echo e(isset($treatmentCheck) && $treatmentCheck->bars_model ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>3. Name am Modell = Patient?</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="name_patient" <?php echo e(isset($treatmentCheck) && $treatmentCheck->name_patient ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>4. Modell passt zu SetUp am Dashboard?</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="model_dashboard" <?php echo e(isset($treatmentCheck) && $treatmentCheck->model_dashboard ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>5. CutOuts/precision Cuts & I-Hooks & Wings vorhanden?</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="cutouts_hooks" <?php echo e(isset($treatmentCheck) && $treatmentCheck->cutouts_hooks ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>6. Schnittlinie passt?</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="schnittlinie" <?php echo e(isset($treatmentCheck) && $treatmentCheck->schnittlinie ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    </div>
                    <h6 class="fw-bold mt-3 mb-2">TIEFZIEHEN & SCHNEIDEN</h6>
                    <div class="row gy-2">
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>1. Zahlen vergleichen</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="zahlen_vergleichen" <?php echo e(isset($treatmentCheck) && $treatmentCheck->zahlen_vergleichen ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>2. Cut Outs auf der Schiene?</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="cutouts_schiene" <?php echo e(isset($treatmentCheck) && $treatmentCheck->cutouts_schiene ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    </div>
                    <h6 class="fw-bold mt-3 mb-2">VOR DEM EINPACKEN</h6>
                    <div class="row gy-2">
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>1. Folie runtergenommen?</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="folie_runtergenommen" <?php echo e(isset($treatmentCheck) && $treatmentCheck->folie_runtergenommen ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>2. Richtig einpacken - Zahlen!</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="richtig_einpacken" <?php echo e(isset($treatmentCheck) && $treatmentCheck->richtig_einpacken ? 'checked' : ''); ?>>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center border-bottom pb-1">
                        <span>3. Richtiger ASR Zettel!</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="richtiger_asr" <?php echo e(isset($treatmentCheck) && $treatmentCheck->richtiger_asr ? 'checked' : ''); ?>>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <label class="fw-bold">NAME:</label>
                        <input type="text" class="form-control mt-2" name="coworker_name" placeholder="Enter coworker name" value="<?php echo e(old('coworker_name', $treatmentCheck->coworker_name ?? '')); ?>">
                        <div class="text-danger mt-1" id="coworker_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="savePreviewBtn">Save & Preview</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\xampp\htdocs\secretalign\resources\views/patients/case-overview/card_body_for_iframe_right.blade.php ENDPATH**/ ?>