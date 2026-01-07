@extends('admin.layouts.master')

@section('content')



<div class="row">
    <div class="col-4 offset-4">
        <div class="mb-3 ms-5">
            <a href="{{ route('category#list') }}" class="text-black text-decoration-none">Payment</a>->Edit
        </div>
        <div class="card">
            <div class="shadow card-body">
                <form action="{{ route('admin#updatePayment',$payments->id) }}" method="post" class="p-3 rounded">
                    @csrf
                    <input type="text" name="accountNumber" value="{{ old('accountNumber',$payments->account_number)}}" class="mb-3 form-control @error('accountNumber') is-invalid @enderror"
                        placeholder="Account Number...">

                    @error('accountNumber')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror

                     <input type="text" name="accountName" value="{{ old('accountName',$payments->account_name)}}" class="mb-3 form-control @error('accountName') is-invalid @enderror"
                        placeholder="Account Name...">

                    @error('accountName')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror

                     <input type="text" name="accountType" value="{{ old('accountType',$payments->account_type)}}" class="mb-3 form-control @error('accountType') is-invalid @enderror"
                        placeholder="Account Type...">

                    @error('accountType')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror

                    <input type="submit" value="Update" class="mt-3 btn btn-outline-primary">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@if (Session::has('success'))
    @section('script-code')
    <script>
            Swal.fire({
            title: "Success!",
            html: "Payment Method Updated Successfully...",
            timer: 1300,
            timerProgressBar: true,
            icon: "success",
            });

            setInterval(()=>{
                location.href="/admin/payment/methods/page"
            },1300)



    </script>
    @endsection
@endif
