@extends('admin.layouts.master')

@section('title', 'Product detail')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">

                <div class="col-lg-12 ">

                    @if (session('accountUpdateSuccess'))
                        <div class="row">
                            <div class="col-md-7 offset-5">

                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session('accountUpdateSuccess') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <a href="#" onclick="history.back()"><i
                                        class="fas fa-arrow-left ml-4 text-dark"></i></a>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Product Details</h3>
                            </div>
                            <hr>

                            <div class="row justify-content-md-around px-0 px-sm-5">
                                <div class=" col-12 col-sm-6 col-md-3 mt-3 text-center text-sm-left">
                                    <div>
                                        <img class="img-fluid" style="max-height: 300px;"
                                            src="{{ asset('storage/productImage/' . $product->image) }}" />
                                    </div>

                                    <div class="mt-3">
                                        <a href="{{ route('product#editPage', $product->id) }}" class="btn btn-dark py-2">
                                            <i class="fas fa-edit mr-2"></i>Edit Product
                                        </a>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-8">
                                    <div class="row">
                                        <div class="col-12">
                                            <span class="my-3 btn btn-danger text-white"><i
                                                    class="fas fa-sticky-note mr-2"></i>{{ $product->name }}</span>
                                        </div>
                                        <div class="col-12">
                                            <span class="my-3 btn btn-dark text-white"><i
                                                    class="fas fa-dollar-sign mr-2"></i>{{ $product->price }} mmk
                                            </span>
                                            <span class="my-3 btn btn-dark text-white"><i
                                                    class="fas fa-clock mr-2"></i>{{ $product->waiting_time }} mins
                                            </span>
                                            <span class="my-3 btn btn-dark text-white"><i
                                                    class="fas fa-eye mr-2"></i>{{ $product->view_count }}</span>
                                            <span class="my-3 btn btn-dark text-white"><i
                                                    class="fas fa-clone mr-2"></i>{{ $product->category_name }}</span>
                                            <span class="my-3 btn btn-dark text-white"><i
                                                    class="fa-solid fa-user-clock"></i>{{ $product->created_at->format('j-F-Y') }}
                                            </span>
                                        </div>
                                        <div class="col-12">
                                            <i class="fas fa-file-alt mr-2" style="font-size: 20px;"></i>Details
                                            <div>
                                                {{ $product->description }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-2 offset-1 mt-2 p-0">
                                    <a href="{{ route('admin#edit') }}" class="btn btn-dark px-3 py-2">
                                        <i class="fas fa-edit mr-2"></i>Edit Profile
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
