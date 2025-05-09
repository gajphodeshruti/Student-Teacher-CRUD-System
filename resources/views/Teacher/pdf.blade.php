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
        @foreach($teachers as $key => $teacher)
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $teacher->name }}</td>
                <td>{{ $teacher->email }}</td>
                <td>{{ $teacher->birthdate }}</td>
                <td>{{ $teacher->mobileno }}</td>
                <td>{{ $teacher->gender }}</td>
                <td>{{ $teacher->state->name ?? '' }}</td>
                <td>{{ $teacher->university->name ?? '' }}</td>
                <td>{{ $teacher->college->name ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
