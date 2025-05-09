

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
                <a class="nav-link" href="<?php echo e(route('auth.superadmin')); ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('auth.index')); ?>">
                    <i class="fas fa-fw fa-user-graduate"></i>
                    <span>Students</span>
                </a>
            </li>
    
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('teacher.index')); ?>">
                    <i class="fas fa-fw fa-chalkboard-teacher"></i>
                    <span>Teachers</span>
                </a>
            </li>
    
            <li class="nav-item">
                <a class="nav-link" href="<?php echo e(route('change.password')); ?>">
                    <i class="fas fa-fw fa-key"></i>
                    <span>Change Password</span>
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

                <!-- Page Heading -->
                <div class="d-flex justify-content-end mb-4 px-4">
                    <a href="<?php echo e(route('students.export', request()->query())); ?>" class="btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-download fa-sm text-white-50"></i> Export to PDF
                    </a>
                    <a href="<?php echo e(route('students.export.excel',['search' => request()->input('search'), 'state_id' => request()->input('state_id'), 'university_id' => request()->input('university_id'), 'college_id' => request()->input('college_id')])); ?>" class="btn btn-sm btn-primary shadow-sm ms-2">
                        <i class="fas fa-download fa-sm text-white-50"></i> Export to Excel
                    </a>
                    <a href="<?php echo e(route('Students.create')); ?>" class="btn btn-sm btn-primary shadow-sm ms-2">
                        + Create
                    </a>
                </div>

                <div class="container">
                    <?php if(session('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo e(session('success')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="GET" action="<?php echo e(route('students.index')); ?>">
                        <div class="row">
                            <div class="col-md-3">
                                <select name="state_id" class="form-control form-control-sm" id="state">
                                    <option value="">Select State</option>
                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->id); ?>" <?php echo e(request('state_id') == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="district_id" class="form-control form-control-sm" id="district">
                                    <option value="">Select District</option>
                                    <?php $__currentLoopData = $districts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $district): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($district->id); ?>" <?php echo e(request('district_id') == $district->id ? 'selected' : ''); ?>><?php echo e($district->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="taluka_id" class="form-control form-control-sm" id="taluka">
                                    <option value="">Select Taluka</option>
                                    <?php $__currentLoopData = $talukas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taluka): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($taluka->id); ?>" <?php echo e(request('taluka_id') == $taluka->id ? 'selected' : ''); ?>><?php echo e($taluka->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <select name="birthday_filter" class="form-control form-control-sm">
                                  <option value="">Select Birthday Filter</option>
                                  <option value="today" <?php echo e(request('birthday_filter') == 'today' ? 'selected' : ''); ?>>Today's Birthdays</option>
                                  <option value="this_week" <?php echo e(request('birthday_filter') == 'this_week' ? 'selected' : ''); ?>>This Week's Birthdays</option>
                                  <option value="this_month" <?php echo e(request('birthday_filter') == 'this_month' ? 'selected' : ''); ?>>This Month's Birthdays</option>
                                </select>
                              </div>  
                              
                            <div class="col-md-3 d-flex align-items-start gap-2">
                                <button type="submit" class="btn btn-primary btn-sm mt-1 me-2">Apply Filter</button>
                                <a href="<?php echo e(route('auth.index')); ?>" class="btn btn-secondary btn-sm mt-1">Cancel Filter</a>
                            </div>
                        </div>
                    </form>

                    <div class="mt-3">
                        <div class="card shadow border-0 p-4">
                            <h1 class="h3">Student List</h1>
                            <form method="GET" action="<?php echo e(route('students.index')); ?>" action="search">
                                <div class="input-group mb-3">
                                    <input type="text" name="search" value="<?php echo e(request('search')); ?>"
                                        class="form-control form-control-sm" placeholder="Search...">
                                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    <a href="<?php echo e(route('auth.index')); ?>" class="btn btn-secondary btn-sm ml-2">Reset</a>
                                </div>
                            </form>

                            <div class="card-body">
                                <table class="table table-sm table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Birthdate</th>
                                            <th>Gender</th>
                                            <th>Class</th>
                                            <th>Mobile No</th>
                                            <th>State</th>
                                            <th>District</th>
                                            <th>Taluka</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($student->id); ?></td>
                                                <td><?php echo e($student->name); ?></td>
                                                <td><?php echo e($student->email); ?></td>
                                                <td><?php echo e($student->birthdate); ?></td>
                                                <td><?php echo e($student->gender); ?></td>
                                                <td><?php echo e($student->class); ?></td>
                                                <td><?php echo e($student->mobileno); ?></td>
                                                <td><?php echo e($student->state->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($student->district->name ?? 'N/A'); ?></td>
                                                <td><?php echo e($student->taluka->name ?? 'N/A'); ?></td>
                                                <td>
                                                    <a href="<?php echo e(route('students.edit', $student->id)); ?>"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="<?php echo e(route('students.destroy', $student->id)); ?>" method="POST"
                                                        style="display:inline;">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button onclick="return confirm('Delete?')"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash-alt"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>

                                <div class="mt-4">
                                    <?php echo e($students->links()); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- End #content -->

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?php echo e(route('logout')); ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('customJS'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#state').on('change', function () {
            var stateId = $(this).val();
            $('#district').html('<option value="">Loading...</option>');
            $.get('/get-districts/' + stateId, function (data) {
                $('#district').html('<option value="">Select District</option>');
                $.each(data, function (id, name) {
                    $('#district').append(`<option value="${id}">${name}</option>`);
                });
                $('#taluka').html('<option value="">Select Taluka</option>');
            });
        });

        $('#district').on('change', function () {
            var districtId = $(this).val();
            $('#taluka').html('<option value="">Loading...</option>');

            $.get('/get-talukas/' + districtId, function (data) {
                $('#taluka').html('<option value="">Select Taluka</option>');

                $.each(data, function (index, taluka) {
                    $('#taluka').append(`<option value="${taluka.id}">${taluka.name}</option>`);
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Crud\resources\views/auth/index.blade.php ENDPATH**/ ?>