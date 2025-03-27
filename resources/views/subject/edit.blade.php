@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Subject</h2>
    <form action="{{ route('subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Subject Name</label>
            <input type="text" name="subject_name" class="form-control" 
                   value="{{ old('subject_name', $subject->subject_name) }}" required>
        </div>

        <div class="form-group">
            <label>Associated Classes</label>
            <div class="row">
                @foreach($classes as $class)
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="class_ids[]" value="{{ $class->id }}"
                               {{ $subject->classes->contains($class->id) ? 'checked' : '' }}>
                        <label class="form-check-label">
                            {{ $class->class_name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Subject</button>
    </form>
</div>
@endsection