@extends('front-end.layouts.app')
@section('contents')
    <main>
        <section class="section-1">
            <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
                data-bs-interval="false">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                        <picture>
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('frontend-asset/images/joola-gen3s-slide1.jpg') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('frontend-asset/images/joola-gen3s-slide1.jpg') }}" />
                            <img src="{{ asset('frontend-asset/images//joola-gen3s-slide1.jpg') }}" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white mb-3">Pickle Ball</h1>
                                {{-- <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p> --}}
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('front.shop') }}">Shop
                                    Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">


                        <picture>
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('frontend-asset/images/team-joola-no1-slide2.jpg') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('frontend-asset/images/team-joola-no1-slide2.jpg') }}" />
                            <img src="{{ asset('frontend-asset/images/team-joola-no1-slide2.jpg') }}" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white mb-3">Pickle Ball</h1>
                                {{-- <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p> --}}
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                        <picture>
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('frontend-asset/images/ben-johns-slide3.jpg') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('frontend-asset/images/ben-johns-slide3.jpg') }}" />
                            <img src="{{ asset('frontend-asset/images/ben-johns-slide3.jpg') }}" alt="" />
                        </picture>

                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white mb-3">Pickle Ball</h1>
                                {{-- <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p> --}}
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
        <section class="section-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                        </div>
                    </div>
                    <div class="col-lg-3 ">
                        <div class="box shadow-lg">
                            <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                            <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-3">
            <div class="container">
                <div class="section-title">
                    <h2>Categories</h2>
                </div>
                <div class="row pb-3">
                    @if (getCategory()->isNotEmpty())
                        @foreach (getCategory() as $category)
                            <div class="col-lg-3">
                                <div class="cat-card">
                                    <div class="left">
                                        <img src="{{ asset('uploads/category/thumb/' . $category->image) }}" alt=""
                                            class="img-fluid">
                                    </div>
                                    <div class="right">
                                        <div class="cat-data">
                                            <h2>{{ $category->name }}</h2>
                                            <p>100 Products</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @endif

                </div>
            </div>
        </section>

        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Featured Products</h2>
                </div>
                <div class="row pb-3">
                    @if ($featuredProduct->isNotEmpty())
                        @foreach ($featuredProduct as $featuredProducts)
                            @php
                                $imageProduct = $featuredProducts->product_images->first();
                            @endphp
                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('shop.product', $featuredProducts->slug) }}"
                                            class="product-img">
                                            @if (!empty($imageProduct))
                                                <img class="card-img-top"
                                                    src="{{ asset('uploads/product/small/' . $imageProduct->image) }}"
                                                    alt="">
                                            @else
                                                <img class="card-img-top"
                                                    src="{{ asset('uploads/product/small/default_product.jpg') }}"
                                                    alt="">
                                            @endif
                                        </a>
                                        <a class="whishlist" href="javascript:void(0);"
                                            onclick="addToWishlist({{ $featuredProducts->id }})"><i
                                                class="far fa-heart"></i></a>

                                        <div class="product-action">
                                            @if ($featuredProducts->track_qty == 'Yes')
                                                @if ($featuredProducts->qty > 0)
                                                    <a class="btn btn-dark" href="javascript:void(0);"
                                                        onclick="addToCart({{ $featuredProducts->id }})">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </a>
                                                @else
                                                    <a class="btn btn-dark" href="javascript:void(0);">
                                                        <i class="fa fa-shopping-cart"></i> Out of stock
                                                    </a>
                                                @endif
                                            @else
                                                <a class="btn btn-dark" href="javascript:void(0);"
                                                    onclick="addToCart({{ $featuredProducts->id }})">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link"
                                            href="{{ route('shop.product', $featuredProducts->slug) }}">{{ $featuredProducts->title }}</a>
                                        <div class="price mt-2">
                                            @if ($featuredProducts->compare_price > 0)
                                                <span
                                                    class="h5"><strong>${{ $featuredProducts->price }}</strong></span>
                                                <span
                                                    class="h6 text-underline"><del>${{ $featuredProducts->compare_price }}</del></span>
                                            @else
                                                <span
                                                    class="h5"><strong>${{ $featuredProducts->price }}</strong></span>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @endif

                </div>
            </div>
        </section>

        <section class="section-4 pt-5">
            <div class="container">
                <div class="section-title">
                    <h2>Latest Produsts</h2>
                </div>
                <div class="row pb-3">
                    @if ($latestProduct->isNotEmpty())
                        @foreach ($latestProduct as $latestProducts)
                            @php
                                $imageProduct = $latestProducts->product_images->first();
                            @endphp

                            <div class="col-md-3">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('shop.product', $latestProducts->slug) }}" class="product-img">
                                            @if (!empty($imageProduct))
                                                <img class="card-img-top"
                                                    src="{{ asset('uploads/product/small/' . $imageProduct->image) }}"
                                                    alt="">
                                            @else
                                                <img class="card-img-top"
                                                    src="{{ asset('uploads/product/small/default_product.jpg') }}"
                                                    alt="">
                                            @endif
                                        </a>

                                        <a class="whishlist" href="javascript:void(0);"
                                            onclick="addToWishlist({{ $latestProducts->id }})"><i
                                                class="far fa-heart"></i></a>

                                        <div class="product-action">
                                            @if ( $latestProducts->track_qty == 'Yes')
                                                @if ( $latestProducts->qty > 0)
                                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$latestProducts->id}})">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </a>
                                                @else
                                                    <a class="btn btn-dark" href="javascript:void(0);">
                                                        <i class="fa fa-shopping-cart"></i> Out of stock
                                                    </a>
                                                @endif

                                            @else
                                                <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$latestProducts->id}})">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link"
                                            href="{{ route('shop.product', $latestProducts->slug) }}">{{ $latestProducts->title }}</a>
                                        <div class="price mt-2">
                                            @if ($latestProducts->compare_price > 0)
                                                <span class="h5"><strong>${{ $latestProducts->price }}</strong></span>
                                                <span
                                                    class="h6 text-underline"><del>${{ $latestProducts->compare_price }}</del></span>
                                            @else
                                                <span class="h5"><strong>${{ $latestProducts->price }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    @endif

                </div>
            </div>
            </div>
        </section>
    </main>
@endsection
