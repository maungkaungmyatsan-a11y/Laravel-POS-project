@extends('admin.layouts.master')

@section('content')



<div class="row">
    <div class="col-4 offset-4">
        <div class="mb-3 ms-5">
            <a href="{{ route('category#list') }}" class="text-black text-decoration-none">Category</a>->Edit
        </div>
        <div class="card">
            <div class="shadow card-body">
                <form action="{{ route('category#update',$category->id) }}" method="post" class="p-3 rounded">
                    @csrf
                    <input type="text" name="categoryName" value="{{ old('categoryName',$category->name)}}" class=" form-control @error('categoryName') is-invalid @enderror"
                        placeholder="Category Name...">

                    @error('categoryName')
                    <small class="invalid-feedback">{{ $message }}</small>
                    @enderror

                    <input type="submit" value="Update" class="mt-3 btn btn-outline-primary">
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@if (Session::has('updateSuccess'))
    @section('script-code')
    <script>
            Swal.fire({
            title: "Success!",
            html: "Category Updated Successfully...",
            timer: 1300,
            timerProgressBar: true,
            icon: "success",
            });

            setInterval(()=>{
                location.href="/admin/category/list"
            },1300)



    </script>
    @endsection
@endif
