<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
         
         table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Filtered Student List</h2>
    <table width="100%">
        <thead>
            <tr>
                <th>S/N</th>
                <th>Name</th>
                <th>Email</th>
                <th>Birthdate</th>
                <th>Gender</th>
                <th>Class</th>
                <th>State</th>
                <th>District</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($key + 1); ?></td>
                    <td><?php echo e($student->name); ?></td>
                    <td><?php echo e($student->email); ?></td>
                    <td><?php echo e(\Carbon\Carbon::parse($student->dob)->format('d-m-Y')); ?></td>
                    <td><?php echo e($student->gender); ?></td>
                    <td><?php echo e($student->class); ?></td>
                    <td><?php echo e($student->state->name); ?></td>
                    <td><?php echo e($student->district->name); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\Crud\resources\views/Students/pdf.blade.php ENDPATH**/ ?>