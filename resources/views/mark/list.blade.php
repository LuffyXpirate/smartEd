@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h2 class="mb-0">Student Marks</h2>
            </div>
            <div class="card-body">
                <!-- Add Marks Button -->
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('marks.add') }}" class="btn btn-primary d-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i> Add Marks
                    </a>
                </div>

                <!-- Marks Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>Student</th>
                                <th>Class</th>
                                <th>Subject</th>
                                <th>Exam Type</th>
                                <th>Marks</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($marks as $mark)
                                <tr>
                                    <td>{{ $mark->student->first_name }} {{ $mark->student->last_name }}</td>
                                    <td>{{ $mark->student->class }}</td>
                                    <td>{{ $mark->subject->subject_name }}</td>
                                    <td>{{ $mark->exam_type }}</td>
                                    <td class="fw-bold text-primary">{{ $mark->marks_obtained }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mark->exam_date)->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('marks.edit', $mark->id) }}"
                                            class="btn btn-sm btn-success">Edit</a>
                                        <form action="{{ route('marks.delete', $mark->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No marks records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
