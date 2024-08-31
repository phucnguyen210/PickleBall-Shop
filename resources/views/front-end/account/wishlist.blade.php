@extends('front-end.layouts.app')
@section('title', 'Wish list')

@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('account.profile')}}">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>
    <section class=" section-11 ">
        <div class="container  mt-5">
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
                <div class="col-md-3">
                    @include('front-end.account.common.sidebar')
                 </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Wish list</h2>
                        </div>
                        @if ($wishlists == null)
                            <div class="card-body p-4">
                                @foreach ($wishlists as $wishlist)
                                    <div class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                        <div class="d-block d-sm-flex align-items-start text-center text-sm-start">
                                            @php
                                                $product_image = productImage($wishlist->product_id);
                                            @endphp
                                            <a class="d-block flex-shrink-0 mx-auto me-sm-4" href="{{ route('shop.product', $wishlist->product->slug )}}" style="width: 10rem;">
                                                @if (!empty($product_image))
                                                    <img class="card-img-top" src="{{ asset('uploads/product/small/'.$product_image->image )}}" alt="">
                                                @else
                                                    <img class="card-img-top" src="{{ asset('uploads/product/small/default_product.jpg')}}" alt="">
                                                @endif
                                            </a>
                                            <div class="pt-2">
                                                <h3 class="product-title fs-base mb-2"><a href="{{ route('shop.product', $wishlist->product->slug )}}">{{$wishlist->product->title}}</a></h3>
                                                <div class="fs-lg text-accent pt-2">
                                                    @if ($wishlist->product->compare_price > 0)
                                                        <span class="h5"><strong>${{ $wishlist->product->price}}</strong></span>
                                                        <span class="h6 text-underline"><del>${{ $wishlist->product->compare_price }}</del></span>
                                                    @else
                                                        <span class="h5"><strong>${{ $wishlist->product->price }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                            <button onclick="removeProduct({{ $wishlist->product_id }})" class="btn btn-outline-danger btn-sm" type="button"><i class="fas fa-trash-alt me-2"></i>Remove</button>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                        @else
                            <div>
                                <h3 class="h3">Your wishlist is empty!</h3>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
@section('js')
    <script>
        function removeProduct(id){
            $.ajax({
                url: `{{ route('front.removeProductWishlist') }}`,
                type: 'POST',
                data: {id:id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if(response.status == true){
                        location.reload();
                    }else{
                        location.reload();

                    }
                }

            });
        }

    </script>
@endsection
