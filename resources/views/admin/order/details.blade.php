@extends('admin.layouts.master')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        Customer Information <br>(Order Code -
                        <span class="text-danger order-code">{{ $orderData[0]['order_code'] }}</span>)
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-5">Name :</div>
                            <div class="col-7">{{ $orderData[0]['name'] }}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Phone :</div>
                            <div class="col-7">{{ $orderData[0]['phone'] }}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Address :</div>
                            <div class="col-7">{{ $orderData[0]['address'] ? $orderData[0]['address'] : '---' }}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Order Code :</div>
                            <div class="col-7">{{ $orderData[0]['order_code'] }}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Order Date :</div>
                            <div class="col-7">{{ $orderData[0]['created_at']->format('d-F-Y') }}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Total Price :</div>
                            <div class="col-7">{{ $totalAmt }} mmk <small class="text-danger">( contain deli fees )</small>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-5">
                <div class="card">
                    <div class="card-header">
                        Payment History information
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-5">Contact Phone :</div>
                            <div class="col-7">{{ $paymentHistories['phone']}}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Address :</div>
                            <div class="col-7">{{ $paymentHistories['address'] ? $paymentHistories['address'] : '---' }}
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Payment Method :</div>
                            <div class="col-7">{{ $paymentHistories['payments_method']}}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Purchase Date :</div>
                            <div class="col-7">{{ $paymentHistories['created_at']->format('d-F-Y') }}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Order Date :</div>
                            <div class="col-7">{{ $paymentHistories['created_at']->format('d-F-Y') }}</div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-5">Total Price :</div>
                            <div class="col-7">{{ $paymentHistories['total_amount']}} mmk <small class="text-danger">(
                                    contain deli fees )</small>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <img src="{{ asset('payslipImage/' . $paymentHistories['payslip_image']) }}"
                                class="img-thumbnail w-25">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-3 row">
            <div class="col">
                <div class="mb-4 shadow card">
                    <div class="py-3 card-header">
                        <div class="d-flex justify-content-between">
                            <div class="">
                                <h6 class="m-0 font-weight-bold text-primary">Order Product List</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Product Price (each)</th>
                                        <th>Current Stock</th>
                                        <th>Order Count</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderData as $item)
                                        <tr>
                                            <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                            <td class="col-2">
                                                <img src="{{ asset('productImage/' . $item['image']) }}" class="w-100">
                                            </td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{$item->price}} mmk</td>
                                            <td>
                                                {{$item->current_stock}}
                                                @if ($item->order_count > $item->current_stock)
                                                    {{ $orderStatus = "" }}
                                                    <small class="text-danger">(out of stock)</small>
                                                @endif
                                            </td>
                                            <td class="qty">{{$item->order_count}}</td>
                                            <td>{{$item->price * $item->order_count}} mmk</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($orderData[0]['status'] == 'reject')
                        <div class="card-footer d-flex justify-content-center">
                            <h5 class="text-danger">Your rejected this order !</h5>
                        </div>
                    @else
                        <div class="card-footer d-flex justify-content-end">
                            @if (!isset($orderStatus))
                                <input type="button" value="Order Confirm"
                                    class="rounded shadow-sm btn btn-primary btn-order-confirm">
                            @endif
                           <input type="button" value="Reject Order" class="btn-reject-order mx-2 rounded shadow-sm btn btn-danger"></a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script-code')
    <script>
        $(document).ready(function () {
            $('.btn-order-confirm').click(function () {

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Confirm Order!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        orderCode = $('.order-code').text()

                        orderProductList = [];

                        $('#dataTable tbody tr').each(function (index, row) {
                            productId = $(row).find('.productId').val();
                            qty = $(row).find('.qty').text()

                            orderProductList.push({
                                'productId': productId,
                                'orderCount': qty,

                            })
                        })

                        data = {
                            'data': orderProductList,
                            'orderCode': orderCode
                        }


                        $.ajax({
                            type: 'get',
                            url: '/admin/order/accept',
                            data: Object.assign({}, data),
                            dataType: 'json',
                            success: function (res) {
                                res.status == 'success' ? location.href = '/admin/order/list' : ''
                            }
                        })

                    }
                });



            })

            $('.btn-reject-order').click(function () {

                Swal.fire({
                    title: "Are you sure?",
                    text: "Are you sure to reject cancel this order!",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Reject Order!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        orderCode = $('.order-code').text()
                         $.ajax({
                            type: 'get',
                            url: '/admin/order/reject',
                            data: {'orderCode' : orderCode},
                            dataType: 'json',
                            success: function (res) {
                                res.status == 'success' ? location.href = '/admin/order/list' : ''
                            }
                        })

                    }
                });



            })
        })
    </script>
@endsection
