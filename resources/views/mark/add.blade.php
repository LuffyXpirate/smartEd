<!-- Student Marks Management UI - Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center fw-bold mb-4">Enter Marks for Student</h2>
        
        <form method="POST" action="{{ route('marks.store') }}">
            @csrf
            
            <!-- Student Selection -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Select Student</label>
                <select id="studentDropdown" name="student_id" class="form-select" required onchange="updateRollNo(this.value)">
                    <option value="">-- Select Student --</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" data-rollno="{{ $student->roll_no }}">
                            {{ $student->first_name }} {{ $student->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Subject & Exam Type -->
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Select Subject</label>
                    <select id="subjectDropdown" name="subject_id" class="form-select" required>
                        <option value="">-- Select Subject --</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->subject_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Exam Type</label>
                    <select id="examTypeDropdown" name="exam_type" class="form-select" required>
                        <option value="">-- Select Exam Type --</option>
                        <option value="Test">Test</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Annual">Annual</option>
                    </select>
                </div>
            </div>
            
            <!-- Marks & Exam Date -->
            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Marks Obtained</label>
                    <input type="number" name="total_marks" class="form-control" required placeholder="Enter Marks">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Exam Date</label>
                    <input type="date" name="exam_date" class="form-control" required>
                </div>
            </div>
            
            <!-- Submit & Back Buttons -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ url('marks/list') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Save Marks
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function updateRollNo(studentId) {
        const studentDropdown = document.getElementById("studentDropdown");
        const selectedOption = studentDropdown.options[studentDropdown.selectedIndex];
        const rollNo = selectedOption.getAttribute("data-rollno");
        alert("Selected Student Roll No: " + rollNo);
    }
</script>
