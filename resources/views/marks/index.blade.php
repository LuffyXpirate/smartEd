@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4 text-center text-primary">📋 Manage Marks</h2>

    <div class="text-end mb-3">
        <a href="{{ route('marks.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-1"></i> Add Marks
        </a>
    </div>

    <div class="table-responsive shadow rounded bg-white">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
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
                    <td class="text-center">{{ $mark->id }}</td>
                    <td>{{ $mark->student->first_name }} {{ $mark->student->last_name }}</td>
                    <td>{{ $mark->subject->subject_name ?? 'N/A' }}</td>
                    <td>{{ $mark->student->studentClass->class_name ?? 'N/A' }}</td>
                    <td class="text-center fw-semibold text-primary">{{ $mark->marks_obtained }}</td>
                    <td class="text-center">
                        <span class="badge bg-info text-dark text-capitalize">
                            {{ str_replace('_', ' ', $mark->exam_type) }}
                        </span>
                    </td>
                    <td class="text-center">
                        <i class="far fa-calendar-alt me-1 text-muted"></i>
                        {{ $mark->formatted_exam_date ?? \Carbon\Carbon::parse($mark->exam_date)->format('d M, Y') }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('marks.edit', $mark) }}" class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('marks.destroy', $mark) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure you want to delete this record?')">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $marks->links() }}
    </div>
</div>
@endsection
