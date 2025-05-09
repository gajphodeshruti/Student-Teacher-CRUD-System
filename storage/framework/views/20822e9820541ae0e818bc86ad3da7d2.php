

<?php $__env->startSection('main'); ?>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
      </a>

      <hr class="sidebar-divider my-0">

      <!-- Nav Items -->
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
    <!-- End of Sidebar -->

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
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search..."
                      aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <?php if(auth()->guard()->check()): ?>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e(Auth::user()->name); ?></span>
                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo e(url('/profile')); ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                </a>
              </div>
            </li>
            <?php endif; ?>
          </ul>
        </nav>
        <!-- End of Topbar -->

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800"></h1>
          <div>
            <a href="<?php echo e(route('teachers.export.pdf',request()->query())); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fas fa-download fa-sm text-white-50"></i> Export to Pdf
            </a>
            <a href="<?php echo e(route('teachers.export.excel')); ?>?search=<?php echo e(request('search')); ?>&state_id=<?php echo e(request('state_id')); ?>&university_id=<?php echo e(request('university_id')); ?>&college_id=<?php echo e(request('college_id')); ?>" class="btn btn-sm btn-primary shadow-sm ms-2">
              <i class="fas fa-download fa-sm text-white-50"></i> Export to Excel
          </a>
          
          

            <a href="<?php echo e(route('teacher.create')); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm ms-2">
              <i class="fa-sm text-white-50"></i> +Create
            </a>
          </div>
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

            <!-- Teacher Filter Form -->
            <form method="GET" action="<?php echo e(route('teacher.index')); ?>">
              <div class="row">
                <div class="col-md-3">
                  <select name="state_id" id="state_id" class="form-control form-control-sm">
                    <option value="">Select State</option>
                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($state->id); ?>" <?php echo e(request('state_id') == $state->id ? 'selected' : ''); ?>>
                        <?php echo e($state->name); ?>

                      </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
            
                <div class="col-md-3">
                  <select name="university_id" id="university_id" class="form-control form-control-sm">
                    <option value="">Select University</option>
                    <?php if(request('state_id') && $universities): ?>
                      <?php $__currentLoopData = $universities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $university): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($university->id); ?>" <?php echo e(request('university_id') == $university->id ? 'selected' : ''); ?>>
                          <?php echo e($university->name); ?>

                        </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  </select>
                </div>
            
                <div class="col-md-3">
                  <select name="college_id" id="college_id" class="form-control form-control-sm">
                    <option value="">Select College</option>
                    <?php if(request('university_id') && $colleges): ?>
                      <?php $__currentLoopData = $colleges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $college): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($college->id); ?>" <?php echo e(request('college_id') == $college->id ? 'selected' : ''); ?>>
                          <?php echo e($college->name); ?>

                        </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
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
                  <a href="<?php echo e(route('teacher.index')); ?>" class="btn btn-secondary btn-sm mt-1">Cancel Filter</a>
                </div>
              </div>
            </form>
            
            <!-- Teacher List -->
        <div class="mt-3">
          <div class="card shadow border-0 p-4">
              <h1 class="h3">Teacher List</h1>
              <form method="GET" action="<?php echo e(route('teacher.index')); ?>">
                  <div class="input-group mb-3">
                      <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control form-control-sm" placeholder="Search...">
                      <button type="submit" class="btn btn-primary btn-sm">Search</button>
                      <a href="<?php echo e(route('teacher.index')); ?>" class="btn btn-secondary btn-sm ml-2">Reset</a>
                  </div>
              </form>



        <div class="container mt-4">
          <div class="card">
            
            <div class="card-body">
              <table class="table table-sm table-striped table-bordered">
                <thead>
                  <tr>
                    <th>S/N</th>
                    <th>Name</th>
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Mobileno</th>
                    <th>State ID</th>
                    <th>university ID</th>
                    <th>college ID</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if(isset($teachers) && count($teachers) > 0): ?>
                      <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <tr>
                              <td><?php echo e($teacher->id); ?></td>
                              <td><?php echo e($teacher->name); ?></td>
                              <td><?php echo e($teacher->birthdate); ?></td>
                              <td><?php echo e($teacher->gender); ?></td>
                              <td><?php echo e($teacher->mobileno); ?></td>
                              <td><?php echo e($teacher->state->name ?? 'N/A'); ?></td>
                              <td><?php echo e($teacher->university->name ?? 'N/A'); ?></td>
                              <td><?php echo e($teacher->college->name ?? 'N/A'); ?></td>
                              <td>
                                  <a href="<?php echo e(route('teacher.edit', $teacher->id)); ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i>Edit</a>
              
                                  <form action="<?php echo e(route('teacher.destroy', $teacher->id)); ?>" method="POST" style="display:inline;">
                                      <?php echo csrf_field(); ?>
                                      <?php echo method_field('DELETE'); ?>
                                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?')"> <i class="fas fa-trash-alt"></i>
                                          Delete
                                      </button>
                                  </form>
                              </td>
                          </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                      <tr>
                          <td colspan="9" class="text-center">No teachers found.</td>
                      </tr>
                  <?php endif; ?>
              </tbody>
                            </table>
                            <div class="mt-4">
                              <?php echo e($teachers->links()); ?>

                          </div>
            </div>
          </div>
        </div>

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2021</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
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

</body>

<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#state_id').on('change', function () {
      var stateID = $(this).val();
      $('#university_id').html('<option>Loading...</option>');
      $('#college_id').html('<option value="">Select College</option>');

      if (stateID) {
        $.ajax({
          url: '/get-university/' + stateID,
          type: "GET",
          dataType: "json",
          success: function (data) {
            $('#university_id').empty().append('<option value="">Select University</option>');
            $.each(data, function (key, value) {
              $('#university_id').append('<option value="' + key + '">' + value + '</option>');
            });

            // Trigger change to refresh college dropdown if needed
            $('#university_id').trigger('change');
          }
        });
      } else {
        $('#university_id').html('<option value="">Select University</option>');
        $('#college_id').html('<option value="">Select College</option>');
      }
    });

    $('#university_id').on('change', function () {
      var universityID = $(this).val();
      $('#college_id').html('<option>Loading...</option>');

      if (universityID) {
        $.ajax({
          url: '/get-college/' + universityID,
          type: "GET",
          dataType: "json",
          success: function (data) {
            $('#college_id').empty().append('<option value="">Select College</option>');
            $.each(data, function (index, college) {
              $('#college_id').append('<option value="' + college.id + '">' + college.name + '</option>');
            });
          }
        });
      } else {
        $('#college_id').html('<option value="">Select College</option>');
      }
    });

    // Trigger state change on load to retain filter selections
    <?php if(request('state_id')): ?>
        $('#state_id').trigger('change');
    <?php endif; ?>
  });
</script>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Crud\resources\views/teacher/index.blade.php ENDPATH**/ ?>