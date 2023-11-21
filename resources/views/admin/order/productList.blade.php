@extends('admin.layouts.master')

@section('title', 'Order Details')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order Details</h2>

                            </div>
                        </div>
                    </div>


                    <div class="row justify-content-end my-2">
                        <div class="col-2">
                            <div class="bg-white text-center p-2">
                                <h3><i class="fas fa-database mr-3"></i> {{ count($order) }} </h3>
                            </div>
                        </div>
                    </div>

                </div>

                <h4><a href="{{ route('order#list') }}"><i class="fa-solid fa-arrow-left mr-2"></i>Back</a></h4>
                <div class="row mt-3 ml-2">
                    <div class="card col-5">
                        <div class="card-body">
                            <div>
                                <h3><i class="fa-solid fa-clipboard mr-2"></i>Order Info</h3>
                                <span class="text-warning"><i class="fa-solid fa-triangle-exclamation mr-2 mb-3"></i>Include
                                    Delivery Charges - 3000 kyats</span>
                            </div>
                            <div class="row ">
                                <div class="col"><span><i class="fa-solid fa-user mr-2"></i>Name</span></div>
                                <div class="col"><span>Aung Aung</span></div>


                            </div>
                            <div class="row ">
                                <div class="col"><span><i class="fa-solid fa-barcode mr-2"></i>Order Code</span></div>
                                <div class="col"><span>{{ $order[0]->order_code }}</span></div>
                            </div>
                            <div class="row ">

                                <div class="col"><span><i class="fa-solid fa-clock mr-2"></i>Order Date</span></div>
                                <div class="col"><span>{{ $order[0]->created_at->format('d/F/Y') }}</span></div>

                            </div>
                            <div class="row ">

                                <div class="col"><span><i class="fa-solid fa-money-bill mr-2"></i>Total</span></div>
                                <div class="col"><span>{{ $orderTotalPrice->total_price }} kyats</span></div>

                            </div>

                        </div>


                    </div>
                </div>
                <div class="table-responsive table-responsive-data2">

                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th></th>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Product Image</th>
                                <th>Product Name</th>
                                <th>Order Date</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($order as $o)
                                <tr>
                                    <td></td>
                                    <td class="">{{ $o->user_id }}</td>
                                    <td class="">{{ $o->user_name }}</td>
                                    <td><img src="{{ asset('storage/productImage/' . $o->product_image) }}" alt=""
                                            width="100px" height="100px"></td>
                                    <td>{{ $o->product_name }}</td>
                                    <td class="">{{ $o->created_at->format('d/F/Y') }}</td>
                                    <td>{{ $o->qty }}</td>
                                    <td class="">{{ $o->total }} mmks</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{-- request()->query() သည် every pagination link တိုင်းအတွက်
                                query result ကို append လုပ်ပေးသွားတာ
                            --}}
                    {{-- {{ $order->links() }} --}}
                </div>
                <!-- END DATA TABLE -->
            </div>
        </div>
    </div>
    </div>
    <!-- END MAIN CONTENT-->



@endsection


@section('myjs')
    <script>
        $(document).ready(function() {

            $('.orderStatusChange').change(function() {
                $parentNode = $(this).parents('tr');
                $status = $parentNode.find('.orderStatusChange').val();
                $orderId = $parentNode.find('#orderId').val();

                $.ajax({
                    type: 'GET',
                    url: 'http://127.0.0.1:8000/order/ajax/changeStatus',
                    dataType: 'json',
                    data: {
                        'orderStatus': $status,
                        'orderId': $orderId,
                    }
                })
            })

        })
    </script>
@endsection
