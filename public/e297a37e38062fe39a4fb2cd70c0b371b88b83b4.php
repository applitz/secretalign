

<?php $__env->startSection('content'); ?>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex flex-column mt-3">
                    <h4 class="page-title mb-0 font-size-18">Manage Users</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo e(url('/users/view')); ?>">Users</a></li>
                            <li class="breadcrumb-item active">Register</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>


        <div class="card mb-3">
            <div class="card-body ">
                <h4 class="card-title mb-3">Register User</h4>


                <form class="save-form " method="POST" action="<?php echo e(url('/user/save')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label" for="first_name">First Name</label>
                        <input class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="first_name" type="text"
                            value="<?php echo e(old('first_name')); ?>" placeholder="First Name" name="first_name">
                        <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="last_name">Last Name</label>
                        <input class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="last_name" type="text"
                            value="<?php echo e(old('last_name')); ?>" placeholder="Last Name" name="last_name">
                        <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone_number">Phone Number</label>
                        <input type="tel"
                            class="form-control <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                is-invalid
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="phone_number" id="phone_number" value="<?php echo e(old('phone_number')); ?>"
                            placeholder="Phone Number">
                        <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="billing_address">Billing Address</label>
                        <textarea class="form-control <?php $__errorArgs = ['billing_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    is-invalid
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="billing_address" id="billing_address" placeholder="Billing Address"><?php echo e(old('billing_address')); ?></textarea>
                        <?php $__errorArgs = ['billing_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email"
                            value="<?php echo e(old('email')); ?>" type="email" placeholder="Email" name="email">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Password</label>
                        <span class="text-muted" style="display:inherit;">* must be at least 6 characters in length</span>
                        <span class="text-muted" style="display:inherit;">* must contain at least one lowercase
                            letter</span>
                        <span class="text-muted mb-2" style="display:inherit;">* must contain at least one digit</span>
                        <div class="input-group form-password-toggle mb-2">
                            <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="password" placeholder="Password" name="password" aria-describedby="password" />
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer h-100"><i class="fas fa-eye "></i></span>
                            </div>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="confirm_password">Confirm Password</label>
                        <span class="text-muted mb-2" style="display:inherit;">* password and confirm password must
                            match</span>
                        <div class="input-group form-password-toggle mb-2">
                            <input type="password" class="form-control <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                id="confirm_password" placeholder="Confirm Password" name="confirm_password"
                                aria-describedby="confirm_password" />
                            <div class="input-group-append">
                                <span class="input-group-text cursor-pointer h-100"><i class="fas fa-eye "></i></span>
                            </div>
                        </div>
                        <?php $__errorArgs = ['confirm_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <?php if(Auth::user()->role == 'superadmin'): ?>
                        <div class="mb-3">
                            <label for="role">Role/Privileges</label>
                            <select class="form-select  <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="role"
                                name="role">
                                <option value="">Select role...</option>
                                <option value="superadmin" <?php if(old('role') == 'superadmin'): ?> selected <?php endif; ?>>Superadmin
                                </option>
                                <option value="advisor" <?php if(old('role') == 'advisor'): ?> selected <?php endif; ?>>Advisor</option>
                                <option value="doctor" <?php if(old('role') == 'doctor'): ?> selected <?php endif; ?>>Doctor</option>
                                <option value="staff" <?php if(old('role') == 'staff'): ?> selected <?php endif; ?>>Staff</option>
                                <option value="rep" <?php if(old('role') == 'rep'): ?> selected <?php endif; ?>>Secret Partner
                                </option>
                                <option value="lab" <?php if(old('role') == 'lab'): ?> selected <?php endif; ?>>Lab Technician
                                </option>
                            </select>
                            <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="role" value="doctor">
                    <?php endif; ?>

                    <div class="mb-3" id="doctorTier">
                        <label for="tier">Tier</label>
                        <select class="form-select <?php $__errorArgs = ['tier'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tier" id="tier">
                            <?php $__currentLoopData = $tiers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tier->id); ?>">
                                    <?php echo e($tier->tier_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="mb-3" id="advisorPrice">
                        <label for="tier">Advsior Quote</label>
                        <input type="advisor_price" class="form-control <?php $__errorArgs = ['advisor_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="advisor_price" placeholder="Enter Advisor Quote" name="advisor_price"
                            aria-describedby="advisor_price" />
                    </div>



                    <div class="mb-3">
                        <input type="submit" name="submit" class="btn btn-primary waves-effect waves-light"
                            value="Save Changes">
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('javascript'); ?>
    <script>
        $(document).ready(function() {
            $("#doctorTier").hide();
            $("#role").on("change", function() {
                var selectedRole = $(this).val();
                if (selectedRole === "doctor") {
                    $("#doctorTier").show();
                } else {
                    $("#doctorTier").hide();
                }
                if (selectedRole === "advisor") {
                    $("#advisorPrice").show();
                } else {
                    $("#advisorPrice").hide();
                }
            });
            $("#role").trigger("change");
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_base_horizontal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\secretalign\resources\views/users/add_user.blade.php ENDPATH**/ ?>