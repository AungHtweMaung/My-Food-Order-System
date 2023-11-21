@extends('admin.layouts.master')

@section('title', 'Order')

@section('content')
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

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

                    <form action="{{ route('order#status') }}" method="GET">
                        <div class="d-flex">

                            <select name="orderStatus" class="form-control col-2">
                                <!-- selected လုပ်တဲ့အချိန်မှာ orderStatus ကို string နဲ့ထည့်ပေးမှ result ထွက်လာမှာ
                                        orderStatus သည် url ကပါတဲ့ ဟာကိုယူထားတာ
                                    -->
                                <option value="">All</option>
                                <option value="0" @if (request('orderStatus') == '0') selected @endif><span
                                        class="text-warning">Pending</span></option>
                                <option value="1" @if (request('orderStatus') == '1') selected @endif>Accept</option>
                                <option value="2" @if (request('orderStatus') == '2') selected @endif>Reject</option>
                            </select>
                            <button type="submit" class="btn btn-dark ml-3"><i class="fa-solid fa-magnifying-glass mr-2"></i>Search</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>User Name</th>
                                <th>Order Date</th>
                                <th>Order Code</th>
                                <th>Amount</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($order as $o)
                                <tr>
                                    <input type="hidden" value="{{ $o->id }}" id="orderId">
                                    <td class="">{{ $o->user_id }}</td>
                                    <td class="">{{ $o->username }}</td>
                                    <td class="">{{ $o->created_at->format('d/F/Y') }}</td>
                                    <td class="orderCode">
                                        <a href="{{ route('order#productList', $o->order_code) }}">{{ $o->order_code }}</a>
                                    </td>
                                    <td class="">{{ $o->total_price }} mmks</td>
                                    <td class="">
                                        <select class="form-control text-center orderStatusChange">
                                            <option value="0" @if ($o->status == '0') selected @endif>
                                                Pending
                                            </option>
                                            <option value="1" @if ($o->status == '1') selected @endif>
                                                Accept</option>
                                            <option value="2" @if ($o->status == '2') selected @endif>
                                                Reject</option>
                                        </select>
                                    </td>
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
                    url: '/order/ajax/changeStatus',
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
