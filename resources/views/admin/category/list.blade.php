@extends('admin.layouts.master')

@section('content')

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="mb-4 d-sm-flex align-items-center justify-content-between">
            <h1 class="mb-0 text-gray-800 h3">Category List</h1>
        </div>

        <div class="row mb-3">
            <div class="col-4 offset-8">
                <form action="{{ route('category#list') }}" method="get">
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class="form-control"
                            placeholder="Enter search key...">
                        <button class="text-white btn bg-dark ml-1"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>


        <div class="">
            <div class="row">
                <div class=" col-4">
                    <div class="card">
                        <div class="shadow card-body">
                            <form action="{{ route('category#create') }}" method="post" class="p-3 rounded">
                                @csrf

                                <input type="text" name="categoryName" value="{{ old('categoryName') }}"
                                    class=" form-control @error('categoryName') is-invalid @enderror"
                                    placeholder="Category Name...">
                                @error('categoryName')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="submit" value="Create" class="mt-3 btn btn-outline-primary">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col ">

                    <table class="table shadow-sm table-hover ">
                        <thead class="text-white bg-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Created Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($categoryCount != 0)
                                @foreach ($categories as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->created_at->format('d-F-Y') }}</td>
                                        <td>
                                            <a href="{{ route('category#edit', $item->id) }}"
                                                class="btn btn-sm btn-outline-secondary"> <i
                                                    class="fa-solid fa-pen-to-square"></i> </a>
                                            <button type="button" onclick="deleteConfirm({{ $item->id }})"
                                                class="btn btn-sm btn-outline-danger"> <i
                                                    class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4">There is no data!</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>

                    <span class=" d-flex justify-content-end">{{ $categories->links() }}</span>

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
                html: "Category Created Successfully...",
                timer: 1300,
                timerProgressBar: true,
                icon: "success",
            });

            setInterval(() => {
                location.href = "/admin/category/list"
            }, 1300)
        </script>
    @endsection
@endif

@section('script-code')
    <script>
        function deleteConfirm(id) {

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                        timer: 1300,
                        timerProgressBar: true,


                    });

                    setInterval(() => {
                        location.href = "/admin/category/delete/" + id //delete process
                    }, 1300)
                }
            });

        }
    </script>
@endsection
