@extends('front-end.layouts.app')
@section('title', 'Cart')
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                @if (Cart::count() > 0)
                <div class="col-md-8">

                    <div class="table-responsive">
                        <table class="table" id="cart">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($cartContent))
                                    @foreach ($cartContent as $cart)

                                    <tr>
                                        <td class="text-start">
                                            <div class="d-flex align-items-center">
                                                @if (!empty($cart->options->productImage->image) )
                                                    <img class="" src="{{  asset('uploads/product/small/'.$cart->options->productImage->image)}}" alt="">
                                                @else
                                                    <img class="" src="{{  asset('uploads/product/small/default_product.jpg') }}" alt="">
                                                @endif

                                                <h2>{{$cart->name}}</h2>
                                            </div>
                                        </td>
                                        <td>${{$cart->price}}</td>
                                        <td>
                                            <div class="input-group quantity mx-auto" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="subtract btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1" data-id="{{$cart->rowId}}">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{$cart->qty}}">
                                                <div class="input-group-btn">
                                                    <button class=" add btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1" data-id="{{$cart->rowId}}">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            ${{ $cart->price*$cart->qty}}
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-danger" onclick="deleteCart('{{$cart->rowId}}')"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">

                        <div class="card-body">
                            <div class="sub-title">
                                <h2 class="bg-white">Cart Summery</h3>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div>${{Cart::subtotal()}}</div>
                            </div>

                            <div class="pt-3">
                                <a href="{{route('front.checkout')}}" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                            </div>
                        </div>
                    </div>

                </div>
                @else
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <h4>Your are cart is empty !</h4>
                            </div>

                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>
</main>

@endsection
@section('js')
    <script>
        // $(document).ready(function(){

            $(".add").click(function(){
                let qtyElement = $(this).parent().prev(); // từ phần tử có class chứa 'add', chọn phần tử cha sau đó chọn phần tử trước phần tử cha
                let qtyValue = parseInt(qtyElement.val()); // lấy giá trị tìm được và chuyển nó sang số nguyên
                if(qtyValue < 10) { // nếu số lượng < 10 thì tăng giá trị ở ô ban đầu lên 1
                    qtyElement.val(qtyValue+1);

                    let rowId = $(this).data('id'); //lấy rowId từ cột trong Session
                    let newQty =  qtyElement.val(); // gán số lượng mới vào biến newQty
                    updateCart(rowId,newQty);


                }
            });

            $(".subtract").click(function(){
                let qtyElement = $(this).parent().next(); //từ phần tử có class chứa 'subtract', chọn phần tử cha sau đó chọn phần tử trước phần tử cha
                let qtyValue = parseInt(qtyElement.val());
                if(qtyValue > 1) {
                    qtyElement.val(qtyValue-1);

                    let rowId = $(this).data('id');
                    let newQty =  qtyElement.val();
                    updateCart(rowId,newQty);
                }
            });

            function updateCart(rowId,qty){
                $.ajax({
                    url: `{{ route('front.updateCart')}}`,
                    type: 'POST',
                    data: {rowId:rowId, qty},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){
                        if(response.status === true){
                            location.reload();
                            // window.location.href = `{{ route('front.cart')}}`;
                        }else{
                            location.reload();
                        }
                    }

                });
            }

            function deleteCart(rowId){
             if(confirm('Are you sure you want to delete product ?')){
                $.ajax({
                    url: `{{ route('front.deleteCart')}}`,
                    type: 'POST',
                    data: {rowId: rowId},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response){
                        if(response.status === true){
                            location.reload();

                        }else{
                            location.reload();
                        }
                    }
                });
             }
            }

        // });

    </script>


@endsection
