@extends('layouts.app')

@section('content')
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if ($marks->isNotEmpty())
    <a href="{{ route('students.marks.index', $student->id) }}" class="nav-link">
        Marks for {{ $student->first_name }} {{ $student->last_name }}
    </a>
    
        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Terminal</th>
                    <th>Marks Obtained</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marks as $mark)
                    <tr>
                        <td>{{ $mark->subject->subject_name }}</td>
                        <td>{{ $mark->terminal->name }}</td>
                        <td>{{ $mark->marks_obtained }}</td>
                        <td>
                            <td>
                                <a href="{{ route('students.marks.edit', [$student->id, $mark->id]) }}">Edit</a>
                                <form action="{{ route('students.marks.destroy', [$student->id, $mark->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                                                        
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('students.marks.create', $student->id) }}">Add Marks</a>
        @else
        <p>No marks found for this student.</p>
    @endif
@endsection
