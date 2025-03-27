@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Marks</h2>
    <form action="{{ route('marks.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Class</label>
                    <select id="class_id" class="form-control" required>
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Student</label>
                    <select name="student_id" id="student_id" class="form-control" required>
                        <option value="">Select Student</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Subject</label>
                    <select name="subject_id" id="subject_id" class="form-control" required>
                        <option value="">Select Subject</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Marks Obtained</label>
                    <input type="number" name="marks_obtained" class="form-control" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Exam Type</label>
                    <select name="exam_type" class="form-control" required>
                        @foreach($examTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label>Exam Date</label>
                    <input type="date" name="exam_date" class="form-control" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    
    classSelect.addEventListener('change', function() {
        const classId = this.value;
        
        // Fetch Students
        fetch(`/marks/${classId}/students`)
            .then(response => response.json())
            .then(students => {
                const studentSelect = document.getElementById('student_id');
                studentSelect.innerHTML = '<option value="">Select Student</option>';
                students.forEach(student => {
                    studentSelect.innerHTML += `
                        <option value="${student.id}">
                            ${student.first_name} ${student.last_name} (Roll No: ${student.roll_no})
                        </option>`;
                });
            });

        // Fetch Subjects
        fetch(`/marks/${classId}/subjects`)
            .then(response => response.json())
            .then(subjects => {
                const subjectSelect = document.getElementById('subject_id');
                subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                subjects.forEach(subject => {
                    subjectSelect.innerHTML += `<option value="${subject.id}">${subject.subject_name}</option>`;
                });
            });
    });
});
</script>
@endsection