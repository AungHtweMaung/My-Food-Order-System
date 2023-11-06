@extends('admin.layouts.master')

@section('title', 'Edit Product')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="col-lg-10 offset-lg-1 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Update Product</h3>
                            </div>
                            <hr>

                            <form action="{{ route('product#update', $product->id) }}" method="post"
                                enctype="multipart/form-data" novalidate="novalidate">
                                @csrf
                                <input type="hidden" name="productId" value="{{ $product->id }}">

                                <div class="row justify-content-center">
                                    <div class="col-4 ">
                                        <img style="min-height: 150px;"
                                            src="{{ asset('storage/productImage/' . $product->image) }}" />


                                        <div class="form-group mt-2">
                                            <input name="productImage" type="file"
                                                class="form-control @error('productImage') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="">
                                            @error('productImage')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="">
                                            <button type="submit" class="btn btn-dark w-100"><i
                                                    class="fas fa-arrow-circle-right mr-2"></i>Update</button>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="productName"
                                                value="{{ old('productName', $product->name) }}"
                                                class="form-control @error('productName') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="">
                                            @error('productName')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea class="form-control @error('productDescription') is-invalid @enderror" name="productDescription"
                                                id="" cols="30" rows="10" placeholder="Enter Description">{{ old('productDescription', $product->description) }}</textarea>

                                            @error('productDescription')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Category</label>
                                            <select name="productCategory" class="form-control @error('productCategory') is-invalid @enderror">
                                                <option value="">Choose your category</option>
                                                @foreach ($categories as $c)
                                                    {{-- product ထဲက category_id နဲ့ တူတဲ့ category ကို select လုပ်ချင်လို့  --}}
                                                    <option value="{{ $c->id }}" @if ($product->category_id == $c->id)
                                                    selected
                                                    @endif>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('productCategory')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="productPrice"
                                                value="{{ old('productPrice', $product->price) }}" type="text"
                                                class="form-control @error('productPrice') is-invalid @enderror"
                                                aria-required="true" aria-invalid="false" placeholder="Enter Price">

                                            @error('productPrice')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                            <input type="text" name="productWaitingTime" id=""
                                                value="{{ old('productWaitingTime', $product->waiting_time) }}"
                                                class="form-control @error('productWaitingTime') is-invalid @enderror">
                                            @error('productWaitingTime')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">View Count</label>
                                            <input disabled type="text" name="productViewCount" id=""
                                                value="{{ $product->view_count }}"
                                                class="form-control @error('productViewCount') is-invalid @enderror">
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Created time</label>
                                            <input disabled type="text" id=""
                                                value="{{ $product->created_at->format('j-F-Y') }}"
                                                class="form-control @error('productViewCount') is-invalid @enderror">
                                        </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
