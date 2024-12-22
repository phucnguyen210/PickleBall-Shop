@extends('front-end.layouts.app')
@section('title', 'Checkout')
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            <form action="" id="orderForm" method="POST" name="orderForm">
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name" value="{{ (!empty($customerAddress)) ? $customerAddress->first_name : ''}}">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name" value="{{ (!empty($customerAddress)) ? $customerAddress->last_name : ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" value="{{ (!empty($customerAddress)) ? $customerAddress->email : ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Select a Country</option>
                                                @foreach ($countries as $country)
                                                    <option {{ (!empty($customerAddress)) && $customerAddress->country_id == $country->id ? 'selected' : ''}} value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control">
                                                {{ (!empty($customerAddress)) ? $customerAddress->address : ''}}
                                            </textarea>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="appartment" id="apartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)" value="{{ (!empty($customerAddress)) ? $customerAddress->apartment : ''}}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control" placeholder="City" value="{{ (!empty($customerAddress)) ? $customerAddress->city : ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control" placeholder="State" value="{{ (!empty($customerAddress)) ? $customerAddress->state : ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control" placeholder="Zip" value="{{ (!empty($customerAddress)) ? $customerAddress->zip : ''}}">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Mobile No." value="{{ (!empty($customerAddress)) ? $customerAddress->mobile : ''}}">
                                            <p></p>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">
                                @foreach (Cart::content() as $item)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6">{{$item->name}} X {{$item->qty}}</div>
                                        <div class="h6  ">$ {{$item->price*$item->qty}}</div>
                                    </div>
                                @endforeach


                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong>${{Cart::subtotal()}}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Discount</strong></div>
                                    <div class="h6" ><strong id="discount">${{ number_format($discount, 2)}}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong id="shippingCharge">${{ number_format($totalShippingCharge, 2)}}</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong id="grandTotal">${{number_format($grandTotal, 2)}}</strong></div>
                                </div>
                            </div>
                            <div class="input-group apply-coupon mt-4">
                                <input type="text" placeholder="Coupon Code" name="discount_code" id="discount_code" class="form-control">
                                <button class="btn btn-dark" type="button" id="apply-discount" >Apply Coupon</button>
                            </div>

                            <div id="discount-response-wrapper">
                                @if (Session::has('code'))
                                    <div id="discount-response" class=" mt-4">
                                        <strong>{{ Session::get('code')->code}}</strong>
                                        <a id="remove-discount" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>

                                    </div>
                                @endif
                            </div>

                        </div>

                        <div class="card payment-form">
                            <h3 class="card-title h5 mb-3 d-none mt-3">Payment Method</h3>
                            <div class="">
                                <input checked type="radio" name="payment_method" value="cod" id="payment_method_one">
                                <label for="payment_method_one" class="form-check-label">COD</label>
                            </div>
                            <div class="">
                                <input type="radio" name="payment_method" value="cod" id="payment_method_two">
                                <label for="payment_method_two" class="form-check-label">Stripe</label>
                            </div>

                            <div class="card-body p-0 d-none" id="card-payment-form">
                                <div class="mb-3">
                                    <label for="card_number" class="mb-2">Card Number</label>
                                    <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">Expiry Date</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expiry_date" class="mb-2">CVV Code</label>
                                        <input type="text" name="expiry_date" id="expiry_date" placeholder="123" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="pt-4">
                                {{-- <a href="#" class="btn-dark btn btn-block w-100">Pay Now</a> --}}
                                <button class="btn-success btn btn-block w-100" type="submit">Pay Now</button>
                            </div>
                        </div>


                        <!-- CREDIT CARD FORM ENDS HERE -->

                    </div>
                </div>
            </form>
        </div>
    </section>
</main>
@endsection
@section('js')
<script>
    // chọn phần tử có ID là "payment_method_one
    // Khi phần tử này được nhấp vào

    $("#payment_method_one").click(function(){

        if($(this).is(":checked") == true){   // Kiểm tra xem phần tử này có được chọn hay không
            $("#card-payment-form").addClass('d-none');  //Nếu phần tử này được chọn (checked), Thêm lớp "d-none" vào phần tử có ID là "card-payment-form

        }
    });
    $("#payment_method_two").click(function(){
        if($(this).is(":checked") == true){
            $("#card-payment-form").removeClass('d-none');

        }
    });

    $("#orderForm").submit(function(event){
        event.preventDefault();
        let element = $(this);
        // $('button[type="submit"]').prop('disabled', true);
        $.ajax({
            url: `{{ route('front.processCheckout')}}`,
            type: 'POST',
            data: element.serializeArray(),
            dataType: 'json',
            success: function (response){
            $('button[type="submit"]').prop('disabled', false);

                function handleFieldError(field, errorMessage){
                        if(errorMessage){
                            $("#"+field).siblings("p").addClass("invalid-feedback").html(errorMessage);
                            $("#"+field).addClass('is-invalid');
                        }else{
                            $("#"+field).siblings("p").removeClass("invalid-feedback").html('');
                            $("#"+field).removeClass('is-invalid');
                        }
                    }

                let errors = response.errors;
                if(response.status === false){

                    handleFieldError('first_name', errors.first_name);
                    handleFieldError('last_name', errors.last_name);
                    handleFieldError('email', errors.email);
                    handleFieldError('mobile', errors.mobile);
                    handleFieldError('country', errors.country);
                    handleFieldError('address', errors.address);
                    handleFieldError('city', errors.city);
                    handleFieldError('state', errors.state);
                    handleFieldError('zip', errors.zip);


                }else{
                    alert(response.message);
                    window.location.href=`{{ route('front.thankyou', ':order_id')}}`.replace(':order_id', response.order_id);

                }
            }
        });
    });

    $("#country").change(function(){
        $.ajax({
            url:`{{ route('front.getOrderSummery')}}`,
            type: 'POST',
            data: {country_id: $(this).val()},
            dataType: 'json',
            success: function(response){
                if(response.status === true){
                    $("#shippingCharge").html('$'+response.shippingCharge);
                    $("#grandTotal").html('$'+response.grandTotal);

                }
            }
        });
    });

    $("#apply-discount").click(function(){

        $.ajax({
            url:`{{ route('front.applyDiscount') }}`,
            type: 'POST',
            data: {code: $("#discount_code").val(), country_id: $("#country").val()},
            dataType: 'json',
            success: function(response){
                if(response.status === true){
                    $("#shippingCharge").html('$'+response.shippingCharge);
                    $("#grandTotal").html('$'+response.grandTotal);
                    $("#discount").html('$'+response.discount);
                    $("#discount-response-wrapper").html(response.discountString);

                }else{
                    // alert('coupons expires!');
                    $("#discount-response-wrapper").html("<span class='text-danger'>"+response.message+"</span>");

                }
            }
        });
    });

    $('body').on('click',"#remove-discount",(function(){

        $.ajax({
            url:`{{ route('front.removwDiscount') }}`,
            type: 'POST',
            data: { country_id: $("#country").val()},
            dataType: 'json',
            success: function(response){
                if(response.status === true){
                    $("#shippingCharge").html('$'+response.shippingCharge);
                    $("#grandTotal").html('$'+response.grandTotal);
                    $("#discount").html('$'+response.discount);
                    $("#discount-response").html('');
                    $("#discount_code").val('');


                }
            }
        });
    }));




</script>

@endsection
