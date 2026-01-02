@extends('user.layouts.master')
@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Order Code</th>
                            <th scope="col">Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if (count($orderList) != 0)
                            @foreach ($orderList as $item)
                                <tr>
                                    <td scope="col">{{$item->created_at->format('d-F-Y')}}</td>
                                    <td scope="col">{{$item->order_code}}</td>
                                    <td scope="col">
                                        @if ($item->status == 'success')
                                        <span class="text-success">Accepted <i class="fa-solid fa-check"></i></span>
                                        @elseif ($item->status == 'reject')
                                        <span class="text-danger">Rejected <i class="fa-solid fa-xmark"></i></span>
                                        @elseif ($item->status == 'pending')
                                        <span class="text-warning">Pending <i class="fa-solid fa-hourglass-half"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td class="text-center" colspan="3">There is no order</td>
                            </tr>
                        @endif




                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <!-- Cart Page End -->
@endsection
