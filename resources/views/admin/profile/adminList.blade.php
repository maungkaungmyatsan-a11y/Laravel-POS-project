@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class=" d-flex justify-content-between my-2">
            <a href="{{ route('profile#accountList', ['accountType' => 'admin']) }}"> <button
                    class=" btn btn-sm btn-secondary"> User List</button> </a>
            <div class="">
                <form action="{{ route('profile#accountList', ['accountType' => 'admin']) }}" method="get">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                            placeholder="Enter Search Key...">
                        <button type="submit" class=" btn bg-dark text-white"> <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <span class="text-black">Admin Count (<i class="fa-solid fa-users"></i> {{ count($accounts) }} accounts)</span>
        <div class="row">
            <div class="col">
                <table class="table table-hover shadow-sm ">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Created Date</th>
                            <th>Platform</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($accounts as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td><a href="">{{ $item->name }}</a></td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->address == null ? '-' : $item->address }}</td>
                                <td>{{ $item->phone == null ? '-' : $item->phone }}</td>
                                <td>
                                    @if($item->role == 'superadmin')
                                        <span class="btn btn-sm bg-success text-white rounded shadow-sm">Super Admin</span>
                                    @elseif($item->role == 'admin')
                                        <span class="btn btn-sm bg-danger text-white rounded shadow-sm">Admin</span>
                                    @endif

                                </td>
                                <td>{{ $item->created_at->format('d-F-Y') }}</td>
                                <td>
                                    @if($item->provider == 'simple')
                                        <i class="fa-solid fa-gauge-simple"></i> simple
                                    @elseif($item->provider == 'google')
                                        <i class="fa-brands fa-google"></i> google
                                    @else
                                        <i class="fa-brands fa-github"></i> github
                                    @endif
                                </td>
                                <td>
                                    @if($item->role !== 'superadmin')
                                    <button type="button" onclick="deleteConfirm({{ $item->id }})"
                                        class="text-white btn btn-sm btn-danger"> <i
                                            class=" text-white fa-solid fa-trash-can"></i>
                                    </button>
                                    @endif
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>

                <span class=" d-flex justify-content-end"></span>

            </div>
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
                        location.href = "/admin/profile/delete/" + id //delete process
                    }, 1300)
                }
            });

        }
    </script>
@endsection
