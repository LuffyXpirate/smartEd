@extends('Layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Student List (Total: {{ $students->total() }})</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <a href="{{ route('student.add') }}" class="btn btn-primary">Add New Student</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admin Form with Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ url('student/list') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ request('name') }}"
                                placeholder="Search by Name">
                        </div>
                        <div class="col-md-3">
                            <label for="class" class="form-label">Class</label>
                            <input type="text" class="form-control" name="class" value="{{ request('class') }}"
                                placeholder="Search by Class">
                        </div>
                        <div class="col-md-3">
                            <label for="roll_no" class="form-label">Roll No</label>
                            <input type="text" class="form-control" name="roll_no" value="{{ request('roll_no') }}"
                                placeholder="Search by Roll No">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100 me-2">
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
                            <a href="{{ url('student/list') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-sync-alt mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @include('message')
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Student List</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Roll No</th>
                                            <th>Class</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $student)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $student->first_name }}</td>
                                                <td>{{ $student->last_name }}</td>
                                                <td>{{ $student->roll_no }}</td>
                                                <td>{{ $student->class }}</td>
                                                <td>
                                                    <a href="{{ url('student/edit/' . $student->id) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <a href="{{ url('student/delete/' . $student->id) }}"
                                                        class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure?')">Delete</a>
                                                    <a href="{{ route('marks.student-report', $student->id) }}" 
                                                       class="btn btn-info btn-sm">
                                                       View Full Report
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="float-end">
                                    {!! $students->appends(request()->except('page'))->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
