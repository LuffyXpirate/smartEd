@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Subjects Management</h2>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Subject
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Subject Name</th>
                            <th>Associated Classes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subjects as $subject)
                        <tr>
                            <td>{{ $subject->id }}</td>
                            <td>{{ $subject->subject_name }}</td>
                            <td>
                                @if($subject->classes->count() > 0)
                                    @foreach($subject->classes as $class)
                                    <span class="badge bg-primary text-white me-1">
                                        {{ $class->class_name ?? 'N/A' }}
                                    </span>
                                    
                                    @endforeach
                                @else
                                    <span class="text-muted">No classes assigned</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('subjects.edit', $subject->id) }}" 
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('subjects.destroy', $subject->id) }}" 
                                      method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No subjects found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $subjects->links() }}
        </div>
    </div>
</div>
@endsection
