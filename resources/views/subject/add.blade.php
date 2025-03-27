@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Subject</h2>
    
    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Subject Name</label>
            <input type="text" name="subject_name" class="form-control" 
                   value="{{ old('subject_name') }}" required>
        </div>

        <div class="form-group">
            <label>Associated Classes</label>
            <div class="row">
                @foreach($classes as $class)
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="class_ids[]" value="{{ $class->id }}">
                        <label class="form-check-label">
                            {{ $class->class_name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-success">Add Subject</button>
    </form>
</div>
@endsection
