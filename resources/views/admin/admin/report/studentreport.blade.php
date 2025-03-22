@extends('layouts.app')

@section('content')

<body>
    <div class="header">
        <h2>{{ config('app.name') }}</h2>
        <h3>Student Progress Report</h3>
    </div>

    <div class="student-info">
        <p><strong>Name:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
        <p><strong>Class:</strong> {{ $student->class->name }}</p>
        <p><strong>Roll No:</strong> {{ $student->roll_number }}</p>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Exam Type</th>
                <th>Marks Obtained</th>
                <th>Total Marks</th>
                <th>Exam Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->marks as $mark)
            <tr>
                <td>{{ $mark->subject->name }}</td>
                <td>{{ $mark->exam_type }}</td>
                <td>{{ $mark->total_marks }}</td>
                <td>100</td>
                <td>{{ $mark->exam_date->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary mt-4">
        <p><strong>Total Marks:</strong> {{ $student->marks->sum('total_marks') }}</p>
        <p><strong>Percentage:</strong> {{ number_format(($student->marks->sum('total_marks') / (count($student->marks) * 100)), 2) }}%</p>
    </div>
</body>
@endsection