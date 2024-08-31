@extends('admin.layouts.app')
@section('title', 'orders-detail')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Order: #{{$order->id}}</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('orders.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    @include('admin.message')
                    <div class="card-header pt-3">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                            <h1 class="h5 mb-3">Shipping Address</h1>
                            <address>
                                <strong>{{$order->first_name." ".$order->last_name}}</strong><br>
                                Address: {{$order->address}}<br>
                                City: {{$order->city}}<br>
                                Phone: {{ formatPhoneNumber($order->mobile )}}<br>
                                Email: {{ $order->email}}<br>
                                <strong>Shipped Date: {{ \Carbon\Carbon::parse($order->shipped_date)->format('d, M y, H:i')}}</strong>
                            </address>
                            </div>



                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #007612</b><br>
                                <br>
                                <b>Order ID:</b> {{ $order->id}}<br>
                                <b>Total:</b> ${{number_format($order->grand_total, 2)}}<br>
                                <b>Status:</b>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-warning">{{ $order->status}}</span>
                                    @elseif ($order->status == 'shipped')
                                        <span class="badge bg-info">{{ $order->status}}</span>
                                    @elseif ($order->status == 'delivered')
                                        <span class="badge bg-success">{{ $order->status}}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $order->status}}</span>
                                    @endif

                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-3">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="100">Qty</th>
                                    <th width="100">Total</th>
                                </tr>

                            </thead>
                            <tbody>

                                @foreach ($orderItems as $orderItem)
                                    <tr>
                                        <td>{{ $orderItem->name}}</td>
                                        <td>$ {{ number_format($orderItem->price, 2) }}</td>
                                        <td>{{ $orderItem->qty}}</td>
                                        <td>$ {{ number_format($orderItem->total, 2)}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="3" class="text-right">Subtotal:</th>
                                    <td>$ {{ number_format($order->subtotal, 2)}}</td>
                                </tr>

                                <tr>
                                    <th colspan="3" class="text-right">Shipping:</th>
                                    <td>$ {{ number_format($order->shipping, 2)}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Discount:</th>
                                    <td>$ {{ number_format($order->discount, 2)}}</td>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-right">Grand Total:</th>
                                    <td>$ {{ number_format($order->grand_total, 2)}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <form action="" method="POST" name="changeOrderStatusForm" id="changeOrderStatusForm" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <h2 class="h4 mb-3">Order Status</h2>
                            <div class="mb-3">
                                <select name="status" id="status" class="form-control">
                                    <option {{ ($order->status == "pending") ? 'selected' : ""}} value="pending">Pending</option>
                                    <option {{ ($order->status == "shipped") ? 'selected' : ""}} value="shipped">Shipped</option>
                                    <option {{ ($order->status == "delivered") ? 'selected' : ""}} value="delivered">Delivered</option>
                                    <option {{ ($order->status == "cancelled") ? 'selected' : ""}} value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="shipped_date">Shipped date</label>
                                <input autocomplete="off" type="text" name="shipped_date" id="shipped_date" value="{{ $order->shipped_date}}" class="form-control" placeholder="Shipped date">
                            </div>


                            <div class="mb-3">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="" id="sendInoviceMail" method="POST">
                            <h2 class="h4 mb-3">Send Inovice Email</h2>
                            <div class="mb-3">
                                <select name="userType" id="userType" class="form-control">
                                    <option value="customer">Customer</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('js')
    <Script>

        $(document).ready(function(){
            $('#shipped_date').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });

        });

        $("#changeOrderStatusForm").submit( function(event){
            event.preventDefault();
            let e = $(this);

            if(confirm('Are you sure want to change status ?')){
                $.ajax({
                url: `{{ route("orders.changeOrderStatus", $order->id) }}`,
                type: 'POST',
                data: e.serializeArray(),
                dataType: 'json',
                success: function(response){
                    if(response.status == true){
                        alert(response.message);
                        location.reload();
                    }
                }
            });
            }


        });


        $("#sendInoviceMail").submit( function(event){
            event.preventDefault();
            let element = $(this);

            if(confirm('Are you sure want to send email ?')){
                $.ajax({
                url: `{{ route("orders.sendInoviceMail", $order->id) }}`,
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response){
                    if(response.status == true){
                        alert(response.message);
                        location.reload();
                    }
                }
                });

            }

        });
    </Script>
@endsection
