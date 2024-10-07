@extends('user.layouts.master')

@section('title')
    Home
@endsection


@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter
                        by categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="bg-dark p-3 d-flex align-items-center justify-content-between mb-3">

                            <label class="text-white" for="price-all">Categories</label>
                            <span class="badge badge-secondary">{{ count($categories) }}</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 ">
                            <a href="{{ route('user#home') }}"><span class="">All</span></a>
                        </div>
                        @foreach ($categories as $c)
                            <div
                                class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 ">

                                <a href="{{ route('user#filterByCategory', $c->id) }}"><span
                                        class="">{{ $c->name }}</span></a>
                            </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->



                <!-- Size Start -->
                <div class="">
                    <button class="btn btn btn-warning w-100">Order</button>
                </div>
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3 my-form">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route('user#cartList') }}" type="button" class="btn btn-dark px-3 position-relative">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ count($cart) }}
                                    </span>
                                </a>
                                <a href="{{ route('user#history') }}" type="button" class="btn btn-dark px-3 position-relative">
                                    <i class="fa-solid fa-clock-rotate-left"></i> History
                                </a>
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">
                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="">
                        <div class="row" id="dataList">
                            @if (count($products) != 0)
                                @foreach ($products as $p)
                                    <a href="{{ route('user#productDetails', $p->id) }}">
                                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                            <div class="product-item bg-light mb-4">
                                                <div class="product-img position-relative overflow-hidden">
                                                    <img class="img-fluid w-100" style="height: 220px"
                                                        src="{{ asset('storage/productImage/' . $p->image) }}"
                                                        alt="">
                                                    <div class="product-action">
                                                        <a class="btn btn-outline-dark btn-square"
                                                            href="{{ route('user#productDetails', $p->id) }}"><i
                                                                class="fa fa-circle-info"></i></a>
                                                    </div>
                                                </div>
                                                <div class="text-center py-4">
                                                    <a class="h6 text-decoration-none text-truncate"
                                                        href="">{{ $p->name }}</a>
                                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                                        <h5>{{ $p->price }}</h5>
                                                        {{-- <h6 class="text-muted ml-2"><del>25000</del></h6> --}}
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                                        <small class="fa fa-star text-primary mr-1"></small>
                                                        <small class="fa fa-star text-primary mr-1"></small>
                                                        <small class="fa fa-star text-primary mr-1"></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="col-md-5 p-5 bg-dark mx-auto">
                                    <p class="text-white text-center">There is no food</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
    </div>
    <!-- Shop End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            
            
            
            $('#sortingOption').change(function() {
                $eventOption = $('#sortingOption').val();
                // console.log($eventOption);
                $.ajax({
                    type: 'get',
                    url: '/user/ajax/productList',
                    data: {
                        'status': $eventOption
                    },
                    dataType: 'json',
                    success: function(response) {
                        // console.log(response.products);
                        list = '';
                        for (let i = 0; i < response.products.length; i++) {
                            list += `
                            <a href="detail.html">
                                <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                    <div class="product-item bg-light mb-4">
                                        <div class="product-img position-relative overflow-hidden">
                                            <img class="img-fluid w-100" style="height: 220px"
                                                src="{{ asset('storage/productImage/${response.products[i].image}') }}" alt="">
                                            <div class="product-action">
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-shopping-cart"></i></a>
                                                <a class="btn btn-outline-dark btn-square" href=""><i
                                                        class="fa fa-circle-info"></i></a>
                                            </div>
                                        </div>
                                        <div class="text-center py-4">
                                            <a class="h6 text-decoration-none text-truncate" href="">${response.products[i].name}</a>
                                            <div class="d-flex align-items-center justify-content-center mt-2">
                                                <h5>${response.products[i].price}</h5>
                                                <h6 class="text-muted ml-2"><del>25000</del></h6>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-center mb-1">
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>`;
                        }
                        $('#dataList').html(list);
                        // console.log(list);
                    }
                });
            })
        });
    </script>
@endsection


<!--
    Original code of ajax in this project
    -----------------------------------------

    $(document).ready(function() {

            $('#sortingOption').change(function() {
                let eventOption = $('#sortingOption').val();

                if (eventOption == 'desc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/products/list',
                        data: {
                            'status': 'desc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            list = '';
                            for (let i = 0; i < response.length; i++) {
                                list += `
                                <a href="detail.html">
                                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                        <div class="product-item bg-light mb-4">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100" style="min-height: 220px"
                                                    src="{{ asset('storage/productImage/${response[i].image}') }}" alt="">
                                                <div class="product-action">
                                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                                            class="fa fa-shopping-cart"></i></a>
                                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                                            class="fa fa-circle-info"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center py-4">
                                                <a class="h6 text-decoration-none text-truncate"
                                                    href="">${response[i].name}</a>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>${response[i].price}</h5>
                                                    <h6 class="text-muted ml-2"><del>25000</del></h6>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center mb-1">
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                `;
                            }
                            $('#dataList').html(list);
                        }
                    })
                } else if (eventOption == 'asc') {
                    $.ajax({
                        type: 'get',
                        url: 'http://127.0.0.1:8000/user/ajax/products/list',
                        data: {
                            status: 'asc'
                        },
                        dataType: 'json',
                        success: function(response) {
                            list = '';
                            for (let i = 0; i < response.length; i++) {
                                list += `
                                <a href="detail.html">
                                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                        <div class="product-item bg-light mb-4">
                                            <div class="product-img position-relative overflow-hidden">
                                                <img class="img-fluid w-100" style="min-height: 220px"
                                                    src="{{ asset('storage/productImage/${response[i].image}') }}" alt="">
                                                <div class="product-action">
                                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                                            class="fa fa-shopping-cart"></i></a>
                                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                                            class="fa fa-circle-info"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center py-4">
                                                <a class="h6 text-decoration-none text-truncate"
                                                    href="">${response[i].name}</a>
                                                <div class="d-flex align-items-center justify-content-center mt-2">
                                                    <h5>${response[i].price}</h5>
                                                    <h6 class="text-muted ml-2"><del>25000</del></h6>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-center mb-1">
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                    <small class="fa fa-star text-primary mr-1"></small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                `;
                            }
                            $('#dataList').html(list);
                        }
                    })
                }
            })


        });
        // console.log('hello world');

-->
