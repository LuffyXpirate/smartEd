@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Enter Marks for Student</h2>

    <form method="POST" action="{{ route('marks.store') }}">
        @csrf
        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                @endforeach
            </select>
        </div>
    
        <div class="form-group">
            <label for="exam_type">Exam Type</label>
            <select name="exam_type" id="exam_type" class="form-control" required>
                <option value="weekly_test">Weekly Test</option>
                <option value="monthly_test">Monthly Test</option>
                <option value="term_exam">Term Exam</option>
                <option value="annual_exam">Annual Exam</option>
            </select>
        </div>
    
        <div class="form-group">
            <label for="exam_date">Exam Date</label>
            <input type="date" name="exam_date" id="exam_date" class="form-control" required>
        </div>
    
        <div class="form-group">
            <label>Subjects & Marks</label>
            <table class="table">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks Obtained (Max 100)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $index => $subject)
                        <tr>
                            <td>{{ $subject->subject_name }}</td>
                            <td>
                                <input type="number" 
                                       name="marks[{{ $index }}][marks_obtained]" 
                                       class="form-control" 
                                       required 
                                       min="0" 
                                       max="100">
                                <input type="hidden" 
                                       name="marks[{{ $index }}][subject_id]" 
                                       value="{{ $subject->id }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <button type="submit" class="btn btn-primary">Save Marks</button>
    </form>
</div>
@endsection
