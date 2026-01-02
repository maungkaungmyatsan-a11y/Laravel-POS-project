@extends('user.layouts.master')
@section('content')
    <!-- Cart Page Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="table-responsive">
                <table class="table" id="productTable">
                    <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>


                        @if (count($orderItems) != 0)
                            @foreach ($orderItems as $item)
                                <tr>

                                    <th scope="row">
                                        <input type="hidden" class="userId" value="{{ auth()->user()->id }}">
                                        <input type="hidden" class="productId" value="{{ $item->product_id }}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('productImage/' . $item->image) }}"
                                                class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                                        </div>
                                    </th>
                                    <td>
                                        <p class="mb-0 mt-4">{{ $item->name }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 price">{{ $item->price }} mmk</p>
                                    </td>
                                    <td>
                                        <div class="input-group quantity mt-4" style="width: 100px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" class="form-control qty form-control-sm text-center border-0"
                                                value="{{ $item->quantity }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="mb-0 mt-4 total">{{ $item->price * $item->quantity }} mmk</p>
                                    </td>
                                    <td>
                                        <input type="hidden" class="cartId" value="{{ $item->id }}">
                                        <input type="hidden" class="productId" value="">
                                        <button class="btn btn-md rounded-circle bg-light border mt-4 btn-remove">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </td>

                                </tr>

                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">There is no items</td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>

            @if (count($orderItems) != 0)
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0" id="subtotal">mmk</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Delivery </h5>
                                    <div class="">
                                        <p class="mb-0"> 5000 mmk </p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4 " id="finalTotal"> mmk</p>
                            </div>
                            {{-- <a href=""> --}}
                                <button id="btn-checkout"
                                    class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                                    type="button">Proceed Checkout</button>
                                {{-- </a> --}}

                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
    <!-- Cart Page End -->
@endsection

@section('script-code')
    <script>
        $(document).ready(function () {
            //total price calculation
            function priceCalculation() {
                total = 0;

                $('#productTable tbody tr').each(function (index, item) {
                    total += Number($(item).find(".total").text().replace("mmk", ""))

                })
                $("#subtotal").text(total + "mmk")
                $('#finalTotal').text((total + 5000) + "mmk")
            }
            priceCalculation();

            //btn plus or minus click
            $(".btn-plus, .btn-minus").click(function () {
                parentNode = $(this).parents("tr")

                singlePrice = parentNode.find(".price").text().replace("mmk", "") * 1;
                qty = parentNode.find(".qty").val();

                parentNode.find(".total").text((singlePrice * qty) + "mmk")
                priceCalculation();
            })

            //delete items
            $(".btn-remove").click(function () {
                cartId = { 'deleteCartId': $(this).parents("tr").find(".cartId").val() }


                $.ajax({
                    type: "GET",
                    url: "/user/deleteCart",
                    data: cartId,
                    dataType: 'json',
                    success: function (res) {
                        if (res.status == 200) {
                            location.reload();

                        }
                    }
                });

            })
            $('#btn-checkout').click(function () {

                //order code
                orderList = []
                orderCode = "ORDER_CODE - " + Math.floor(Math.random() * 1000000000000); //0 - 100000000...
                userId = $('.userId').val();

                $('#productTable tbody tr').each(function (index, row) {

                    productId = $(row).find('.productId').val();
                    qty = $(row).find('.qty').val();
                    totalAmt = $(row).find('.total').text().replace("mmk", "") * 1;

                    orderList.push({
                        'product_id': productId,
                        'user_id': userId,
                        'count': qty,
                        'status': 'pending',
                        'order_code': orderCode,
                        'total_price': totalAmt,
                    })
                })

                $.ajax({
                    type: "GET",
                    url: "/user/cart/temp",
                    data: Object.assign({}, orderList),
                    dataType: 'json',
                    success: function (res) {
                        res.status == 200 ? location.href = '/user/payment/page' : location.reload()
                    }
                })

            })

        })
    </script>
@endsection
