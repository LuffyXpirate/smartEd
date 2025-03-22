@extends('Layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Admin List (Total: {{ $getRecord->total() }})</h1>
                    </div>
                    <div class="col-sm-6" style="text-align: right;">
                        <br>
                        <a href="{{ url('admin/add') }}" class="btn btn-primary">Add New Admin</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Admin Form with Search -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{ request('name') }}"
                                placeholder="Search by Name">
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{ request('email') }}"
                                placeholder="Search by Email">
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
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
                                <h3 class="card-title">Admin List</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($getRecord as $value)
                                            <tr>
                                                <td>{{ $value->id }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->email }}</td>
                                                <td>{{ $value->created_at ? $value->created_at->format('d M, Y h:i A') : 'N/A' }}
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ url('admin/edit/' . $value->id) }}"
                                                            class="btn btn-primary btn-sm">Edit</a>
                                                        <a href="{{ url('admin/delete/' . $value->id) }}"
                                                            class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                                                    </div>
                                                 
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="float-end">
                                    {!! $getRecord->appends(request()->except('page'))->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
