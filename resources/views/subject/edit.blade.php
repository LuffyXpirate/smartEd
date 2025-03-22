@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient text-white text-center" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h2 class="text-black">Edit Subject</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('subject.update', $subject->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">📘 Subject Name</label>
                            <input type="text" class="form-control shadow-sm" id="name" name="name" value="{{ $subject->subject_name }}" required placeholder="Enter subject name">
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold">🔢 Subject Code</label>
                            <input type="text" class="form-control shadow-sm" id="code" name="code" value="{{ $subject->Subject_code }}" required placeholder="Enter subject code">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">Update Subject</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
