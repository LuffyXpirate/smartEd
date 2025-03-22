@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-12">
            <!--begin::Quick Example-->
            <div class="card card-primary card-outline mb-4">
                <!--begin::Header-->
                <div class="card-header">
                    <div class="card-title">Add New Admin</div>
                </div>
                <form action="" method="POST">
                    @csrf
                    <!--begin::Body-->
                    <div class="card-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" required/>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" aria-describedby="emailHelp" name="email" required/>
                        </div>
                       <div style="color:red"> {{ $errors->first('email') }}</div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required />
                        </div>
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <!--end::Footer-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
@endsection
