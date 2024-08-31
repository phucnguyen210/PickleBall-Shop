@extends('admin.layouts.app')
@section('title', 'orders')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Orders</h1>
            </div>
            <div class="col-sm-6 text-right">
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <button onclick="window.location.href='{{ route('orders.index')}}' "
                        class="btn btn-default btn-sm">Back</button>
                </div>
                <div class="card-tools">

                    <form action="{{ route('orders.index')}}" method="GET">
                        <div class="input-group input-group" style="width: 250px;">
                            <input type="text" value="{{ request('keyword') }}" name="keyword" id="keyword" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Orders #</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th>Date Purchased</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($orders))
                            @foreach ($orders as $order)
                                <tr>
                                    <td><a href="{{ route('orders.detail', $order->id) }}">{{ $order->id}}</a></td>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ $order->mobile }}</td>
                                    <td>
                                    @if ($order->status == 'pending')
                                        <span class="badge bg-warning">{{ $order->status}}</span>
                                    @elseif ($order->status == 'shipped')
                                        <span class="badge bg-info">{{ $order->status}}</span>
                                    @elseif ($order->status == 'delivered')
                                        <span class="badge bg-success">{{ $order->status}}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $order->status}}</span>
                                    @endif


                                    </td>
                                    <td>{{ number_format($order->grand_total, 2)}}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d, M y , H:i') }}</td>
                                </tr>

                            @endforeach

                        @endif


                    </tbody>
                </table>
            </div>
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
    <!-- /.card -->
</section>

@endsection
