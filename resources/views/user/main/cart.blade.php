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
                            <th></th>
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
                                <input type="hidden" name="cartId" id="cartId" value="{{ $c->id }}">
                                <input type="hidden" name="userId" id="userId" value="{{ $c->user_id }}">
                                <input type="hidden" name="productId" id="productId" value="{{ $c->product_id }}">

                                <td><img src="{{ asset('storage/productImage/' . $c->product_image) }}" alt=""
                                        style="width: 100px;"></td>
                                <td class="align-middle">
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
                                            id="qty" value="{{ $c->qty }}" id="qty">
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
                        <button class="btn btn-block btn-primary orderBtn font-weight-bold my-3 py-3">Order</button>
                        <button class="btn btn-block btn-danger clearCartBtn font-weight-bold my-3 py-3">Clear Cart</button>
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
                $productId = $parentNode.find('#productId').val(); // parentNode ကို this နဲ့ ဖမ်းထားပြီးသား
                $qty = $parentNode.find('#qty').val();
                $totalPrice = $price * $qty;

                $parentNode.find('#totalPrice').html($totalPrice + " kyats");

                summayTotal();


                // when btn plus or minus is clicked,  quantity ကို database ထဲမှာပါ လိုက်ပြောင်းစေချင်လို့
                // product id နဲ့ qty ကို ajax နဲ့ ပို့ပြီး up to date ဖြစ်အောင်ရေးတာ
                $.ajax({
                    type: 'GET',
                    url: '/user/ajax/update/product-qty',
                    dataType: 'json',
                    data: {
                        'quantity': $qty,
                        'productId': $productId,
                    }
                })
            })

            $('.btn-remove').click(function() {
                $parentNode = $(this).parents('tr');
                $productId = $parentNode.find('#productId').val();
                $cartId = $parentNode.find('#cartId').val();

                $.ajax({
                    type: 'GET',
                    url: '/user/ajax/remove/cart-item',
                    dataType: 'json',
                    data: {
                        'productId': $productId,
                        'cartId': $cartId,
                    },
                })
                $parentNode.remove();


                summayTotal();

            })


            function summayTotal() {
                $totalPrice = 0;

                // To change subtotal price and latest total price, Get each total price from parent element, when click btn plus or btn minus
                $('#tableData tbody tr').each(function(index, record) {
                    $totalPrice += parseInt($(record).find('#totalPrice').text().replace(' kyats', ''));
                })

                $('#subTotalPrice').html($totalPrice + ' kyats');
                $('#allTotalPrice').html(`${$totalPrice + 3000} kyats `)
            }


            // order
            $orderList = [];
            $('.orderBtn').click(function() {
                // order btn တခါနှိပ်ရင် သူ့ cardList ထဲက item အတွက် order code ကတူတူပဲ
                $random = Math.floor(Math.random() * 10000001);

                // table ထဲက record အားလုံးကို ယူပြီး array ထဲထည့်ပြီး ajax နဲ့ ပို့တာ
                $('#tableData tbody tr').each(function(index, record) {

                    $orderList.push({
                        'userId': $(record).find('#userId').val(),
                        'productId': $(record).find('#productId').val(),
                        'qty': $(record).find('#qty').val(),
                        'total': parseInt($(record).find('#totalPrice').text().replace(
                            ' kyats', '')),
                        'orderCode': 'POS' + $random
                    })
                })

                // data ကို object type ပြောင်းပြီး ajax နဲ့ပို့တာ

                $.ajax({
                    type: 'GET',
                    url: '/user/ajax/order',
                    data: Object.assign({}, $orderList),
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = '/user/home'
                        }
                    }

                })

            })


            // clear cart
            $('.clearCartBtn').click(function() {
                $('#tableData tbody tr').remove();
                $('#subTotalPrice').html('0 kyats');
                $('#allTotalPrice').html(`3000 kyats`)

                $.ajax({
                    type: 'GET',
                    url: 'http://127.0.0.1:8000/user/ajax/clear/cart',
                    dataType: 'json'
                })
            })
        });
    </script>
@endsection
