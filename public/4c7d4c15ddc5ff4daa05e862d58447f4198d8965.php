<div class="tab-pane fade" id="pill-tab-div6" role="tabpanel" aria-labelledby="pill-tab-li6">
    <div class="mb-3 notifications" <?php if($fn1==1 && $fn2==1 && $fn3==1 && $fn4==1): ?> style="display: none;" <?php endif; ?>>
        <?php if($fn1 == 0): ?>
            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                <div class="bg-danger me-3 icon-item"><span
                        class="fas fa-times-circle text-white fs-3"></span></div>
                <p class="mb-0 flex-1">Patient Info section is not complete!</p>
            </div>
        <?php endif; ?>

        <?php if($fn2 == 0): ?>
            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                <div class="bg-danger me-3 icon-item"><span
                        class="fas fa-times-circle text-white fs-3"></span></div>
                <p class="mb-0 flex-1">Scan Data section is not complete!</p>
            </div>
        <?php endif; ?>
        <?php if($fn3 == 0): ?>
            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                <div class="bg-danger me-3 icon-item"><span
                        class="fas fa-times-circle text-white fs-3"></span></div>
                <p class="mb-0 flex-1">Images / X-Rays section is not complete!</p>
            </div>
        <?php endif; ?>
        <?php if($fn4 == 0): ?>
            <div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                <div class="bg-danger me-3 icon-item"><span
                        class="fas fa-times-circle text-white fs-3"></span></div>
                <p class="mb-0 flex-1">Prescription section is not complete!</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="mb-3 finish" <?php if($fn1==0 || $fn2==0 || $fn3==0 || $fn4==0): ?> style="display: none;" <?php endif; ?>>

        <?php if($patient->is_editable == 1): ?>
            <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                <div class="bg-success me-3 icon-item"><span
                        class="fas fa-check-circle text-white fs-3"></span></div>
                <p class="mb-0 flex-1">Finish editing and continue to case overview!</p>
                
            </div>
        <?php else: ?>
            <div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                <div class="bg-success me-3 icon-item"><span
                        class="fas fa-check-circle text-white fs-3"></span></div>
                <p class="mb-0 flex-1">Submit case for staff to review!
                </p>
            </div>
        <?php endif; ?>

        <?php if($patient->is_editable == 1): ?>
            <div class="mb-3">
                <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li5">Previous</button>
                <button class="btn btn-primary btn-sm waves-effect waves-light px-3" type="button"
                    onclick="document.getElementById('final-submit-form').submit()">Confirm &
                    Update</button>
            </div>
        <?php endif; ?>
        <?php if($patient->phase >=2 && $patient->is_submitted == 0): ?>
        <div class="mb-3">
            <div class="container-fluid px-0">
                <div class="row">
                    <br>
                    <div class="col-md-12 mb-3">
                        <div class="d-flex flex-sm-row flex-column alert alert-info">
                            <label class="form-check-label mb-0 fw-bold d-block">CONSULT WITH ONE OF OUR EXPERT ADVISORS</label>
                        </div>
                        <label><strong>Choose Advisor</strong></label>
                        <select class="form-control form-select" name="advisor" id="advisor" required>
                            <option value="" disabled selected>Select Advisor</option>
                            <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>">
                                <?php echo e($item->first_name); ?> <?php echo e($item->last_name); ?> (€<?php echo e($item->advisor_price); ?>)
                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Hidden Div to show after selecting an advisor -->
                <div id="additionalDivs" class="d-none">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label>Comment For Advisor</label>
                            <textarea class="form-control" name="comment" id="comment" placeholder="Add a comment"></textarea>
                        </div>
                    </div>

                    <div class="mb-3 ps-2">
                        <div class="form-check">
                            <input class="form-check-input" id="consultant_agreement" type="checkbox" name="consultant_agreement" value="3" required/>
                            <label class="form-check-label" for="consultant_agreement">
                                Please note that this consultation incurs an additional fee. You will be billed directly by the selected advisory bureau. Ordering an additional consultation may delay the delivery of your treatment plan by up to 7 days, depending on the selected advisory bureau.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mb-3 ps-2">
                    <div class="form-check">
                        <input class="form-check-input" id="terms_and_conditions" type="checkbox" name="terms_and_conditions" value="1"/>
                        <label class="form-check-label" for="terms_and_conditions">I have read and accepted the <a href="<?php echo e(asset('public/assets/ACFrOgDNGancwUUF4OXO-_6Ms-3RC6v9OdnsDpeGvDoT_VQfsjmuIPuClaf-Cc7mHpEQLZbSapOx7ghsAuip4PwC31FCgl2C9RiOAHY-yxwagybIQUkHKb6Hz--6t7Ru2WYboYmn1pO1hwp2LFpu.pdf')); ?>" target="_blank"><b>Packages and Terms & conditions agreement</b></a>.</label>
                    </div>
                </div>
                </form>
            </div>
        </div>


        <div class="mb-3">
            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li5">Previous</button>
            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" type="button"
                id="final-confirm-and-submit-btn">Confirm & Submit</button>
        </div>

        <?php endif; ?>

        <?php if($patient->phase == 1 && ($mode == 'add' || $patient->is_submitted == 0)): ?>

        <div class="mb-3">

            <h5 class="text-600 fs-0 mb-2">Select your preferred package.</h5>
            <div class="d-flex flex-sm-row  flex-column alert alert-info">
                <div class="me-sm-3">
                    <div class="form-check mb-0 custom-radio radio-select">
                        <input class="form-check-input" id="pricing_package_1" type="radio" value="select" name="pricing_package" checked="checked" />
                        <label class="form-check-label mb-0 fw-bold d-block" for="pricing_package_1">
                            SECRET SELECT
                            </label>
                        </div>
                </div>
                <div>
                    <div class="form-check mb-0 custom-radio radio-select">
                        <input class="form-check-input" id="pricing_package_2" type="radio" value="confidence" name="pricing_package" />
                        <label class="form-check-label mb-0 fw-bold d-block" for="pricing_package_2">SECRET CONFIDENCE
                            </label>
                        </div>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="container-fluid px-0">

                    <div class="row">

                        <br>
                        <div class="col-md-12 mb-3">
                            <div class="d-flex flex-sm-row flex-column alert alert-info">
                                <label class="form-check-label mb-0 fw-bold d-block">CONSULT WITH ONE OF OUR EXPERT ADVISORS</label>
                            </div>
                            <label><strong>Choose Advisor</strong></label>
                            <select class="form-control form-select" name="advisor" id="advisor" required>
                                <option value="" disabled selected>Select Advisor</option>
                                <?php $__currentLoopData = $advisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>">
                                    <?php echo e($item->first_name); ?> <?php echo e($item->last_name); ?> (€<?php echo e($item->advisor_price); ?>)
                                </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                    </div>


                    <!-- Hidden Div to show after selecting an advisor -->
                    <div id="additionalDivs" class="d-none">

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label>Comment for Advisor</label>
                                <textarea class="form-control" name="comment" id="comment" placeholder="Add a comment"></textarea>
                            </div>
                        </div>

                        <div class="mb-3 ps-2">
                            <div class="form-check">
                                <input class="form-check-input" id="consultant_agreement" type="checkbox" name="consultant_agreement" value="3" required/>
                                <label class="form-check-label" for="consultant_agreement">
                                    Please note that this consultation incurs an additional fee. You will be billed directly by the selected advisory bureau. Ordering an additional consultation may delay the delivery of your treatment plan by up to 7 days, depending on the selected advisory bureau.
                                </label>
                            </div>
                        </div>
                    </div>

            </div>
        </div>




        <div class="mb-3 ps-2">
                <div class="form-check">
                <input class="form-check-input" id="terms_and_conditions" type="checkbox" name="terms_and_conditions" value="1"/>
                <label class="form-check-label" for="terms_and_conditions">I have read and accepted the <a href="<?php echo e(asset('public/assets/ACFrOgDNGancwUUF4OXO-_6Ms-3RC6v9OdnsDpeGvDoT_VQfsjmuIPuClaf-Cc7mHpEQLZbSapOx7ghsAuip4PwC31FCgl2C9RiOAHY-yxwagybIQUkHKb6Hz--6t7Ru2WYboYmn1pO1hwp2LFpu.pdf')); ?>" target="_blank"><b>Packages and Terms & conditions agreement</b></a>.</label>
                </div>
        </div>
        <?php if($mode == 'edit' && $patient->is_editable == 1): ?>
        <div class="mb-3">
            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li5">Previous</button>
            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" type="button"
                id="final-confirm-and-submit-btn">Confirm &
                Update</button>
        </div>

        <?php else: ?>
        <div class="mb-3">
            <button class="btn btn-primary btn-sm waves-effect waves-light px-3 previous-tab" data-target="#pill-tab-li5">Previous</button>
            <button class="btn btn-primary btn-sm waves-effect waves-light px-3" type="button"
                id="final-confirm-and-submit-btn">Confirm &
                Submit</button>
        </div>

        <?php endif; ?>





                
        <?php endif; ?>


    </div>
</div>
<?php /**PATH D:\xampp\htdocs\secretalign\resources\views/patients/create-patients/confirm-submit.blade.php ENDPATH**/ ?>