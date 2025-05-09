

<?php $__env->startSection('main'); ?>


1<section class="section-5">
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
                    <h1 class="h3">Edit Teacher</h1>
                    <form action="<?php echo e(route('teacher.update', $teacher->id)); ?>" method="POST" id="registrationform">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name">Name*</label>
                                <input id="name" type="text" name="name" class="form-control"
                                       value="<?php echo e(old('name', $teacher->name)); ?>" placeholder="Enter name">
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
                                <input id="email" type="email" name="email" class="form-control"
                                       value="<?php echo e(old('email', $teacher->email)); ?>" placeholder="Enter email">
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
                                <input id="birthdate" type="date" name="birthdate" class="form-control"
                                value="<?php echo e(old('birthdate', \Carbon\Carbon::parse($teacher->birthdate)->format('Y-m-d'))); ?>">
                                <?php $__errorArgs = ['birthdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="gender">Gender*</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php echo e(old('gender', $teacher->gender) == 'Male' ? 'selected' : ''); ?>>Male</option>
                                    <option value="Female" <?php echo e(old('gender', $teacher->gender) == 'Female' ? 'selected' : ''); ?>>Female</option>
                                    <option value="Other" <?php echo e(old('gender', $teacher->gender) == 'Other' ? 'selected' : ''); ?>>Other</option>
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
                                <label for="mobileno">Mobile No*</label>
                                <input id="mobileno" type="text" name="mobileno" class="form-control"
                                       value="<?php echo e(old('mobileno', $teacher->mobileno)); ?>" placeholder="Enter Mobile No">
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
                                <select id="state_id" name="state_id" class="form-control">
                                    <option value="">Select State</option>
                                    <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($state->id); ?>" <?php echo e(old('state_id', $teacher->state_id) == $state->id ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
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
                                <label for="university_id">University*</label>
                                <select id="university_id" name="university_id" class="form-control">
                                    <option value="">Select University</option>
                                </select>
                                <?php $__errorArgs = ['university_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label for="college_id">College*</label>
                                <select id="college_id" name="college_id" class="form-control">
                                    <option value="">Select College</option>
                                </select>
                                <?php $__errorArgs = ['college_id'];
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
        function fetchUniversities(stateID, selectedID = '') {
            if (stateID) {
                $('#university_id').html('<option>Loading...</option>');
                $.getJSON('/get-university/' + stateID)
                    .done(function (data) {
                        $('#university_id').empty().append('<option value="">Select University</option>');
                        $.each(data, function (key, value) {
                            $('#university_id').append('<option value="' + key + '"' + (key == selectedID ? ' selected' : '') + '>' + value + '</option>');
                        });
                    })
                    .fail(function () {
                        alert("Error loading universities.");
                        $('#university_id').html('<option value="">Select University</option>');
                    });
            } else {
                $('#university_id').html('<option value="">Select University</option>');
            }
        }
    
        function fetchColleges(universityID, selectedID = '') {
            if (universityID) {
                $('#college_id').html('<option>Loading...</option>');
                $.getJSON('/get-college/' + universityID)
                    .done(function (data) {
                        $('#college_id').empty().append('<option value="">Select College</option>');
                        $.each(data, function (index, college) {
                            // Assuming 'college' contains the object with name and id
                            $('#college_id').append('<option value="' + college.id + '"' + (college.id == selectedID ? ' selected' : '') + '>' + college.name + '</option>');
                        });
                    })
                    .fail(function () {
                        alert("Error loading colleges.");
                        $('#college_id').html('<option value="">Select College</option>');
                    });
            } else {
                $('#college_id').html('<option value="">Select College</option>');
            }
        }
    
        let selectedState = '<?php echo e(old("state_id", $teacher->state_id)); ?>';
        let selectedUniversity = '<?php echo e(old("university_id", $teacher->university_id)); ?>';
        let selectedCollege = '<?php echo e(old("college_id", $teacher->college_id)); ?>';
    
        if (selectedState) {
            fetchUniversities(selectedState, selectedUniversity);
        }
    
        if (selectedUniversity) {
            fetchColleges(selectedUniversity, selectedCollege);
        }
    
        $('#state_id').change(function () {
            let stateID = $(this).val();
            $('#college_id').html('<option value="">Select College</option>');
            fetchUniversities(stateID);
        });
    
        $('#university_id').change(function () {
            let universityID = $(this).val();
            fetchColleges(universityID);
        });
    });
    </script>
 <?php $__env->stopSection(); ?>    
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Crud\resources\views/teacher/edit.blade.php ENDPATH**/ ?>