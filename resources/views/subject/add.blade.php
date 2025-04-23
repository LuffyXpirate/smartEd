@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ isset($subject) ? 'Edit' : 'Add New' }} Subject</h2>
    
    <form action="{{ isset($subject) ? route('subjects.update', $subject->id) : route('subjects.store') }}" method="POST">
        @csrf
        @if(isset($subject))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Subject Name</label>
            <input type="text" name="subject_name" class="form-control" 
                   value="{{ old('subject_name', $subject->subject_name ?? '') }}" required>
            @error('subject_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Associated Classes</label>
            @error('class_ids')
                <div class="text-danger">{{ $message }}</div>
            @enderror
            <div class="row">
                @foreach($classes as $class)
                <div class="col-md-3 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="class_ids[]" value="{{ $class->id }}"
                               @if(isset($subject) && $subject->classes->contains($class->id)) checked @endif>
                        <label class="form-check-label">
                            Class {{ $class->class_name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ isset($subject) ? 'Update' : 'Add' }} Subject
        </button>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection