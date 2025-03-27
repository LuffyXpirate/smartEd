@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Marks</h2>
    <form action="{{ route('marks.update', $mark) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Class</label>
                    <select name="class_id" id="class_id" class="form-control" required>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ $mark->class_id == $class->id ? 'selected' : '' }}>
                                {{ $class->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Student</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ $mark->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->first_name }} {{ $student->last_name }} (Roll No: {{ $student->roll_no }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Subject</label>
                    <select name="subject_id" id="subject_id" class="form-control" required>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $mark->subject_id == $subject->id ? 'selected' : '' }}>
                                {{ $subject->subject_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Marks Obtained</label>
                    <input type="number" name="marks_obtained" class="form-control" 
                           value="{{ $mark->marks_obtained }}" required>
                </div>
            </div>

            <select name="exam_type" class="form-control" required>
                @foreach($examTypes as $type)
                    <option value="{{ $type }}" {{ $mark->exam_type == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Exam Date</label>
                    <input type="date" name="exam_date" class="form-control" 
                           value="{{ $mark->exam_date->format('Y-m-d') }}" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection