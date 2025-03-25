@extends('layouts.app')

@section('content')
    <h1>Edit Marks for Student: {{ $mark->student->first_name }} {{ $mark->student->last_name }}</h1>

    <form action="{{ route('students.marks.update', [$mark->student_id, $mark->id]) }}" method="POST">
            @csrf
        @method('PUT')

        <div>
            <label for="subject_id">Subject</label>
            <select name="subject_id">
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $subject->id == $mark->subject_id ? 'selected' : '' }}>{{ $subject->subject_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="class_subject_id">Class</label>
            <select name="class_subject_id">
                @foreach($classSubjects as $classSubject)
                    <option value="{{ $classSubject->id }}" {{ $classSubject->id == $mark->class_subject_id ? 'selected' : '' }}>{{ $classSubject->class }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="terminal_id">Terminal</label>
            <select name="terminal_id">
                @foreach($terminals as $terminal)
                    <option value="{{ $terminal->id }}" {{ $terminal->id == $mark->terminal_id ? 'selected' : '' }}>{{ $terminal->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="marks_obtained">Marks Obtained</label>
            <input type="number" name="marks_obtained" value="{{ $mark->marks_obtained }}" min="0" max="100">
        </div>

        <button type="submit">Update</button>
    </form>
@endsection
