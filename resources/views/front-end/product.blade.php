@extends('front-end.layouts.app')
@section('title', $product->title)
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.shop')}}">Shop</a></li>
                    <li class="breadcrumb-item">Your product name</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-7 pt-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-md-5">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner bg-light">

                            @if ($product->product_images)

                                @foreach ($product->product_images as $key => $imageProducts)
                                    <div class="carousel-item {{ $key == 0 ? 'active': ''}}">
                                        <img class="w-100 h-100" src="{{  asset('uploads/product/large/' . $imageProducts->image) }}" alt="Image">
                                    </div>
                                @endforeach
                            @else
                                <div class="carousel-item">
                                    <img class="w-100 h-100" src="{{ asset('uploads/product/large/default_product.jpg')}}" alt="Image">
                                </div>
                            @endif
                        </div>
                        <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                            <i class="fa fa-2x fa-angle-left text-dark"></i>
                        </a>
                        <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                            <i class="fa fa-2x fa-angle-right text-dark"></i>
                        </a>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="bg-light right">
                        <h1>{{$product->title}}</h1>
                        <div class="d-flex mb-3">
                            <div class="text-primary mr-2">
                                <div class="star-rating mt-1" title="{{ $avgRatingPer}}%">
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                        <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                        <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                        <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                        <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>

                                        <div class="front-stars" style="width: {{ $avgRatingPer}}%">
                                            <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                            <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                            <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                            <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                            <i class="fa fa-star" aria-hidden="true" style="font-size: 18px;"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <small class="pt-1">({{($product->product_ratings_count > 0) ? $product->product_ratings_count : '0'}} Reviews)</small>
                        </div>
                        <h2 class="price text-secondary"><del>${{number_format($product->compare_price, 2)}}</del></h2>
                        <h2 class="price ">${{number_format($product->price, 2)}}</h2>

                        {!! $product->short_description !!}
                        @if ( $product->track_qty == 'Yes')
                            @if ( $product->qty > 0)
                                <a href="javascript:void(0);" onclick="addToCart({{$product->id}})" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>

                            @else
                                <a href="javascript:void(0);"  class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;Out of stock</a>

                            @endif

                        @else
                            <a href="javascript:void(0);" onclick="addToCart({{$product->id}})" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>

                        @endif
                    </div>
                </div>

                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">

                               {!! $product->description !!}

                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                                {!! $product->shipping_returns !!}
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                @if (!empty($users))
                                    <div class="col-md-8">
                                        <div class="row">
                                            <form action="" method="POST" name="productRatingForm" id="productRatingForm">
                                                <h3 class="h4 pb-3">Write a Review</h3>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                                    <p class="invalid-feedback"></p>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="email">Email</label>
                                                    <input readonly type="text" class="form-control" name="email" id="email" value="{{ $users->email}}" placeholder="Email">
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="rating">Rating</label>
                                                    <br>
                                                    <div class="rating" style="width: 10rem">
                                                        <input id="rating-5" type="radio" name="rating" value="5"/><label for="rating-5"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-4" type="radio" name="rating" value="4"  /><label for="rating-4"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-3" type="radio" name="rating" value="3"/><label for="rating-3"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-2" type="radio" name="rating" value="2"/><label for="rating-2"><i class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-1" type="radio" name="rating" value="1"/><label for="rating-1"><i class="fas fa-3x fa-star"></i></label>
                                                    </div>
                                                    <p class="product-rating-error"></p>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">How was your overall experience?</label>
                                                    <textarea name="comment"  id="comment" class="form-control" cols="30" rows="10" placeholder="How was your overall experience?"></textarea>
                                                    <p class="invalid-feedback"></p>
                                                </div>
                                                <div>
                                                    <button type="submit" class="btn btn-dark">Submit</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-5">
                                        <div class="overall-rating mb-3">
                                            <div class="d-flex">
                                                <h1 class="h3 pe-3">{{$avgRating}}</h1>
                                                <div class="star-rating mt-2" title="{{ $avgRatingPer}}%">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars" style="width: {{ $avgRatingPer}}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pt-2 ps-2">({{($product->product_ratings_count > 0) ? $product->product_ratings_count : '0'}} Reviews)</div>
                                            </div>

                                        </div>
                                        @if(!empty($product->product_ratings))
                                            @foreach ($product->product_ratings as $rating)
                                                @php
                                                    $ratingPer = ($rating->rating*100)/5;
                                                @endphp
                                                <div class="rating-group mb-4">
                                                    <span> <strong>{{ $rating->username}} </strong></span>
                                                        <div class="star-rating mt-2" title="{{$ratingPer}}%">
                                                            <div class="back-stars">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>

                                                                <div class="front-stars" style="width: {{$ratingPer}}%">
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="my-3">
                                                            <p>{{$rating->comment}}</p>                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach

                                        @endif

                                    </div>
                                @else
                                <div class="col-md-12 mt-5">
                                    <div class="overall-rating mb-3">
                                        <div class="d-flex">
                                            <h1 class="h3 pe-3">{{$avgRating}}</h1>
                                            <div class="star-rating mt-2" title="{{ $avgRatingPer}}%">
                                                <div class="back-stars">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <div class="front-stars" style="width: {{ $avgRatingPer}}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pt-2 ps-2">({{($product->product_ratings_count > 0) ? $product->product_ratings_count : '0'}} Reviews)</div>
                                        </div>

                                    </div>
                                    @if(!empty($product->product_ratings))
                                        @foreach ($product->product_ratings as $rating)
                                            @php
                                                $ratingPer = ($rating->rating*100)/5;
                                            @endphp
                                            <div class="rating-group mb-4">
                                                <span> <strong>{{ $rating->username}} </strong></span>
                                                    <div class="star-rating mt-2" title="{{$ratingPer}}%">
                                                        <div class="back-stars">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>

                                                            <div class="front-stars" style="width: {{$ratingPer}}%">
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="my-3">
                                                        <p>{{$rating->comment}}</p>                                                        </p>
                                                </div>
                                            </div>
                                        @endforeach

                                    @endif

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(!empty($relatedProduct))

    <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="carousel">

                        @foreach ($relatedProduct as $relatedProducts)
                            @php

                                $imageProduct = $relatedProducts->product_images->first();
                            @endphp

                            <div class="card product-card">
                                <div class="product-image position-relative">
                                    <a href="{{route('shop.product', $relatedProducts->slug)}}" class="product-img">
                                        @if (!empty($imageProduct->image))
                                            <img class="card-img-top" src="{{ asset('uploads/product/small/'.$imageProduct->image)}}" alt="">
                                        @else
                                            <img class="card-img-top" src="{{ asset('uploads/product/small/product_default.jpg')}}" alt="">
                                        @endif
                                    </a>
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                                    <div class="product-action">
                                        @if ( $relatedProducts->track_qty == 'Yes')
                                            @if ( $relatedProducts->qty > 0)
                                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$relatedProducts->id}})">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            @else
                                                <a class="btn btn-dark" href="javascript:void(0);">
                                                    <i class="fa fa-shopping-cart"></i> Out of stock
                                                </a>
                                            @endif

                                        @else
                                            <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$relatedProducts->id}})">
                                                <i class="fa fa-shopping-cart"></i> Add To Cart
                                            </a>
                                        @endif

                                    </div>
                                </div>
                                <div class="card-body text-center mt-3">
                                    <a class="h6 link" href="{{route('shop.product', $relatedProducts->slug)}}"> {{ Str::limit($relatedProducts->title, 40) }}</a>
                                    <div class="price mt-2">
                                        <span class="h5"><strong>{{$relatedProducts->price}}</strong></span>
                                        <span class="h6 text-underline"><del>{{$relatedProducts->compare_price}}</del></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                </div>
            </div>
        </div>
    </section>
    @endif
</main>
@endsection
@section('js')
<script>
    $("#productRatingForm").submit(function(event){
        event.preventDefault();

        $.ajax({
            url: `{{ route('front.saveRating', $product->id)}}`,
            type: 'POST',
            data: $(this).serializeArray(),
            dataType: 'json',
            success : function(response){
                if(response.status == true){
                    alert(response.message);
                    location.reload();
                }else{
                    let errors = response['errors'];
                    if (errors['name']) {
                        $('#name').addClass('is-invalid').siblings('p.invalid-feedback')
                            .html(errors['name']);
                    } else {
                        $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");
                    }
                    if (errors['comment']) {
                        $('#comment').addClass('is-invalid').siblings('p.invalid-feedback')
                            .html(errors['comment']);
                    } else {
                        $('#comment').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");
                    }
                    if (errors['rating']) {
                        $('.product-rating-error').html(errors['rating']);
                    } else {
                        $('.product-rating-error').html("");
                    }
                }
            }
        });
    });
</script>
@endsection
