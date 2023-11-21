@extends('user.layouts.master')

@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">

                <img class="w-100 h-100" src="{{ asset('storage/productImage/' . $product->image) }}" alt="Image">
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    {{-- <h3>{{ $myname }}</h3> --}}
                    <h3>{{ $product->name }}</h3>
                    <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                    <input type="hidden" value="{{ $product->id }}" id="productId">
                    <div class="d-flex mb-3">
                        <small class="pt-1">
                            <span class="fs-5">{{ $product->view_count + 1 }}</span> <i class="fas fa-eye"></i>
                        </small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $product->price }} mmk</h3>
                    <p class="mb-4">{{ $product->description }}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" id="count" min="1" max="5" value="1" disabled
                                class="form-control bg-secondary border-0 text-center">

                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="addCartBtn" class="btn btn-primary px-3"><i
                                class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Shop Detail End -->

    {{-- product choose  --}}
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel owl-loaded owl-drag">

                    @foreach ($productList as $p)
                        <div class="">
                            <div class="product-item bg-light">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="w-100" height="250px"
                                        src="{{ asset('storage/productImage/' . $p->image) }}" alt="">
                                    <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i
                                                class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square"
                                            href="{{ route('user#productDetails', $p->id) }}"><i
                                                class="fa fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>{{ $p->price }} mmks</h5>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small class="fa fa-star text-primary mr-1"></small>
                                        <small>(99)</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endsection


    @section('scriptSource')
        <script>
            $(document).ready(function() {
                $productId = $('#productId').val();

                // ajax ကနေ url မှာ parameter passing လုပ်ချင်ရင် ခုလိုလုပ်
                $url = "http://127.0.0.1:8000/user/ajax/product/" + $productId + "/increaseViewCount";
                $.ajax({
                    type: 'GET',
                    url: $url,
                    dataType: 'json',
                })


                $('#addCartBtn').click(function() {
                    $source = {
                        'userId': $('#userId').val(),
                        'productId': $('#productId').val(),
                        'qty': $('#count').val()
                    }

                    $.ajax({
                        type: 'GET',
                        url: '/user/ajax/addToCart/',
                        data: $source,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status == 'success') {
                                window.location.href = 'http://127.0.0.1:8000/user/home'
                            }
                        }
                    })
                })
            });
        </script>
    @endsection
