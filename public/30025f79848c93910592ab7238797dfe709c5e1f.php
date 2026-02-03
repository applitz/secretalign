

<?php $__env->startSection('content'); ?>
<style>
    .account-pages .logo-admin {
   
    width: 200px;
    height: 200px;
    }
    .form-control {
 
    font-size: 16px;
    }
    .btn{
            font-size: 20px;
    }
    .form-label {
   
    font-size: 17px;
}
</style>
<div class="card overflow-hidden">
    <div class="bg-login text-center">
        <div class="bg-login-overlay"></div>
        <div class="position-relative">
            <h5 class="text-white font-size-20">Welcome Back!</h5>
            <p class="text-white-50 mb-0">Sign in to continue.</p>
             <a href="<?php echo e(url('')); ?>" class="logo logo-admin overflow-hidden mt-4" style="">
                <img src="<?php echo e(asset('public/assets/circle-logo.jpg')); ?>" style="      width: 200px;
    height: 200px;">
            </a>
        </div>
    </div>
    <div class="card-body pt-5">
        <div class="p-2 pt-5 mt-5">
            <form class="form-horizontal" method="POST" action="<?php echo e(route('login')); ?>">

                <div class="mb-3">
                    <label class="form-label" for="email">Email address</label>
                    <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" placeholder="Email">
                    <?php $__errorArgs = ['email'];
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
                    <label class="form-label" for="userpassword">Password</label>
                    


                    <div class="input-group ">
                        <input type="password" class="form-control" id="validationTooltipUsername" placeholder="Enter password" aria-describedby="validationTooltipUsernamePrepend" name="password">
                        <div class="input-group-prepend " >
                            <span class="input-group-text h-100 password-toggle" style="cursor: pointer" id="validationTooltipUsernamePrepend">
                                <i class="fas fa-eye"></i>
                            </span>
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

                <div class="form-check">
                    <input type="checkbox" class="form-check-input"name="remember" id="remember" <?php echo e(old('remember')
                    ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="remember">Remember
                        me</label>
                </div>

                <div class="mt-3">
                    <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Log
                        In</button>
                </div>

            </form>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth_base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\secretalign\resources\views/auth/login.blade.php ENDPATH**/ ?>