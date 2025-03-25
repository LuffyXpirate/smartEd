@extends('layouts.app')

@section('content')
    <h1>Add Marks for Student: {{ $student->first_name }} {{ $student->last_name }}</h1>

    <form action="{{ route('students.marks.store', $student->id) }}" method="POST">
        @csrf
        <input type="hidden" name="student_id" value="{{ $student->id }}">

        <!-- Select Class Subject -->
        <div>
            <label for="class_subject_id">Class</label>
            <select name="class_subject_id" id="class_subject_id" required>
                <option value="">Select Class</option>
                @foreach($classSubjects as $classSubject)
                    <option value="{{ $classSubject->id }}">{{ $classSubject->class }}</option>
                @endforeach
            </select>
        </div>

        <!-- Select Subject -->
        <div>
            <label for="subject_id">Subject</label>
            <select name="subject_id" id="subject_id" required>
                <option value="">Select Subject</option>
                <!-- Dynamic options will be populated here based on class -->
            </select>
        </div>

        <!-- Select Terminal -->
        <div>
            <label for="terminal_id">Terminal</label>
            <select name="terminal_id" required>
                @foreach($terminals as $terminal)
                    <option value="{{ $terminal->id }}">{{ $terminal->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Marks Obtained -->
        <div>
            <label for="marks_obtained">Marks Obtained</label>
            <input type="number" name="marks_obtained" required min="0" max="100">
        </div>

        <button type="submit">Save</button>
    </form>

    <script>
        document.getElementById('class_subject_id').addEventListener('change', function() {
            let classId = this.value;
            let subjectSelect = document.getElementById('subject_id');
            
            // Clear existing subjects
            subjectSelect.innerHTML = '<option value="">Select Subject</option>';

            if (classId) {
                // Filter subjects based on selected class
                let classSubjects = @json($classSubjects);
                let filteredSubjects = classSubjects.filter(function(classSubject) {
                    return classSubject.id == classId;
                });

                // Populate subjects
                filteredSubjects.forEach(function(classSubject) {
                    let option = document.createElement('option');
                    option.value = classSubject.subject_id;
                    option.textContent = classSubject.subject_name;
                    subjectSelect.appendChild(option);
                });
            }
        });
    </script>
@endsection
