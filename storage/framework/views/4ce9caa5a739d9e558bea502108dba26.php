

<?php $__env->startSection('main'); ?>

<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Admin Panel</div>
        </a>

        <hr class="sidebar-divider my-0">

        <li class="nav-item active">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('auth.index')); ?>">
                <i class="fas fa-fw fa-table"></i>
                <span>Students</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="<?php echo e(route('teacher.index')); ?>">
                <i class="fas fa-fw fa-table"></i>
                <span>Teacher</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="">
                <i class="fas fa-fw fa-table"></i>
                <span>change Password</span>
            </a>
        </li>

        <hr class="sidebar-divider d-none d-md-block">

        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>
    </ul>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <ul class="navbar-nav ml-auto">
                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- User Info -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(Auth::user()->name); ?></span>
                    
                            <?php if(Auth::user()->profile_image): ?>
                                <img class="img-profile rounded-circle" 
                                    src="<?php echo e(asset('profile_images/' . Auth::user()->profile_image)); ?>">
                            <?php else: ?>
                                <img class="img-profile rounded-circle" 
                                    src="<?php echo e(asset('default-user.png')); ?>"> 
                            <?php endif; ?>
                        </a>
                       
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?php echo e(route('profile')); ?>">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End Topbar -->


            <section class="section-5">
                <div class="container my-5">
                    <?php if(Session::has('success')): ?>
                        <div class="alert alert-success">
                            <p><?php echo e(Session::get('success')); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if(Session::has('error')): ?>
                        <div class="alert alert-danger">
                            <p><?php echo e(Session::get('error')); ?></p>
                        </div>
                    <?php endif; ?>

                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow border-0 p-5">
                                <h1 class="h3">Add Student</h1>
                                <form action="<?php echo e(route('Students.store')); ?>" method="POST" id="registrationform">
                                    <?php echo csrf_field(); ?>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name">Name*</label>
                                            <input type="text" name="name" class="form-control typeahead" value="<?php echo e(old('name', $student->name ?? '')); ?>" placeholder="Enter name">
                                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email">Email*</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $student->email ?? '')); ?>" placeholder="Enter email">
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="birthdate">Birthdate*</label>
                                            <input type="date" name="birthdate" class="form-control" 
                                                   value="<?php echo e(old('birthdate', isset($student) ? \Carbon\Carbon::parse($student->birthdate)->format('Y-m-d') : '')); ?>">
                                            <?php $__errorArgs = ['birthdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                                <span class="text-danger"><?php echo e($message); ?></span> 
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="gender">Gender*</label>
                                            <select name="gender" class="form-control">
                                                <option value="">Select Gender</option>
                                                <option value="Male" <?php echo e(old('gender', $student->gender ?? '') == 'Male' ? 'selected' : ''); ?>>Male</option>
                                                <option value="Female" <?php echo e(old('gender', $student->gender ?? '') == 'Female' ? 'selected' : ''); ?>>Female</option>
                                                <option value="Other" <?php echo e(old('gender', $student->gender ?? '') == 'Other' ? 'selected' : ''); ?>>Other</option>
                                            </select>
                                            <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="class">Class*</label>
                                            <input type="text" name="class" class="form-control" value="<?php echo e(old('class', $student->class ?? '')); ?>" placeholder="Enter Class">
                                            <?php $__errorArgs = ['class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="mobileno">Mobileno*</label>
                                            <input type="number" name="mobileno" class="form-control" value="<?php echo e(old('mobileno', $student->mobileno ?? '')); ?>" placeholder="Enter mobile no">
                                            <?php $__errorArgs = ['mobileno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="state_id">State*</label>
                                            <select name="state_id" id="state_id" class="form-control">
                                                <option value="">Select State</option>
                                                <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($state->id); ?>" <?php echo e(old('state_id', $student->state_id ?? '') == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['state_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="district_id">District*</label>
                                            <select name="district_id" id="district_id" class="form-control">
                                                <option value="">Select District</option>
                                                <?php if(!empty($districts)): ?>
                                                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($district->id); ?>" <?php echo e(old('district_id', $student->district_id ?? '') == $district->id ? 'selected' : ''); ?>>
                                                            <?php echo e($district->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                            <?php $__errorArgs = ['district_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="col-md-6 mt-3">
                                            <label for="taluka_id">Taluka*</label>
                                            <select name="taluka_id" id="taluka_id" class="form-control">
                                                <option value="">Select Taluka</option>
                                                <?php if(!empty($talukas)): ?>
                                                    <?php $__currentLoopData = $talukas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taluka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($taluka->id); ?>" <?php echo e(old('taluka_id', $student->taluka_id ?? '') == $taluka->id ? 'selected' : ''); ?>>
                                                            <?php echo e($taluka->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                            <?php $__errorArgs = ['taluka_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function () {
        $('#state_id').on('change', function () {
            var stateID = $(this).val();
            if (stateID) {
                $.ajax({
                    url: '/get-districts/' + stateID,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#district_id').empty().append('<option value="">Select District</option>');
                        $.each(data, function (key, value) {
                            $('#district_id').append('<option value="' + key + '">' + value + '</option>');
                        });
                        $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
                    }
                });
            } else {
                $('#district_id').empty().append('<option value="">Select District</option>');
                $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
            }
        });

        $('#district_id').on('change', function () {
            var districtID = $(this).val();
            if (districtID) {
                $.ajax({
                    url: '/get-talukas/' + districtID,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
                        $.each(data, function (index, taluka) {
                            $('#taluka_id').append('<option value="' + taluka.id + '">' + taluka.name + '</option>');
                        });
                    }
                });
            } else {
                $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
            }
        });
    });
</script>
<script>
    var path = "<?php echo e(route('student.autocomplete')); ?>";

    $('input.typeahead').typeahead({
        source: function (query, process) {
            return $.get(path, { value: query }, function (data) {
                return process(data);
            });
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Crud\resources\views/students/create.blade.php ENDPATH**/ ?>