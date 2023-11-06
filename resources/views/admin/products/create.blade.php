@extends('admin.layouts.master')

@section('title', 'Create Category')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="text-right">
                            <a href="{{ route('product#list') }}"><button class="btn bg-dark text-white my-3">Product
                                    List</button></a>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h3 class="text-center title-2">Create Your Product</h3>
                                </div>
                                <hr>
                                <form action="{{ route('product#create') }}" method="post" enctype="multipart/form-data"
                                    novalidate="novalidate">
                                    @csrf
                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Name</label>
                                        <input id="cc-pament" name="productName" value="{{ old('productName') }}" type="text" class="form-control @error('productName') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" placeholder="Enter product name">

                                        @error('productName')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Category</label>
                                        <select name="productCategory" id="" class="form-control  @error('productCategory') is-invalid @enderror">
                                            <option value="">Choose your category</option>
                                            @foreach ($categories as $c)
                                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('productCategory')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Description</label>
                                        <textarea class="form-control @error('productDescription') is-invalid @enderror" name="productDescription" id="" cols="30" rows="10"
                                            placeholder="Enter Description">{{ old('productDescription') }}</textarea>

                                        @error('productDescription')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Image</label>
                                        <input type="file" name="productImage" id="" class="form-control @error('productImage') is-invalid @enderror">
                                        @error('productImage')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                        <input type="text" name="productWaitingTime" value="{{ old('productWaitingTime') }}" class="form-control @error('productWaitingTime') is-invalid @enderror">
                                        @error('productWaitingTime')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="cc-payment" class="control-label mb-1">Price</label>
                                        <input id="cc-pament" name="productPrice" value="{{ old('productPrice') }}" type="text" class="form-control @error('productPrice') is-invalid @enderror"
                                            aria-required="true" aria-invalid="false" placeholder="Enter Price">

                                        @error('productPrice')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="payment-button-amount">Create</span>
                                            <i class="fa-solid fa-circle-right"></i>
                                            {{-- <span id="payment-button-sending" style="display:none;">Sending…</span> --}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
