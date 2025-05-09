

<?php $__env->startSection('main'); ?>


<section class="section-5">
    <div class="container my-5">    
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Add Student</h1>

                    
                    <form action="<?php echo e(route('students.update', $student->id)); ?>" method="POST" id="registrationform">
                        <?php echo csrf_field(); ?>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name">Name*</label>
                                <input type="text" name="name" class="form-control" value="<?php echo e(old('name', $student->name ?? '')); ?>" placeholder="Enter name">
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
                                <input type="date" name="birthdate" class="form-control" value="<?php echo e(old('birthdate', \Carbon\Carbon::parse($student->birthdate)->format('Y-m-d'))); ?>">
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
                                <input type="text" name="class" class="form-control" value="<?php echo e(old('class', $student->class ?? '')); ?>" placeholder="Enter class">
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


<?php $__env->stopSection(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        // Check for the selected state on page load
        var stateID = $('#state_id').val();
        var districtID = "<?php echo e(old('district_id', $student->district_id ?? '')); ?>";
        var talukaID = "<?php echo e(old('taluka_id', $student->taluka_id ?? '')); ?>";
    
        // If state is selected, trigger district fetch
        if (stateID) {
            fetchDistricts(stateID, districtID);
        }
    
        // Listen for changes in state
        $('#state_id').change(function () {
            var selectedState = $(this).val();
            fetchDistricts(selectedState);
        });
    
        // Listen for changes in district
        $('#district_id').change(function () {
            var selectedDistrict = $(this).val();
            fetchTalukas(selectedDistrict);
        });
    
        function fetchDistricts(stateID, selectedDistrict = null) {
            $.ajax({
                url: '/get-districts/' + stateID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#district_id').empty().append('<option value="">Select District</option>');
                    $.each(data, function (key, value) {
                        var selected = (key == selectedDistrict) ? 'selected' : '';
                        $('#district_id').append('<option value="' + key + '" ' + selected + '>' + value + '</option>');
                    });
    
                    if (selectedDistrict) {
                        fetchTalukas(selectedDistrict, talukaID);
                    }
                }
            });
        }
    
        function fetchTalukas(districtID, selectedTaluka = null) {
            $.ajax({
                url: '/get-talukas/' + districtID,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#taluka_id').empty().append('<option value="">Select Taluka</option>');
                    $.each(data, function (index, taluka) {
                        var selected = (taluka.id == selectedTaluka) ? 'selected' : '';
                        $('#taluka_id').append('<option value="' + taluka.id + '" ' + selected + '>' + taluka.name + '</option>');
                    });
                }
            });
        }
    });
    </script>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp\htdocs\Crud\resources\views/students/edit.blade.php ENDPATH**/ ?>