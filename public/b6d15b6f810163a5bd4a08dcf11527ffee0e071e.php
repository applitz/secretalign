

<?php $__env->startSection('content'); ?>
<div class="page-content">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex flex-column mt-3">
                <h4 class="page-title mb-0 font-size-18">Manage Users</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="mt-2" method="GET" action="<?php echo e(url('/users/view')); ?>">
                        <div class="row">
                            <?php if(Auth::user()->role == 'superadmin'): ?>
                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Role/Privileges</h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <select class="form-select form-select-sm  <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="role"
                                            name="role">
                                            <option value="">Select role...</option>
                                            <option value="advisor" <?php if(@$_GET['role']=='advisor' ): ?> selected <?php endif; ?>>Asvisor</option>
                                            <option value="doctor" <?php if(@$_GET['role']=='doctor' ): ?> selected <?php endif; ?>>Doctor</option>
                                            <option value="staff" <?php if(@$_GET['role']=='staff' ): ?> selected <?php endif; ?>>Staff</option>
                                            <option value="rep" <?php if(@$_GET['role']=='rep' ): ?> selected <?php endif; ?>>Al-Secret Partner</option>
                                            <option value="lab" <?php if(@$_GET['role']=='lab' ): ?> selected <?php endif; ?>>Lab Technician</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-3 mb-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-12">
                                        <h6 class="text-700 mb-0">Search: </h6>
                                    </div>
                                    <div class="col-12 position-relative">
                                        <input class="form-control form-control-sm" id="search" name="search" placeholder="Search"
                                            value="<?php echo e(@$_GET['search']); ?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="btn-group">
                                    <button class="btn btn-primary waves-effect waves-light btn-sm submit-filter-form" type="submit"><i
                                            class="fas fa-search me-2"></i> Filter</button>
                                    <a class="btn btn-warning waves-effect waves-light btn-sm" href="<?php echo e(url() ->current()); ?>"><i
                                            class="fas fa-trash-alt me-2"></i> Clean Filters</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="tech-companies-1" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <?php if(Auth::user()->role != 'rep'): ?>
                                        <th scope="col" class="text-center">Role/Privileges</th>
                                        <?php endif; ?>
                                        <th scope="col" class="text-center">Tier</th>
                                        <?php if(Auth::user()->role == 'superadmin'): ?>
                                        <th scope="col"></th>
                                        <th class="text-end" scope="col">Action</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(count($users)): ?>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="align-middle">
                                        <td class="text-nowrap">
                                            <div class="flex-1">
                                                <span class="mb-1 fw-semi-bold text-dark"><?php echo e($user->first_name . ' ' .
                                                    $user->last_name); ?></span>
                                                <?php if($user->role == 'lab'): ?>
                                                <p class="fw-semi-bold mb-0 text-500">Lab Request (<?php echo e($user->lab_request_count); ?>)</p>
                                                <?php endif; ?>
                                                <?php if($user->role == 'doctor'): ?>
                                                <p class="fw-semi-bold mb-0 text-500">Patients (<?php echo e($user->patient_count); ?>)</p>
                                                <?php endif; ?>
                                                <?php if($user->role == 'rep'): ?>
                                                <p class="fw-semi-bold mb-0 text-500">Registered Doctors (<?php echo e($user->doctors_count); ?>)</p>
                                                <?php endif; ?>
                                            </div>

                                        </td>
                                        <td class="text-nowrap"><?php echo e($user->email); ?></td>
                                        <?php if(Auth::user()->role != 'rep'): ?>
                                        <td class="text-nowrap text-center">
                                            <span class="badge badge-soft-primary">
                                                <?php if($user->role == 'rep'): ?>
                                                Partner
                                                <?php else: ?>
                                                <?php echo e(ucfirst($user->role)); ?>

                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <?php endif; ?>
                                        <td class="text-nowrap text-center">
                                            <?php if($user->role == 'doctor'): ?>
                                            <?php if($user->tier == 2): ?>
                                            <span class="badge rounded-pill badge-soft-dark"><?php echo e($user->tier_name); ?></span>
                                            <?php elseif($user->tier == 3): ?>
                                            <span class="badge rounded-pill badge-soft-warning"><?php echo e($user->tier_name); ?></span>
                                            <?php elseif($user->tier == 4): ?>
                                            <span class="badge rounded-pill badge-soft-secondary"><?php echo e($user->tier_name); ?></span>
                                            <?php elseif($user->tier == 5): ?>
                                            <span class="badge rounded-pill badge-soft-info"><?php echo e($user->tier_name); ?></span>
                                            <?php elseif($user->tier == 6): ?>
                                            <span class="badge rounded-pill badge-soft-success"><?php echo e($user->tier_name); ?></span>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <?php if(Auth::user()->role == 'superadmin'): ?>
                                        <td class="text-nowrap">
                                            <?php if($user->data_processing_document_signatures && $user->role == 'doctor'): ?>
                                            <a href="<?php echo e(url('/contract/view/data-processing-document/'.$user->id)); ?>">Data Processing Document</a>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <div>
                                                <a class="btn p-0" href="<?php echo e(url('/user/edit/'.$user->id)); ?>" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="" data-bs-original-title="Edit"
                                                    aria-label="Edit"><i
                                                    class="fas fa-edit"></i></a>
                                                <?php if($user->role != 'superadmin' && $user->role != 'doctor'): ?>
                                                <a class="btn p-0 ms-2 delete" data-id="<?php echo e($user->id); ?>" data-name="<?php echo e($user->email); ?>"
                                                    href="javascript:;" data-bs-toggle="tooltip" data-bs-placement="top" title=""
                                                    data-bs-original-title="Delete" aria-label="Delete"><i
                                                    class="fas fa-trash-alt"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                    <td class="text-center" <?php if(Auth::user()->role == 'superadmin'): ?>
                                        colspan="5"
                                        <?php else: ?>
                                        colspan="4"
                                        <?php endif; ?>>
                                        No Data To Show
                                    </td>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <?php echo e($users->links('pagination::bootstrap-5')); ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<form id="delete-user" method="POST">
    <?php echo csrf_field(); ?>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
<?php echo $__env->make('layouts.page_scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete', function () {
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var c = confirm("Are you really want to delete "+name);
            if(c){
                var url = "<?php echo e(url('')); ?>/user/delete/"+id;
                $("#delete-user").attr('action', url);
                $("#delete-user").submit();
            }
        })
    })
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app_base_horizontal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\secretalign\resources\views/users/view_users.blade.php ENDPATH**/ ?>