@extends('admin.layouts.master')
@section('content')
<div class="row">
        <div class="col-10 offset-1">
            <div class="row mb-3">
            <div class="col-4 offset-8">
                <form action="{{ route('admin#contactPage') }}" method="get">
                    <div class="input-group">
                        <input type="text" name="userName" value="{{ request('userName') }}" class="form-control"
                            placeholder="Enter user name...">
                        <button class="text-white btn bg-dark ml-1"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>

            <div class="card">
                <div class="card-header">
                    <span class="" style="margin-right: 10px">Messages</span>

                </div>
                <div class="card-body">
                    <table class="table shadow-sm table-hover ">
                        <thead class="text-white bg-primary">
                            <tr>
                                <th>User Id</th>
                                <th>Customer Name</th>
                                <th class="col-4">Date</th>
                                <th></th>
                            </tr>

                        </thead>
                        <tbody>
                            @if(count($contactList) != 0)
                             @foreach ($contactList as $item)
                                    <tr>
                                        <td>{{$item->contact_id}}</td>
                                        <td><a href="{{ route('admin#contactDetails',$item->contact_id) }}">{{$item->user_name}}</a></td>
                                        <td class="col-4">{{$item->created_at->format('d-F-Y')}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            @else
                            <tr>
                                <td colspan="4" class="text-center text-primary">There is no messages</td>
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
