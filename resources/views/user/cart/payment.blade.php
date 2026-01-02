@extends('user.layouts.master')
@section('content')

    <div class="container" style="margin-top: 150px">
        <div class="row">
            <div class="card col-12">
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="card">
                                <div class="p-2 card-body shadow-sm">
                                    <div class="p-3">
                                        <h5>Payment methods</h5>
                                        @foreach ($paymentAccounts as $item)
                                            <div class="">
                                                <b>{{$item->account_type}}</b> ( Name : {{$item->account_name}} ) <br>

                                                Account : {{$item->account_number}}

                                                <hr>
                                            </div>
                                        @endforeach
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    Your Order Code is - <span class="text-success">{{ $orderCode }}</span><br>
                                    Total Amount - <span class="text-danger">{{ $total }} mmk</span>
                                </div>

                                <form action="{{ route('user#payment') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row py-3">
                                            <div class="col">
                                                <input type="text" value="{{ auth()->user()->name }}" class="form-control"
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="row my-3">

                                            <div class="col">
                                                <input type="text" value="{{ old('name') }}" name="name"
                                                    placeholder="User Name..."
                                                    class="form-control @error('name') is-invalid @enderror">
                                                @error('name')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="col">
                                                <input type="text" value="{{ old('phone') }}" name="phone"
                                                    placeholder="Enter Your Phone Number..."
                                                    class="form-control @error('phone') is-invalid @enderror">
                                                @error('phone')
                                                    <small class="invalid-feedback">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="row py-3">
                                                <div class="col">
                                                    <textarea name="address" value="{{ old('address') }}" cols="30"
                                                        rows="10"
                                                        class="form-control @error('address') is-invalid @enderror"
                                                        placeholder="Enter Delivery Address..."></textarea>
                                                    @error('address')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row py-3">
                                                <div class="col">
                                                    <select name="paymentType"
                                                        class="form-select @error('paymentType') is-invalid @enderror">
                                                        <option value="">Enter Your Payment Methods</option>
                                                        @foreach ($paymentAccounts as $item)
                                                            <option value="{{ $item->id }}" @if (old('paymentType') == $item->id)
                                                            selected @endif>{{ $item->account_type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('paymentType')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row py-2">
                                                <div class="col">
                                                    <img src="" alt="" id="output" class="w-25 mb-2">
                                                    <input type="file" name="payslip_image" value="{{ old('image') }}"
                                                        accept="image/*" onchange="loadFile(event)"
                                                        placeholder="Choose File"
                                                        class="form-control mt-2 @error('image') is-invalid @enderror">
                                                    @error('payslip_image')
                                                        <small class="invalid-feedback">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row py-2">
                                                <div class="col">
                                                    <button type="submit" class="text-white w-100 btn-success btn"><i
                                                            class="fa-solid fa-cart-shopping"></i> Order Now</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script-code')
@if (Session::has('success'))
    @section('script-code')
        <script>
            Swal.fire({
                title: "Success!",
                html: "Order Success...",
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
