@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Subject List</h2>
    <a href="{{ route('subjects.create') }}" class="btn btn-primary mb-3">Add New Subject</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Subject Name</th>
                <th>Associated Classes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subjects as $subject)
            <tr>
                <td>{{ $subject->id }}</td>
                <td>{{ $subject->subject_name }}</td>
                <td>
                    @foreach($subject->classes as $class)
                    <span class="badge bg-primary">{{ $class->class_name }}</span>
                    @endforeach
                </td>
                <td>
                    <a href="{{ route('subjects.edit', $subject) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection