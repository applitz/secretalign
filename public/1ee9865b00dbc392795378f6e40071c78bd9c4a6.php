<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Upcoming Events</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Events</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>




    <div class="row">
        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 col-sm-6 col-12">
            <div
            <?php if($event->external_link): ?>
            style="cursor:pointer;"
            onclick="window.location.href='<?php echo e($event->external_link); ?>'"
            <?php endif; ?>
            class="card border border-2 border-primary shadow">
                <div class="card-body p-3" >
                    <h3 class="mt-0 mb-1 fw-bolder text-primary" style="text-transform: uppercase"><?php echo e($event->event_name); ?></h3>
                    <h4 class=" fw-bolder mb-1 mt-0"><?php echo e(date("M d", strtotime($event->date))); ?></h4>
                    <div style="max-height: 95px;overflow: hidden">
                        <p class="card-title-desc mb-1 fs-9"><?php echo e($event->description); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php echo e($events->links('pagination::bootstrap-5')); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_base_horizontal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u531876341/domains/secretalign-user.com/public_html/resources/views/events/show_events.blade.php ENDPATH**/ ?>