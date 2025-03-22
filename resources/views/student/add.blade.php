@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">Add New Student</div>
                </div>
                <form action="{{ route('student.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="mb-">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" name="first_name" required />
                        </div>
                        <div class="mb-">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" name="last_name" required />
                        </div>
                        <div class="mb-">
                            <label for="roll_no" class="form-label">Roll No</label>
                            <input type="text" class="form-control" name="roll_no" required />
                        </div>
                        <div class="mb-">
                            <label for="class" class="form-label">Class</label>
                            <select class="form-select" id="class" name="class" required>
                                <option value="">Select Class</option>
                                <option value="Class 5">Class 5</option>
                                <option value="Class 6">Class 6</option>
                                <option value="Class 7">Class 7</option>
                                <option value="Class 8">Class 8 </option>
                                <option value="Class 9">Class 9</option>
                                <option value="Class 10">Class 10</option>
                                <!-- Add more classes as needed -->
                            </select>
                        </div>
                        <div class="mb-">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required />
                        </div>
                        <div class="mb-">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required />
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection