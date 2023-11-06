@extends('user.layouts.master')

@section('title')
    Cart
@endsection

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="tableData">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cartList as $c)
                            <tr>
                                {{-- <input type="hidden" id="price" value="{{ $c->product_price }}"> --}}
                                <td class="align-middle"><img src="" alt="" style="width: 50px;">
                                    {{ $c->product_name }}</td>
                                <td class="align-middle" id="price">{{ $c->product_price }} kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" disabled
                                            class="form-control form-control-sm bg-secondary border-0 text-center"
                                            value="{{ $c->qty }}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle" class="totalPrice" id="totalPrice">
                                    {{ $c->product_price * $c->qty }} kyats</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btn-remove"><i
                                            class="fa fa-times"></i></button></td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $totalPrice }} kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="allTotalPrice">{{ $totalPrice + 3000 }} kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {
            // input ရဲ့ value ကိုယူမယ်ဆိုရင် val() နဲ့ယူ
            // အခြား tag တွေရဲ့ value ကိုယူမယ်ဆိုရင် html() or text() နဲ့ယူ
            $('.btn-plus, .btn-minus').click(function() {
                // parents တွေထဲက tr ကိုယူတာ
                $parentNode = $(this).parents('tr');
                // tr parent ကနေ သူ့ရဲ့ အတွင်းက ပေးထားတဲ့ id child  တွေကိုယူတာ
                $price = $parentNode.find('#price').text().replace('kyats', '');

                $qty = $parentNode.find('#qty').val();
                $totalPrice = $price * $qty;

                $parentNode.find('#totalPrice').html($totalPrice + " kyats");

                summaryCalculation();

            })


            $('.btn-remove').click(function() {
                $parentNode = $(this).parents('tr');
                $parentNode.remove();

                summaryCalculation();
            })

            function summaryCalculation() {
                $allTotalPrice = 0;
                $subTotalPrice = 0;

                // To change subtotal price and latest total price, Get each total price, when click btn plus or btn minus
                $('#tableData tbody tr').each(function(index, record) {
                    $subTotalPrice = $allTotalPrice += parseInt($(record).find('#totalPrice').text()
                        .replace('kyats', ''));

                });

                $('#subTotalPrice').html(`${$subTotalPrice} kyats`)

                // $allTotalPrice += 3000;
                $('#allTotalPrice').html(`${$allTotalPrice + 3000} kyats`);
            }
        })
    </script>
@endsection
