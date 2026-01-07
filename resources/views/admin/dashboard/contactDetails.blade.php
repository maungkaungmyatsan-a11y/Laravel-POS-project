@extends('admin.layouts.master')
@section('content')


        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            Customer Information

                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-1">Name :</div>
                                <div class="col-11">{{ $contactList->user_name }}</div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-1">Email :</div>
                                <div class="col-11">{{ $contactList->user_email }}</div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-1">Phone :</div>
                                <div class="col-11">{{ $contactList->phone }}</div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-1">Title :</div>
                                <div class="col-11">{{ $contactList->title }}</div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-1">Message :</div>
                                <div class="col-11">{{ $contactList->message }}</div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>


@endsection
