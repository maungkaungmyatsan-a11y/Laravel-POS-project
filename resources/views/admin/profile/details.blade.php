@extends('admin.layouts.master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="mb-4 shadow card col">
            <div class="py-3 card-header">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile ( <span class="text-danger"> Role -
                                {{ auth()->user()->role }}</span>
                            ) </h6>
                    </div>
                </div>
            </div>


            <div class="card-body">
                <div class="row">
                    <div class="col-3">

                        <img class="img-profile img-thumbnail" id="output"
                            src="{{ asset(auth()->user()->profile == null ? 'defaultImage/profile.webp' : 'adminProfile/' . auth()->user()->profile)  }}">



                    </div>
                    <div class="col">-

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="mr-2 fa-solid fa-file-signature"></i>Name</label>
                                    <h5>{{ auth()->user()->name }}</h5>

                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="mr-2 fa-solid fa-envelope"></i>Email</label>
                                    <h5>{{ auth()->user()->email }}</h5>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="mr-2 fa-solid fa-phone"></i>Phone</label>
                                    <h5>{{ auth()->user()->phone }}</h5>

                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="mr-2 fa-solid fa-location-dot"></i>Address</label>
                                    <h5>{{ auth()->user()->address }}</h5>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">
                                        <i class="mr-2 fa-solid fa-clock"></i>Created Date</label>
                                    <h5>{{ auth()->user()->created_at->format('d-F-Y') }}</h5>

                                </div>
                            </div>
                        </div>
                        <a href="{{ route('profile#changePasswordPage') }}"><i class="mr-2 fa-solid fa-key"></i>Change Password</a><br>
                        <a href="{{ route('profile#edit') }}">
                            <input type="button" value="Edit" class="mt-3 btn btn-primary">
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection
