@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">Edit Admin</div>
                </div>
                <form action="{{ url('admin/edit/' . $getRecord->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- Specify the HTTP method as PUT -->
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" value="{{ $getRecord->name }}" required />
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" value="{{ $getRecord->email }}" name="email" required />
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
@endsection
