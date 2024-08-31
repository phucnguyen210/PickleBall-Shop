@extends('admin.layouts.app')
@section('title', 'Shipping')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Shipping</h1>

            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('shipping.create') }}" class="btn btn-primary">New Shipping</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
@include('admin.message')
@endsection
