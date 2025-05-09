 <!-- Assuming you have a layout that includes a header and sidebar -->

<?php $__env->startSection('main'); ?>
<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-graduation-cap"></i>
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
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
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
                                <img class="img-profile rounded-circle" src="<?php echo e(asset('profile_images/' . Auth::user()->profile_image)); ?>">
                            <?php else: ?>
                                <img class="img-profile rounded-circle" src="<?php echo e(asset('default-user.png')); ?>">
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

            <!-- Dashboard Content -->
            <div class="container-fluid">
                <div class="row">
                    <!-- Total Students Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100 py-2" style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);">
                            <div class="card-body text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 1rem;">Total Students</div>
                                        <div class="h4 mb-0 font-weight-bold"><?php echo e($students); ?></div>
                                    </div>
                                    <div>
                                        <i class="fas fa-user-graduate fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Teachers Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100 py-2" style="background: linear-gradient(135deg, #1cc88a 0%, #17a673 100%);">
                            <div class="card-body text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 1rem;">Total Teachers</div>
                                        <div class="h4 mb-0 font-weight-bold"><?php echo e($teachers); ?></div>
                                    </div>
                                    <div>
                                        <i class="fas fa-chalkboard-teacher fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    

                    <!-- Total Students + Teachers Card -->
                    <div class="col-md-4 mb-4">
                        <div class="card border-0 shadow-lg h-100 py-2" style="background: linear-gradient(135deg, #36b9cc 0%, #2c9faf 100%);">
                            <div class="card-body text-white">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs font-weight-bold text-uppercase mb-1" style="font-size: 1rem;">User</div>
                                        <div class="h4 mb-0 font-weight-bold"><?php echo e($students+$teachers); ?></div>
                                    </div>
                                    <div>
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Crud\resources\views/auth/dashboard.blade.php ENDPATH**/ ?>