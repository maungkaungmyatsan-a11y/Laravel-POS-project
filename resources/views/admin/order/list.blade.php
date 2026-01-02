@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="row mb-3">
            <div class="col-4 offset-8">
                <form action="{{ route('admin#orderList') }}" method="get">
                    <div class="input-group">
                        <input type="text" name="orderCode" value="{{ request('orderCode') }}" class="form-control"
                            placeholder="Enter order code...">
                        <button class="text-white btn bg-dark ml-1"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>

            <div class="card">
                <div class="card-header">
                    <span class="" style="margin-right: 10px">Order List</span>
                    <a href="{{ route('admin#orderList','') }}"><span class="btn btn-sm btn-outline-success ms-3">Order List</span></a>
                    <a href="{{ route('admin#orderList','reject') }}"><span class="btn btn-sm btn-outline-danger ms-3">Reject List</span></a>
                </div>
                <div class="card-body">
                    <table class="table shadow-sm table-hover ">
                        <thead class="text-white bg-primary">
                            <tr>
                                <th>Order Code</th>
                                <th class="col-4">Date</th>
                                <th>Customer Name</th>
                                <th>Order Status</th>
                                <th></th>
                            </tr>

                        </thead>
                        <tbody>
                            @if (count($orderList) != 0)
                                @foreach ($orderList as $item)
                                    <tr>
                                        <td><a href="{{ route('admin#orderDetails', $item->order_code) }}" class="orderCode">{{$item->order_code}}</a>
                                        </td>
                                        <td class="col-4">{{$item->created_at->format('d-F-Y')}}</td>
                                        <td>{{$item->user_name}}</td>
                                        <td>
                                            @if ($item->status == 'success')
                                                <span class="text-success">Accepted <i class="fa-solid fa-check"></i></span>
                                            @elseif ($item->status == 'reject')
                                                <span class="text-danger">Rejected <i class="fa-solid fa-xmark"></i></span>
                                            @elseif ($item->status == 'pending')
                                                <span class="text-warning">Pending <i class="fa-solid fa-hourglass-half"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->status == 'pending')
                                                <select name="" class="form-select orderStatus">
                                                    <option value="pending" @if ($item->status == 'pending') selected @endif>Pending</option>
                                                    @if ($item->confirmStatus)
                                                        <option value="success" @if ($item->status == 'success') selected @endif>Accepted</option>
                                                    @endif
                                                    <option value="reject" @if ($item->status == 'reject') selected @endif>Rejected</option>
                                                </select>
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">There is no order!</td>
                                </tr>

                            @endif
                        </tbody>
                    </table>
                    {{-- <span class="d-flex justify-content-end">{{ $orderList->links() }}</span> --}}
                </div>

            </div>

        </div>
    </div>
@endsection

@section('script-code')
<script>
    $(document).ready(function(){
        $('.orderStatus').change(function(){
            status = $(this).val()

            orderCode = $(this).parents('tr').find('.orderCode').text()

            $.ajax({
                type : 'get',
                url : '/admin/order/list/accept',
                data : {'orderCode' : orderCode, 'status' : status},
                dataType : 'json',
                success: function (res) {
                    res.status == 'success' ? location.reload() : ''
                }
            })
        })
    })

</script>
@endsection
