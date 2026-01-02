@extends('admin.layouts.master')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">


        <!-- DataTales Example -->
        <div class="mb-4 shadow card col">
            <div class="py-3 card-header">
                <div class="">
                    <div class="">
                        <h6 class="m-0 font-weight-bold text-primary">Admin Profile ( <span class="text-danger">Role -
                                {{ auth()->user()->role }}</span>
                            ) </h6>
                    </div>
                </div>
            </div>
            <form action="{{ route('profile#update', auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card-body">
                    <div class="row">
                        <div class="col-3">

                            <img class="img-profile img-thumbnail" id="output"
                                src="{{ asset(auth()->user()->profile == null ? 'defaultImage/profile.webp' : 'adminProfile/' . auth()->user()->profile)  }}">


                            <input type="file" name="image" id="" class="mt-1 form-control " onchange="loadFile(event)">

                        </div>
                        <div class="col">

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Name</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror" placeholder="Name..."
                                            value="{{old("name", auth()->user()->name)}}">
                                        @error('name')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Email</label>
                                        <input type="text" name="email"
                                            class="form-control @error('email') is-invalid @enderror "
                                            value="{{old("email", auth()->user()->email)}}" placeholder="Email...">
                                        @error('email')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Phone</label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror "
                                            value="{{old("phone", auth()->user()->phone)}}" placeholder="09xxxxxx">
                                        @error('phone')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">
                                            Address</label>
                                        <input type="text" name="address"
                                            class="form-control @error('address') is-invalid @enderror "
                                            value="{{old("address", auth()->user()->address)}}" placeholder="Address">
                                        @error('address')
                                            <small class="invalid-feedback">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <input type="submit" value="Update" class="mt-3 btn btn-primary">
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection
