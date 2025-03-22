@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient text-white text-center" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h2 class="text-black bold-2">Add New Subject</h2>
                </div>
                <div class="card-body p-4">
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">📘 Subject Name</label>
                            <input type="text" class="form-control shadow-sm" id="name" name="name" required placeholder="Enter subject name">
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label fw-semibold">🔢 Subject Code</label>
                            <input type="text" class="form-control shadow-sm" id="code" name="code" required placeholder="Enter subject code">
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">✔ Save Subject</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3">
                <a href="{{ url('subject/list') }}" class="btn btn-outline-dark btn-sm shadow-sm">🔙 Back to Subject List</a>
            </div>
        </div>
    </div>
</div>
@endsection