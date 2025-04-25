@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Student Marks</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('marks.store') }}" method="POST">
                @csrf

                <div class="row g-3 mb-4">
                    <!-- Class Selection -->
                    <div class="col-md-4">
                        <label for="class_id" class="form-label">Class</label>
                        <select id="class_id" name="class_id" class="form-select" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Student Selection -->
                    <div class="col-md-4">
                        <label for="student_id" class="form-label">Student</label>
                        <select name="student_id" id="student_id" class="form-select" required disabled>
                            <option value="">Select Class First</option>
                        </select>
                    </div>

                    <!-- Subject Selection -->
                    <div class="col-md-4">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select name="subject_id" id="subject_id" class="form-select" required disabled>
                            <option value="">Select Class First</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <!-- Exam Type -->
                    <div class="col-md-4">
                        <label for="exam_type" class="form-label">Exam Type</label>
                        <select name="exam_type" id="exam_type" class="form-select" required>
                            <option value="">Select Exam Type</option>
                            @foreach($examTypes as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Marks Obtained -->
                    <div class="col-md-4">
                        <label for="marks_obtained" class="form-label">Marks Obtained</label>
                        <input type="number" class="form-control" name="marks_obtained" 
                               id="marks_obtained" min="0" max="100" required>
                    </div>
                    
                    <!-- Exam Date -->
                    <div class="col-md-4">
                        <label for="exam_date" class="form-label">Exam Date</label>
                        <input type="date" class="form-control" name="exam_date" id="exam_date" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-save me-2"></i>Save Marks
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const classSelect = document.getElementById('class_id');
    const studentSelect = document.getElementById('student_id');
    const subjectSelect = document.getElementById('subject_id');

    classSelect.addEventListener('change', function() {
        const classId = this.value;
        
        // Reset and disable dependent fields
        [studentSelect, subjectSelect].forEach(select => {
            select.innerHTML = '<option value="">Loading...</option>';
            select.disabled = true;
        });

        if (!classId) {
            [studentSelect, subjectSelect].forEach(select => {
                select.innerHTML = '<option value="">Select Class First</option>';
                select.disabled = true;
            });
            return;
        }

        // Fetch students for selected class
        fetch(`/api/classes/${classId}/students`)
            .then(response => response.json())
            .then(students => {
                studentSelect.innerHTML = students.length 
                    ? '<option value="">Select Student</option>' 
                    : '<option value="">No students found</option>';
                
                students.forEach(student => {
                    studentSelect.innerHTML += `
                        <option value="${student.id}">
                            ${student.full_name} (${student.roll_no})
                        </option>
                    `;
                });
                studentSelect.disabled = false;
            });

        // Fetch subjects for selected class
        fetch(`/api/classes/${classId}/subjects`)
            .then(response => response.json())
            .then(subjects => {
                subjectSelect.innerHTML = subjects.length 
                    ? '<option value="">Select Subject</option>' 
                    : '<option value="">No subjects found</option>';
                
                subjects.forEach(subject => {
                    subjectSelect.innerHTML += `
                        <option value="${subject.id}">
                            ${subject.subject_name}
                        </option>
                    `;
                });
                subjectSelect.disabled = false;
            });
    });
});
</script>
@endsection