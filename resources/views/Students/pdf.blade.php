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
                <th>Taluka</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $key => $student)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($student->dob)->format('d-m-Y') }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->class }}</td>
                    <td>{{ $student->state->name }}</td>
                    <td>{{ $student->district->name }}</td>
                    <td>{{ $student->taluka->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
