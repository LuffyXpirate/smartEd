@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <h2 class="h3 mb-0 text-center">Edit Subject: {{ $subject->subject_name }}</h2>
                </div>
                <div class="card-body p-5">
                    <form method="POST" action="{{ route('subjects.update', $subject->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label">Subject Name</label>
                            <input type="text" class="form-control" name="subject_name" value="{{ old('subject_name', $subject->subject_name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Classes</label>
                            <div class="row">
                                @php
                                    $selectedClasses = explode(',', $subject->class);
                                @endphp
                                @foreach ($classes as $class)
                                    <div class="col-md-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="class[]" value="{{ $class }}"
                                                {{ in_array($class, old('class', $selectedClasses)) ? 'checked' : '' }}>
                                            <label class="form-check-label">{{ $class }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Subject</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
