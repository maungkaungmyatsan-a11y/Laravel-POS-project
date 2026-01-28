@extends('admin.layouts.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <form id="discountForm" method="post" action="{{ route('admin#discountStore') }}">
                    @csrf

                    <div class="card">

                        <div class="p-4 card-body">
                            <select name="discountType" id="discountType" class="form-control px-2 my-2 form-select">
                                <option value="">Select discount type...</option>
                                <option value="percent">Percentage(%)</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>

                            <input type="text" name="discountValue" id="discountValue" class="form-control px-2 my-2"
                                placeholder="Enter Discount Value...">

                            <select name="applyType" id="applyType" class="form-control px-2 my-2 form-select">
                                <option value="">Apply discount to...</option>
                                <option value="single">Single Item</option>
                                <option value="multiple">Multiple Item</option>
                            </select>

                            <div id="productWrapper" style="display:none">

                                <div class="form-check mb-2 selectAll">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                    <label class="form-check-label fw-bold" for="selectAll">
                                        Select All Products
                                    </label>
                                </div>

                                <div class="border p-2" style="max-height:200px; overflow-y:auto">
                                    @foreach ($products as $item)
                                        <div class="form-check">
                                            <input class="form-check-input product-checkbox" type="checkbox" name="productIds[]"
                                                value="{{ $item->id }}" data-price="{{ $item->price }}"
                                                id="product_{{ $item->id }}">
                                            <label class="form-check-label" for="product_{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div class="card my-3">
                                <div class="card-body">
                                    <div class="originalPrice">
                                        <span id="originalPrice">Original Price: </span>
                                    </div>
                                    <div class="my-3 discountAmount">
                                        <span id="discountAmount">Discount Amount: </span>
                                    </div>
                                    <div class=" finalPrice">
                                        <span id="finalPrice">Final Price: </span>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary">Apply Discount</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script-code')
    <script>
        $(document).ready(function () {

            $('#applyType').on('change', function () {
                let applyType = $(this).val();

                if (applyType === 'single') {
                    $('#productWrapper').slideDown();
                    $('.selectAll').hide();
                    $('.product-checkbox').prop('checked', false);

                } else if (applyType === 'multiple') {
                    $('#productWrapper').slideDown();
                    $('.selectAll').show();

                } else {
                    $('#productWrapper').hide();
                    $('.product-checkbox').prop('checked', false);
                    $('#selectAll').prop('checked', false);
                }

                discountCalculation();
            });

            // Select all checkbox
            $('#selectAll').on('change', function () {
                $('.product-checkbox').prop('checked', this.checked);
                discountCalculation();
            });

            // If one unchecked, uncheck select all
            $('.product-checkbox').on('change', function () {
                if (!this.checked) {
                    $('#selectAll').prop('checked', false);
                }
            });

            // Can select only one product
            $('.product-checkbox').on('click', function () {
                if ($('#applyType').val() === 'single') {
                    $('.product-checkbox').not(this).prop('checked', false);
                }
            });


            //discount calculaton
            function discountCalculation() {
                let discountType = $('#discountType').val();
                let discountValue = $('#discountValue').val() * 1 ;
                let totalPrice = 0;
                let discountAmount = 0;
                let selectedProducts = $('.product-checkbox:checked');

        $('.product-checkbox:checked').each(function () {
            totalPrice += $(this).data('price') * 1;
        })

        if (discountType === 'percent') {

            discountAmount = (totalPrice * discountValue) / 100;
        }

        if (discountType === 'fixed') {

            discountAmount = discountValue * selectedProducts.length;
        }

        if (discountAmount > totalPrice) {
            discountAmount = totalPrice;
        }

        let finalPrice = totalPrice - discountAmount;

        $('#originalPrice').text('Original Price: ' + totalPrice + 'MMK' )
        $('#discountAmount').text('Discount Amount: ' + discountAmount + ' MMK');
        $('#finalPrice').text('Final Price: ' + finalPrice + ' MMK');


        }

        $('#discountType').on('change', discountCalculation);
        $('#discountValue').on('input', discountCalculation);
        $('.product-checkbox').on('change', discountCalculation);


        });
    </script>

@endsection
