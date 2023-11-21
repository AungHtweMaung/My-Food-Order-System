@extends('user.layouts.master')

@section('title')
    Order History
@endsection

@section('content')
    <div class="container-fluid" style="height: 400px;">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5" style="margin: 0 auto">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="tableData">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $o)
                            <tr>
                                <td>{{ $o->created_at->format('Y-M-d') }}</td>
                                <td>{{ $o->order_code }}</td>
                                <td>{{ $o->total_price }} mmks</td>
                                <td>
                                    @if ($o->status == 0)
                                        <span class="text-warning "><i class="fa-solid fa-clock"></i> Pending...</span>
                                    @elseif ($o->status == 1)
                                        <span class="text-success "><i class="fa-solid fa-check"></i> Success...</span>
                                    @elseif ($o->status == 2)
                                        <span class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i>
                                            Reject...</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="d-flex justify-content-end mt-3">
                    {{ $order->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
