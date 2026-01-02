@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <div class="row mb-3">
            <div class="col-4 offset-8">
                <form action="{{ route('admin#saleInformation') }}" method="get">
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
                    <span class="" style="margin-right: 10px">Sale Information ( Total Amount - <span class="text-danger">{{ $total }}</span> mmk )</span>
                </div>
                <div class="card-body">
                    <table class="table shadow-sm table-hover ">
                        <thead class="text-white bg-primary">
                            <tr>
                                <th>Date</th>
                                <th>Order Code</th>
                                <th>Total Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $item )
                               <tr>
                                    <td>{{ $item->created_at->format('d-F-Y') }}</td>
                                    <td><a href="{{ route('admin#orderDetails',$item->order_code) }}">{{$item->order_code}}</a></td>
                                    <td>{{$item->total_price}}</td>
                                    <td></td>
                               </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{-- <span class="d-flex justify-content-end">{{ $orderList->links() }}</span> --}}
                </div>

            </div>

        </div>
    </div>
@endsection

@section('script-code')

@endsection
