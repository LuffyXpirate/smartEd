@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center text-primary">Manage Marks</h2>
    
    <a href="{{ route('marks.create') }}" class="btn btn-success mb-3"><i class="fas fa-plus"></i> Add Marks</a>
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>id</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Marks</th>
                    <th>Exam Type</th>
                    <th>Exam Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($marks as $mark)
                <tr>
                    <td>{{ $mark->id }}</td>
                    <td>{{ $mark->student->first_name }} {{ $mark->student->last_name }}</td>
                    <td>{{ $mark->subject->subject_name ?? 'N/A' }}</td>
                    <td>{{ $mark->student->studentClass->class_name ?? 'N/A' }}</td>
                    <td>{{ $mark->marks_obtained }}</td>
                    <td>{{ $mark->exam_type }}</td>
                    <td>{{ $mark->formatted_exam_date }}</td>
                    <td class="d-flex justify-content-start">
                        <a href="{{ route('marks.edit', $mark) }}" class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('marks.destroy', $mark) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $marks->links() }}
    </div>
</div>
@endsection
