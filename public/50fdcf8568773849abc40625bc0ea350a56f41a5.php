<?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($c->comment || $c->attachments != null): ?>
    <div class="d-flex mt-3">
        <div class="flex-1 ms- 2 fs--1">
            <p class="mb-1 bg-gradient bg-light rounded-3 p-2"><a class="fw-semi-bold" href="javascript:void(0);">
                    <?php if($c->from_role == 'doctor'): ?> DOCTOR <?php else: ?> <?php echo e($c->first_name); ?>

                    <?php echo e($c->last_name); ?> <?php endif; ?> </a> <?php echo $c->comment; ?></p>
                     <div class="px-2">
                    <?php if($c->attachments!=''): ?>
                      <?php  $att=explode(',',$c->attachments);?>
                        <?php $__currentLoopData = $att; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(asset('file')); ?>/<?php echo e($a); ?>" target="_blank" ><i class="fa fa-download me-2"></i>Attachment <?php echo e(++$key); ?></a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            <div class="px-2"> <?php echo e(date('Y-m-d H:i A', strtotime($c->created_at))); ?> </div>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/u531876341/domains/secretalign-user.com/public_html/resources/views/patients/overview_comments.blade.php ENDPATH**/ ?>