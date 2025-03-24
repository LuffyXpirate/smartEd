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

                    <form action="{{ route('subject.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label>Subject Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                    
                        <div class="mb-3">
                            <label>Select Classes</label>
                            <div class="row">
                                @foreach(range(5, 10) as $grade)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           name="classes[]" 
                                           value="Class {{ $grade }}" 
                                           id="class{{ $grade }}">
                                    <label class="form-check-label" for="class{{ $grade }}">
                                        Class {{ $grade }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    
                        <button type="submit" class="btn btn-primary">Save Subject</button>
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
