@extends('front-end.layouts.app')
@section('title', 'Shop')
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if (!empty($category))
                                    @foreach ($category as $index => $categories)
                                        <div class="accordion-item">
                                            @if ( $categories->sub_categories->isNotEmpty())

                                                    <h2 class="accordion-header" id="heading-{{ $index}}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index}}" aria-expanded="false" aria-controls="collapse-{{ $index}}">
                                                            {{ $categories->name }}
                                                        </button>
                                                    </h2>
                                            @else
                                                <a href="{{ route('front.shop', $categories->slug)}}" class="nav-item nav-link  {{ $categorySelected == $categories->id ? 'text-primary': ''}}">{{ $categories->name}}</a>
                                            @endif

                                            @if ( $categories->sub_categories->isNotEmpty())
                                                @foreach ( $categories->sub_categories as $sub_categories)
                                                    <div id="collapse-{{ $index}}" class="accordion-collapse collapse {{ $categorySelected == $categories->id ? 'show': ''}}" aria-labelledby="heading{{ $index}}" data-bs-parent="#accordionExample" style="">
                                                        <div class="accordion-body">
                                                            <div class="navbar-nav">
                                                                <a href="{{ route('front.shop', [$categories->slug, $sub_categories->slug]) }}" class="nav-item nav-link {{ $subCategorySelected == $sub_categories->id ? 'text-primary': ''}}">{{ $sub_categories->name}}</a>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach
                                            @endif

                                        </div>

                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Brand</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if (!empty($brand))
                                @foreach ($brand as $key => $brands)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input brand-label" {{ in_array($brands->id, $brandArray ) ? 'checked' : ''}} name="brand[]" type="checkbox" value="{{ $brands->id}}" id="brand-{{$brands->id}}">
                                        <label class="form-check-label" for="brand-{{$brands->id}}">
                                            {{ $brands->name}}
                                        </label>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                    </div>

                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="" />

                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">

                                    <select name="sort" id="sort" class="form-control">
                                        <option {{ $sort == 'latest' ? 'selected' : ''}} value="latest">Latest</option>
                                        <option {{ $sort == 'price_desc' ? 'selected' : ''}} value="price_desc">High Price</option>
                                        <option {{ $sort == 'price_asc' ? 'selected' : ''}} value="price_asc">Low Price</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if (!empty($product))
                            @foreach ($product as $products)
                                @php
                                    $imageProduct = $products->product_images->first();
                                @endphp
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <a href="{{ route('shop.product', $products->slug)}}" class="product-img">
                                                @if (!empty($imageProduct))
                                                    <img class="card-img-top" src="{{ asset('uploads/product/small/'.$imageProduct->image )}}" alt="">
                                                @else
                                                    <img class="card-img-top" src="{{ asset('uploads/product/small/default_product.jpg')}}" alt="">
                                                @endif
                                            </a>
                                            <a class="whishlist" href="javascript:void(0);" onclick="addToWishlist({{ $products->id }})"><i class="far fa-heart"></i></a>

                                            <div class="product-action">
                                                @if ( $products->track_qty == 'Yes')
                                                    @if ( $products->qty > 0)
                                                        <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$products->id}})">
                                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                                        </a>
                                                    @else
                                                        <a class="btn btn-dark" href="javascript:void(0);">
                                                            <i class="fa fa-shopping-cart"></i> Out of stock
                                                        </a>
                                                    @endif

                                                @else
                                                    <a class="btn btn-dark" href="javascript:void(0);" onclick="addToCart({{$products->id}})">
                                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                                    </a>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link" href="{{ route('shop.product', $products->slug)}}">{{$products->title}}</a>
                                            <div class="price mt-2">
                                                <span class="h5"><strong>${{$products->price}}</strong></span>
                                                <span class="h6 text-underline"><del>${{$products->compare_price}}</del></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        @endif




                        <div class="col-md-12 pt-5 d-flex justify-content-end">
                               {{ $product->withQueryString()->links('pagination::bootstrap-4') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
@section('js')
<script>

    rangeSlide = $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 0,
        max: 10000,
        from: {{ $price_Min }}, // lưu lại giá trị min người dùng đã chọn
        step: 500,
        to: {{ $price_Max }}, // lưu lại giá trị max người dùng đã chọn
        skin: "round",
        max_postfix: "+",
        prefix: "$",
        onFinish: function(){
            apply_filters()
        }
    });
    // saving it's intanse
    let slider = $(".js-range-slider").data("ionRangeSlider");


    $(".brand-label").change(function(){
        apply_filters();
    });

    $("#sort").change(function(){
        apply_filters();
    });

    function apply_filters(){
        let brands = [];
        $(".brand-label").each(function(){
            if($(this).is(":checked") == true){
                brands.push($(this).val()); // nếu phần tử được chọn thì thêm giá trị của phần tử đó vào mảng brands
            }
        });

        console.log(brands.toString());
        let url = '{{ url()->current() }}?'; // lấy url ban đầu

        // Price range filters
        url += '&price_min='+slider.result.from +'&price_max='+slider.result.to;

        // Brands filters
        if(brands.length > 0){
            url = url+'&brand='+brands.toString()
        }
        let search = $("#search").val();
        if(search.length > 0){
            url += '&search='+search;
        }

        // Sorting filter

        url += '&sort='+$("#sort").val();

        window.location.href = url;

    }
</script>

@endsection

