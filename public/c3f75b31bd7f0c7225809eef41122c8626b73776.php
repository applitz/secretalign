
<?php if(@$_GET['i'] != 'true'): ?>
    <div class="card">
        <div class="card-body">
            <div class="row gx-0 kanban-header rounded-2 px-card py-2 ">
                <?php if(Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin' || Auth::user()->role == 'admin'): ?>
                    <?php
                        $pending_nemo_sync = DB::table('sync_queues')
                            ->where('treatment_plan_id', $patient->id)
                            ->where('is_synced', 0)
                            ->where('is_cancelled', 0)
                        ->first();
                    ?>
                    <?php if(@$pending_nemo_sync): ?>
                        <?php
                            $nemo_files_synced = 0;
                            if ($pending_nemo_sync->is_fl_upper_arch_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->is_fl_lower_arch_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_front_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_smile_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_profile_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_frontal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_right_buccal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_left_buccal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_upper_occlusal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_lower_occlusal_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_panorex_synced == 1) {
                                $nemo_files_synced++;
                            }
                            if ($pending_nemo_sync->fl_lateral_ceph_synced == 1) {
                                $nemo_files_synced++;
                            }
                        ?>
                        <div class="col d-flex align-items-center">
                            <p class="mb-0 text-info">Sync in progress (<?php echo e($nemo_files_synced); ?>/12) files synced.</p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php
                    $advisor = DB::table('users')->where('id', $patient->recommended_advisor)->first();
                ?>
                <div class="col d-flex align-items-center">

                    <?php if(Auth::user()->role == 'doctor' && $patient->status == 'Shipped'): ?>
                        <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-primary text-uppercase me-2 d-none d-md-block doctor-reminder-modal" data-bs-toggle="modal" data-bs-target="#doctor-reminder-modal">
                            <i class="fas fa-solid fa-bell fa-2x"></i>
                        </a>
                    <?php endif; ?>

                    <div class="vertical-line vertical-line-400 position-relative h-100 mx-3"></div>
                    <?php if(@$patient->is_completed == 1 && @$patient->tracking_id && Auth::user()->role != 'lab'): ?>
                        <a class="text-success" href="<?php echo e($patient->tracking_id); ?>" target="_blank">Tracking Nr.</a>
                    <?php endif; ?>
                </div>

                <div class="col-auto d-flex align-items-center">
                    <?php if(Auth::user()->role == 'superadmin'): ?>
                        <?php if(!DB::table('p_treatment_plans')->where('patient_id', $patient->patient_id)->where('phase', '>', $patient->phase)->exists()): ?>
                            <?php if($patient->phase > 1): ?>
                                <a href="javascript:void(0);"
                                    class="btn btn-sm btn-falcon-default text-danger text-uppercase me-2 d-none d-md-block "
                                    data-bs-toggle="modal" data-bs-target="#cancelPlan"><span
                                        class="fas fa-times-circle me-2"></span>Cancel Requested Plan</a>
                            <?php endif; ?>
                            <?php if($patient->is_completed == 1 && $patient->status == 'Production'): ?>
                                <a href="javascript:void(0);"
                                    class="btn btn-sm btn-falcon-default text-danger text-uppercase me-2 d-none d-md-block reopen-case"><span
                                        class="fas fa-book-open me-2"></span>Reopen the case</a>
                            <?php endif; ?>
                            <?php if($patient->status == 'Cancelled'): ?>
                                <a href="javascript:void(0);"
                                    class="btn btn-sm btn-falcon-default text-danger text-uppercase me-2 d-none d-md-block reopen-case"><span
                                        class="fas fa-book-open me-2"></span>Reopen the case</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if(Auth::user()->role == 'doctor'): ?>
                        <?php if(@$patient->is_submitted == 1 && @$patient->is_completed == 0): ?>
                            <?php if(!DB::table('p_treatment_plans')->where('patient_id', $patient->patient_id)->where('phase', '>', $patient->phase)->exists()): ?>
                                
                                <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block">
                                    <span class="fas fa-cube me-2"></span><?php echo e($patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT'); ?>

                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'): ?>
                        <?php if($patient->recommended_advisor != null && $patient->advisor_id == null): ?>
                            <?php if($patient->advisor_id == null): ?>
                                <a class="btn btn-sm btn-falcon-default text-info me-2 d-none d-md-block"
                                    data-bs-toggle="modal" data-bs-target="#advisorModal">
                                    <span class="fas fa-cube me-2"></span>SEND TO ➡ <?php echo e($advisor->first_name); ?>

                                    <?php echo e($advisor->last_name); ?> (€<?php echo e($advisor->advisor_price); ?>)
                                </a>

                                <!-- Advisor Modal Start -->
                                <div class="modal fade" id="advisorModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Send to Advisor</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="<?php echo e(url('/patient/case-overview/send-from-staff-to-advisor')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="treatment_plan_id"
                                                        value="<?php echo e($patient->id); ?>" />
                                                    <div class="row">
                                                        <div class="col-md-12 mb-3">
                                                            <label>Choose Advisor</label>
                                                            <select class="form-contorl form-select" name="advisor"
                                                                required>
                                                                <option value="<?php echo e($advisor->id); ?>" selected>
                                                                    <?php echo e($advisor->first_name); ?>

                                                                    <?php echo e($advisor->last_name); ?>

                                                                    (€<?php echo e($advisor->advisor_price); ?>)</option>
                                                                <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($item->id); ?>">
                                                                        <?php echo e($item->first_name); ?>

                                                                        <?php echo e($item->last_name); ?>

                                                                        (€<?php echo e($item->advisor_price); ?>)
                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label>Comment for Advisor</label>
                                                                <textarea class="form-control" name="comment" id="" placeholder="Write the comment here"></textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Send to Advisor</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($patient->advisor_id != null): ?>
                                <a class="btn btn-sm btn-falcon-default text-info me-2 d-none d-md-block">
                                    <span class="fas fa-cube me-2"></span>SENT TO ➡ <?php echo e($advisor->first_name); ?>

                                    <?php echo e($advisor->last_name); ?> (€<?php echo e($advisor->advisor_price); ?>)
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(Auth::user()->role == 'staff' || Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin'): ?>
                            
                        <?php endif; ?>

                        <?php if( $patient->status != 'Shipped' && (Auth::user()->role == 'admin' || Auth::user()->role == 'superadmin')): ?>
                            <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block update-package-admin" data-current="<?php echo e($patient->pricing_package); ?>">
                                <span class="fas fa-cube me-2"></span>
                                <?php echo e($patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT'); ?>

                            </a>
                        <?php else: ?>
                            <a href="javascript:void(0);" class="btn btn-sm btn-falcon-default text-danger me-2 d-none d-md-block">
                                <span class="fas fa-cube me-2"></span><?php echo e($patient->pricing_package == 'AL-SECRET-CONFIDENCE' ? 'SECRET CONFIDENCE' : 'SECRET SELECT'); ?>

                            </a>
                        <?php endif; ?>

                    <?php endif; ?>

                    <?php if(@$patient->fl_profile && @$patient->fl_front && @$patient->fl_smile && @$patient->fl_upper_occlusal && @$patient->fl_lower_occlusal &&
                            @$patient->fl_right_buccal && @$patient->fl_frontal && @$patient->fl_left_buccal): ?>
                        <a href="<?php echo e(url('/patient/print/images/' . $hashids->encode($patient->id))); ?>" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block ">
                            <span class="fas fas fa-print me-2"></span>Images
                        </a>
                    <?php endif; ?>

                    <?php if($patient->is_editable == 1 && Auth::user()->role == 'doctor'): ?>
                        <a href="<?php echo e(url('/patient/edit/' . $hashids->encode($patient->id))); ?>" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block">
                            <span class="fas fas fa-edit me-2"></span>Edit
                        </a>
                    <?php endif; ?>

                    <?php if($patient->is_submitted == 0 && Auth::user()->role == 'doctor'): ?>
                        <a href="<?php echo e(url('/patient/edit/' . $hashids->encode($patient->id))); ?>" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block">
                            <span class="fas fas fa-edit me-2"></span>Submit Case
                        </a>
                    <?php endif; ?>

                    <?php if(Auth::user()->role == 'staff' || Auth::user()->role == 'superadmin'): ?>
                        <?php if($patient->is_editable == 1): ?>
                            <a href="javascript:void(0);" id="block-edit" data="<?php echo e($patient->is_editable); ?>"
                                class="btn btn-sm btn-falcon-default me-2 d-none d-md-block"><span
                                    class="fas fas fa-edit me-2"></span>Disable Edit</a>
                        <?php else: ?>
                            <a href="javascript:void(0);" id="block-edit" data="<?php echo e($patient->is_editable); ?>"
                                class="btn btn-sm btn-falcon-default me-2 d-none d-md-block "><span
                                    class="fas fas fa-edit me-2"></span>Allow Edit</a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if(Auth::user()->role == 'doctor'): ?>
                        <a href="<?php echo e(url('/patient/documentation/' . $hashids->encode($patient->id))); ?>" class="btn btn-sm btn-falcon-default me-2 d-none d-md-block">
                            <span class="fas fa-folder-open me-2"></span>Documentation
                        </a>
                    <?php endif; ?>

                    <div class="dropdown font-sans-serif">
                        <a class="btn btn-sm btn-falcon-default me-2 d-none d-md-block dropdown-toggle"
                            id="dropdownMenuLink" href="#" role="button" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Treatment Plan <?php echo e($patient->phase); ?>

                        </a>
                        <div class="dropdown-menu dropdown-menu-end py-0" aria-labelledby="dropdownMenuLink">
                            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($plan->id != $patient->id): ?>
                                    <a class="dropdown-item" href="<?php echo e(url('/patient/case-overview/' . $hashids->encode($plan->id))); ?>">
                                        Treatment Plan <?php echo e($plan->phase); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/u531876341/domains/secretalign-user.com/public_html/resources/views/patients/case-overview/case_overview_header.blade.php ENDPATH**/ ?>