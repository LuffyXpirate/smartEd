@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-gradient text-white text-center" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                    <h2 class="text-black">Subject List</h2>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>S.N</th>
                                <th>Subject Name</th>
                                <th>Classes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subject->subject_name }}</td>
                                    <td>
                                        @foreach($subject->classSubjects as $classSubject)
                                            <span class="badge bg-primary me-1">
                                                {{ $classSubject->class }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('subject.delete', $subject->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            <a href="{{ route('test') }}">test</a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="{{ route('subject.add') }}" class="btn btn-primary">Add New Subject</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection