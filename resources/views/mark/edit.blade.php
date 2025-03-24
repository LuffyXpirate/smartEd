@extends('Layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Marks</h1>
                    </div>
                </div>
            </div>
        </section>

        <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('marks.update', $mark->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Student Name</label>
                            <input type="text" class="form-control" 
                                   value="{{ $mark->student->first_name }} {{ $mark->student->last_name }}" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Subject</label>
                            <input type="text" class="form-control" 
                                   value="{{ $mark->subject->subject_name }}" disabled>
                        </div>
                    </div>
                
                    <div class="row g-3 mt-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Exam Type</label>
                            <input type="text" class="form-control" 
                                   value="{{ $mark->exam_type }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Total Marks</label>
                            <input type="number" class="form-control" 
                                   value="100" disabled>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Marks Obtained</label>
                            <input type="number" name="marks_obtained" 
                                   class="form-control" 
                                   value="{{ $mark->marks_obtained }}" 
                                   required min="0" max="100">
                        </div>
                    </div>
                
                    <div class="mt-3 text-end">
                        <button type="submit" class="btn btn-primary">Update Marks</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
