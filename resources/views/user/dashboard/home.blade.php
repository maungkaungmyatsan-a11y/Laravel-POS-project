@extends('user.layouts.master')
@section('content')
    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5 mt-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Our Organic Products</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill  @if (!request('categoryId'))active @endif " href="{{ url('user/home') }}">
                                    <span class="text-dark" style="width: 130px;">All Products</span>
                                </a>
                            </li>
                            @foreach ($categories as $item)
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill @if (request('categoryId') == $item->id) active @endif " href="{{ url('user/home?categoryId='.$item->id) }}">
                                        <span class="text-dark" style="width: 130px;">{{$item->name}}</span>
                                    </a>
                                </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-3">
                                <div class="form">
                                    <form action="{{ route('user#home') }}" method="get">

                                        <div class="input-group">
                                            <input type="text" name="searchKey" value="{{ request('searchKey') }}" class=" form-control"
                                                placeholder="Enter Search Key...">
                                            <button type="submit" class=" btn"> <i class="fa-solid fa-magnifying-glass"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-12">
                                        <form action="{{ route('user#home') }}" method="get">

                                            <input type="text" name="minPrice" value="{{request('minPrice') }}" placeholder="Minimum Price..."
                                                class=" form-control my-2">
                                            <input type="text" name="maxPrice" value="{{request('maxPrice') }}" placeholder="Maximun Price..."
                                                class=" form-control my-2">
                                            <input type="submit" value="Search" class=" btn btn-success my-2 w-100">
                                        </form>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <form action="" method="get">

                                            <select name="sortingType" class="form-control w-100 bg-white mt-3">
                                                <option value="">Sort By...</option>
                                                <option value="nameAsc" @if(request('sortingType') == 'nameAsc') selected @endif>Name : A to Z</option>
                                                <option value="nameDesc" @if(request('sortingType') == 'nameDesc') selected @endif>Name : Z to A</option>
                                                <option value="priceAsc" @if(request('sortingType') == 'priceAsc') selected @endif>Price : Low to High</option>
                                                <option value="priceDesc" @if(request('sortingType') == 'priceDesc') selected @endif>Price : High to Low</option>
                                                <option value="dateAsc" @if(request('sortingType') == 'dateAsc') selected @endif>Date : Oldest to Newest</option>
                                                <option value="dateDesc" @if(request('sortingType') == 'dateDesc') selected @endif>Date : Newest to Oldest</option>
                                            </select>
                                            <input type="submit" value="Sort" class=" btn btn-success my-3 w-100">
                                        </form>
                                    </div>
                                </div>

                            </div>
                            <div class="col-9">
                                <div class="row g-4">

                                    @if (count($products) !=0)
                                     @foreach ($products as $item)
                                        <div class="col-4">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="fruite-img">
                                                    <a href="{{ route('user#productDetails',$item->id) }}"><img src="{{ asset('productImage/' . $item->image) }}"
                                                            style="height: 250px" class="img-fluid w-100 rounded-top"
                                                            alt=""></a>
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                    style="top: 10px; left: 10px;">{{ $item->category_name }}</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                    <h4>{{ $item->name }}</h4>
                                                    <p>{{ Str::words($item->description, 10, '...') }}</p>
                                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                                        <p class="text-dark fs-5 fw-bold mb-0">{{ $item->price }} mmk</p>
                                                        <a href="{{route('user#productDetails',$item->id)}}"
                                                            class="btn border border-secondary rounded-pill px-3 text-primary"> View More</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                    @else
                                    <div class="row ">
                                        <div class="col-6 offset-3">
                                            <img class="w-100" src="{{ asset('defaultImage/noItem.png') }}" alt="">
                                        </div>
                                    </div>
                                    @endif

                                </div>

                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
@endsection
