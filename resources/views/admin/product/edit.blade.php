@extends('admin.layouts.master')

@section('content')
    <div class="row">
        <div class="col-10 offset-1">
            <form action="{{ route('product#update',$product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="p-4 card-body">
                        <div class="row">
                            <div class="col-5">
                                <img src="{{ asset($product->image == null? 'defaultImage/dimage.webp' : 'productImage/' . $product->image) }}"
                                    class="px-2 my-2 w-100 img-thumbnail" id="output">
                                    <input type="hidden" name="oldImageName" value="{{ $product->image }}">

                                <input type="file" name="image"
                                    class="form-control px-2 my-2 @error('image') is-invalid @enderror" accept="image/*"
                                    onchange="loadFile(event)">
                                @error('image')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col">
                                <input type="text" name="title"
                                    class="form-control px-2 my-2 @error('title') is-invalid @enderror"
                                    value="{{ old('title', $product->name) }}" placeholder="Enter Product Title...">
                                @error('title')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="number" name="price"
                                    class="form-control px-2 my-2 @error('price') is-invalid @enderror"
                                    value="{{ old('price', $product->price) }}" placeholder="Enter Product Price...">
                                @error('price')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <textarea name="description" cols="30" rows="10"
                                    class="form-control px-2 my-2 @error('description') is-invalid @enderror"
                                    placeholder="Enter description...">{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <select name="categoryId"
                                    class="form-control px-2 my-2 form-select @error('categoryId') is-invalid @enderror">
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" @if ($item->id == old('categoryId',$product->category_id) ) selected @endif>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoryId')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror


                                <input type="number" name="stock"
                                    class="form-control px-2 my-2 @error('stock') is-invalid @enderror"
                                    value="{{ old('stock', $product->stock) }}" placeholder="Enter Product Stock...">
                                @error('stock')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror

                                <input type="submit" value="Update Product" class="btn btn-primary">

                            </div>

                        </div>
                    </div>
            </form>

        </div>
    </div>
@endsection

@if (Session::has('success'))
    @section('script-code')
        <script>
            Swal.fire({
                title: "Success!",
                html: "Product Created Successfully...",
                timer: 1300,
                timerProgressBar: true,
                icon: "success",
            });
        </script>
    @endsection
@endif
