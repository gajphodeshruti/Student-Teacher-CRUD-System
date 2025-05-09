<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Birtdate</th>
            <th>Gender</th>
            <th>Class</th>
            <th>State</th>
            <th>District</th>
            <th>Taluka</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->birthdate }}</td>
            <td>{{ $student->gender }}</td>
            <td>{{ $student->class }}</td>
            <td>{{ $student->state->name ?? 'N/A' }}</td>
            <td>{{ $student->district->name ?? 'N/A' }}</td>
            <td>{{ $student->taluka->name ?? 'N/A' }}</td>

        </tr>
            
        @endforeach
    </tbody>
</table>