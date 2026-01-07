@extends('admin.layouts.master')

@section('content')

    <div class="container">
        <h3 class="">Main Dashboard</h3>
        <div class="mt-4 row">
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <a href="{{ route('profile#accountList','user') }}">
                        <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Users</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">{{$userCount}} users</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-users fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <a href="{{ route('profile#accountList','admin') }}">
                        <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Admins</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">{{$adminCount}} admins</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-user-tie fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <a href="{{ route('admin#orderList',['state'=>'']) }}">
                        <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Pending | Success Order
                                    Count</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">{{$orderCount}}</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-circle-check fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <a href="{{ route('admin#orderList',['state'=>'reject']) }}">
                        <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Reject Order
                                    Count</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">{{$rejectCount}}</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-4 row">
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Total Recieve
                                    Amount</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">{{$totalTransationAmount}} mmk</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-dollar-sign fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Total Order Success Amount</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">{{$totalOrderSuccessAmount}} mmk</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-dollar-sign fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <a href="{{ route('admin#contactPage') }}">
                        <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Contact Messages</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">{{ $messageCount }}</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-message fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="text-center card shadow h-100 py-2 border-left-primary">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col mb-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">Pending | Success Order
                                    Count</div>
                            </div>
                        </div>
                        <div class="row align-items-center no-gutters">
                            <div class="col mr-2">
                                <div class="text-gray-800 h5 font-weight-bold mt-2">3 users</div>
                            </div>
                            <div class="col">
                                <i class="fa-solid fa-users fa-2x text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
