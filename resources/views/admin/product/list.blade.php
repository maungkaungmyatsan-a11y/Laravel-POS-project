@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">

            <table class="table shadow-sm table-hover ">
                <thead class="text-white bg-primary">
                    <tr>
                        <th>ID</th>
                        <th class="col-4">Image</th>
                        <th>Name</th>
                        <th>Stock</th>
                        <th>Created Date</th>
                        <th></th>
                    </tr>

                </thead>
                <tbody>
                    @foreach ($products as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <img class="img-thumbnail w-50" src="{{ asset($item->image == null? 'defaultImage/dimage.webp' : 'productImage/' . $item->image) }}"
                                    alt="">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>
                                <button type="button" class="text-white btn btn-sm bg-dark position-relative">
                                    {{ $item->stock }}
                                    @if ($item->stock == 0)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            Out of stock
                                        </span>
                                    @elseif ($item->stock < 5)
                                        <span
                                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                            Low Amount
                                        </span>
                                    @endif
                                </button>
                            </td>
                            <td>{{ $item->created_at->format('d-F-Y') }}</td>
                            <td>
                                <a href="{{ route('product#edit',$item->id) }}" class="btn btn-sm btn-outline-secondary"> <i
                                        class="fa-solid fa-pen-to-square"></i> </a>
                                <button type="button" onclick="deleteConfirm({{ $item->id }})" class="btn btn-sm btn-outline-danger"> <i
                                        class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            <span>{{ $products->links() }}</span>
        </div>
    </div>
@endsection

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
                        location.href = "/admin/product/delete/" + id //delete processS
                    }, 1300)
                }
            });

        }
    </script>
@endsection
