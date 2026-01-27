<?php if(@$notifications): ?>
<?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notify): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<a <?php if($notify->task_id != null): ?>
    href="<?php echo e(url('/view-tasks?task=' . $notify->task_id . '&notify=' . $notify->id)); ?>"
    <?php elseif($notify->treatment_plan_id != null): ?>
    href="<?php echo e(url('/patient/case-overview/' . $hashids->encode($notify->treatment_plan_id) . '?notify=' . $notify->id)); ?>"
<?php else: ?>
href="<?php echo e(url('view-notifications')); ?>?read=<?php echo e($notify->id); ?>"
    <?php endif; ?> class="text-reset notification-item">
    <div class="d-flex align-items-start">
        <div class="avatar-xs me-3">
            <span class="avatar-title bg-primary rounded-circle font-size-16">
                <i class="bx bx-bell"></i>
            </span>
        </div>
        <div class="flex-1">
            <h6 class="mt-0 mb-1"><?php echo e($notify->title == null ? 'Task Alert' : $notify->title); ?></h6>
            <div class="font-size-12 text-muted">
                <p class="mb-1"><?php echo e($notify->body); ?></p>
                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <?php echo e(date("Y-m-d H:i:s",
                    strtotime($notify->created_at))); ?></p>
            </div>
        </div>
    </div>
</a>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<input type="hidden" id="unread-notifications" name="unread-notifications" value="<?php echo e($count); ?>">
<?php else: ?>
<input type="hidden" id="unread-notifications" name="unread-notifications" value="0">
<?php endif; ?>
<?php /**PATH D:\xampp\htdocs\secretalign\resources\views/layouts/notifications.blade.php ENDPATH**/ ?>