@extends('user.layouts.master')
@section('content')
    <!-- contact me start -->

    <div class="container" style="margin-top: 7rem">
        <h3 class="my-5 text-center fw-bold" style="margin: 100px 0px;">Contact Us!</h3>
        <div class="row">
            <div class="mt-4 col-12 col-md-5 d-flex justify-content-center">
                <div class="">
                    <div class="d-flex">
                        <div class="">
                            <i style="color: #006400" class="mx-3 mt-2 fa-solid fa-phone fs-3"></i>
                        </div>
                        <div class="">
                            <div class="">Phone</div>
                            <div class="text-muted">+959772043326</div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex">
                        <div class="">
                            <i style="color: #006400" class="mx-3 mt-2 fa-solid fa-envelope fs-3"></i>
                        </div>
                        <div class="">
                            <div class="">Email</div>
                            <div class="text-muted">digitalhub@gmail.com</div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex">
                        <div class="">
                            <i style="color: #006400" class="mx-3 mt-2 fa-solid fa-location-dot fs-3"></i>
                        </div>
                        <div class="">
                            <div class="">Location</div>
                            <div class="text-muted">Yangon</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-7">
                <form action="{{ route('user#contact') }}" method="post">
                    @csrf
                    <div class="mb-4 row">
                        <div class="mt-4 col">
                            <input type="text" name="name" value="{{old('name')}}" class="form-control" placeholder="Enter your name...">
                        </div>
                        <div class="mt-4 col">
                            <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="Enter your email...">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <div class="col">
                            <input type="text" name="title" value="{{old('title')}}" class="form-control" placeholder="Title...">
                        </div>
                        <div class="col">
                            <input type="text" name="phone" value="{{old('phone')}}" class="form-control" placeholder="Enter your phone number...">
                        </div>
                    </div>
                    <div class="mb-4 row">
                        <div class="col-12">
                            <textarea rows="10" name="message" value="" cols="30" class="form-control" placeholder="Message...">{{old('message')}}</textarea>
                        </div>
                    </div>
                    <div class="">
                        <button style="color: #006400" class="p-2 rounded shadow-sm"><i
                                class="mx-2 fa-solid fa-paper-plane"></i>Send Message</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- contact me end -->
@endsection

@section('script-code')

@if (Session::has('success'))
    @section('script-code')
        <script>
            Swal.fire({
                title: "Success!",
                html: "Message Sent Successfully...",
                timer: 1300,
                timerProgressBar: true,
                icon: "success",
            });

            setInterval(() => {
                location.reload();
            }, 1300)
        </script>
    @endsection
@endif

