<!DOCTYPE html>
<html lang="mr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'NotoSansDevanagari', sans-serif;
            font-size: 14px;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Teacher List</h2>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Birthdate</th>
            <th>Mobile No</th>
            <th>Gender</th>
            <th>State</th>
            <th>University</th>
            <th>College</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key+1); ?></td>
                <td><?php echo e($teacher->name); ?></td>
                <td><?php echo e($teacher->email); ?></td>
                <td><?php echo e($teacher->birthdate); ?></td>
                <td><?php echo e($teacher->mobileno); ?></td>
                <td><?php echo e($teacher->gender); ?></td>
                <td><?php echo e($teacher->state->name ?? ''); ?></td>
                <td><?php echo e($teacher->university->name ?? ''); ?></td>
                <td><?php echo e($teacher->college->name ?? ''); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

</body>
</html>
<?php /**PATH D:\xampp\htdocs\Crud\resources\views/teacher/pdf.blade.php ENDPATH**/ ?>