

<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18" >Dashboard</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Welcome to Secret Clear Aligner System.</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <?php if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'advisor'): ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Tasks</h4>
                    <p class="card-title-desc">Unfinished Tasks</p>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <?php if(Auth::user()->role != 'doctor' && Auth::user()->role != 'lab'): ?>
                                        <th>Doctor</th>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'advisor'): ?>
                                        <th>Patient</th>
                                        <?php endif; ?>
                                        <th>Task</th>
                                        <?php if(Auth::user()->role == 'staff'): ?>
                                        <th>From</th>
                                        <?php endif; ?>
                                        <th><?php echo e(Auth::user()->role == 'lab' ? 'Task Date' : 'Date'); ?></th>
                                        <?php if(Auth::user()->role == 'lab'): ?>
                                        <th>Treatment Plan</th>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->role == 'doctor'): ?>
                                        <th>Due Date</th>
                                        <?php endif; ?>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($tasks) == 0): ?>
                                    <tr>
                                        <td colspan="6" class="text-center"> No Tasks To Show </td>
                                    </tr>
                                    <?php else: ?>
                                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php if(Auth::user()->role != 'doctor' && Auth::user()->role != 'lab'): ?>
                                        <td class="text-nowrap"><?php echo e($task->first_name . ' ' . $task->last_name); ?></td>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->role == 'doctor' || Auth::user()->role == 'staff' || Auth::user()->role == 'lab' || Auth::user()->role == 'advisor'): ?>
                                        <td class="text-nowrap"><?php echo e($task->p_first_name . ' ' . $task->p_last_name); ?>

                                        </td>
                                        <?php endif; ?>
                                        <td class="text-nowrap">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                <?php
                                                    $badgeClass = 'badge-soft-info';
                                                    if (str_contains($task->task, 'Review Setup')) {
                                                        if(Auth::user()->role == 'lab')
                                                            $task->task = str_replace("Review Setup", "Production", $task->task);
                                                        $badgeClass = 'badge-soft-primary';
                                                    }
                                                    if (str_contains($task->task, 'Setup')) {
                                                        $badgeClass = 'badge-soft-warning';
                                                    }
                                                    if (str_contains($task->task, 'Modification Setup')) {
                                                        $badgeClass = 'badge-soft-danger';
                                                    }
                                                    if (str_contains($task->task, 'production')) {
                                                        $badgeClass = 'badge-soft-primary';
                                                    }
                                                ?>
                                                <a class="btn btn-link <?php echo e($badgeClass); ?> text-600 btn-sm btn-reveal-sm transition-none"
                                                href="<?php echo e(url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id))); ?>"
                                                data-boundary="viewport" aria-haspopup="true" aria-expanded="false">
                                                    <?php echo e($task->task); ?>

                                                </a>
                                            </div>
                                        </td>
                                        <?php if(Auth::user()->role == 'staff'): ?>
                                        <td class="text-nowrap">
                                        <?php if($task->previous_case_holder): ?>
                                            <?php echo e(ucfirst($task->previous_case_holder)); ?>

                                        <?php endif; ?>
                                        </td>
                                        <?php endif; ?>
                                        <td class="text-nowrap"><?php echo e(date('d/m/Y', strtotime($task->created_at))); ?>

                                        </td>
                                        <?php if(Auth::user()->role == 'lab'): ?>
                                        <td class="text-nowrap">
                                            <span class="badge fw-semi-bold rounded-pill status badge-soft-info">Phase <?php echo e($task->phase); ?></span>
                                        </td>
                                        <?php endif; ?>
                                        <?php if(Auth::user()->role == 'doctor'): ?>
                                        <td class="text-nowrap">
                                            <?php if(@$task->cancellation_date): ?>
                                            <?php echo e(date("Y-m-d", strtotime("-1 day", strtotime(date("Y-m-d",
                                            strtotime($task->cancellation_date)))))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <?php endif; ?>
                                        
                                        <td class="text-end text-nowrap">
                                            <div class="font-sans-serif btn-reveal-trigger">
                                                <a class="btn btn-link text-600 btn-sm btn-reveal-sm transition-none"
                                                    href="<?php echo e(url('/patient/case-overview/' . $hashids->encode($task->treatment_plan_id))); ?>"
                                                    data-boundary="viewport" aria-haspopup="true" aria-expanded="false">Case
                                                    Overview</a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12 ">
                                <?php echo e($tasks->links('pagination::bootstrap-5')); ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>



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





    

    

</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('javascript'); ?>

  <!-- plugin js -->
  <script src="<?php echo e(asset('public')); ?>/qovex/assets/libs/moment/min/moment.min.js"></script>
  <script src="<?php echo e(asset('public')); ?>/qovex/assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
  <script src="<?php echo e(asset('public')); ?>/qovex/assets/libs/fullcalendar/index.global.min.js"></script>

  <!-- Calendar init -->
  
  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_base_horizontal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\secretalign\resources\views/home.blade.php ENDPATH**/ ?>