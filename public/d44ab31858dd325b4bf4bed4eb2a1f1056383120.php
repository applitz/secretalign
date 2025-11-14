

<?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Patients</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(url('/home')); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Manage Patients</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="filter-form">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <div class="row align-items-center g-3">
                            <div class="col-12">
                                <h6 class="text-700 mb-0">Date: </h6>
                            </div>
                            <div class="col-12 position-relative">
                                <input class="form-control form-control-sm pickr ps-4" name="date" id="CRMDateRange"
                                    value="<?php echo e(@$_GET['date']); ?>" placeholder="Y-m-d to Y-m-d" type="text" style="border: 1px solid #aaa;"
                                    data-options="{&quot;mode&quot;:&quot;range&quot;,&quot;dateFormat&quot;:&quot;M d&quot;,&quot;disableMobile&quot;:true , &quot;defaultDate&quot;: [&quot;Aug 15&quot;, &quot;Aug 22&quot;] }" /><span
                                    class="fas fa-calendar-alt text-primary position-absolute top-50 translate-middle-y ms-2">
                                </span>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <div class="row align-items-center g-3">
                            <div class="col-12">
                                <h6 class="text-700 mb-0">Status: </h6>
                            </div>
                            <div class="col-12 position-relative">
                                <select class="form-select form-select-sm mySelect2 mySelect2" id="statuChooser" style="border: 1px solid #aaa;"
                                    name="ft_status" data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">Any</option>
                                    <?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>><?php echo e(ucfirst($status)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <div class="row align-items-center g-3">
                            <div class="col-12">
                                <h6 class="text-700 mb-0">Case Holder: </h6>
                            </div>
                            <div class="col-12 position-relative">
                                <select class="form-select form-select-sm mySelect2" id="ft_case_holder" style="border: 1px solid #aaa;"
                                    name="ft_case_holder" data-options='{"removeItemButton":true,"placeholder":true}'>
                                    <option value="">Any</option>
                                    <?php $__currentLoopData = $caseHolderOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caseHolder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($caseHolder); ?>" <?php echo e(request('case_holder') == $caseHolder ? 'selected' : ''); ?>><?php echo e(ucfirst($caseHolder)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <div class="row align-items-center g-3">
                            <div class="col-12">
                                <h6 class="text-700 mb-0">Search: </h6>
                            </div>
                            <div class="col-12 position-relative">
                                <input class="form-control form-control-sm" id="ft_search" name="ft_search" style="border: 1px solid #aaa;" placeholder="Search"
                                    value="<?php echo e(@$_GET['search']); ?>" />
                            </div>
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <div class="row align-items-center g-3">
                                <div class="col-12">
                                    <h6 class="text-700 mb-0">&nbsp;</h6>
                                </div>
                                <div class="col-12 position-relative">
                                    <div class="btn-group">
                                        <button class="btn btn-primary waves-effect waves-light btn-sm submit-filter-form" type="submit"><i
                                            class="fas fa-search me-2"></i> Filter</button>
                                        <a class="btn btn-warning waves-effect waves-light btn-sm" id="clear-filters" href="javascript:;"><i
                                            class="fas fa-trash-alt me-2"></i> Clean Filters</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="patients-list" class="table table-striped">

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<script src="<?php echo e(asset('public/assets/plugins/dataTables/1.11.5/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/dataTables/1.11.5/js/dataTables.bootstrap5.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/plugins/dataTables/responsive/2.2.9/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/assets/customjs/patients.js')); ?>"></script>
<script>
    $(document).ready(function() {
        Patients.init();
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_base_horizontal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\secretalign\resources\views/doctor/patients/index.blade.php ENDPATH**/ ?>