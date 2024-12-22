@extends('front-end.layouts.app')
@section('title', 'Login')
@section('contents')


<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home')}}">Home</a></li>
                    <li class="breadcrumb-item">reset Password</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-10">
        <div class="container">
            @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success')}}
                </div>

            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error')}}
                </div>

            @endif
            <div class="login-form">
                <form action="{{ route('front.processResetPassword')}}" method="post" name="formForgotPassword" id="formForgotPassword">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token}}">
                    <h4 class="modal-title">Login to Your Account</h4>
                    <div class="form-group">
                        <input type="password" id="new_password" name="new_password" class="form-control @error('password') is-invalid @enderror" placeholder="new password" value="{{ old('password')}}" required="required">
                        @error('new_password')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="confirm_password" value="{{ old('confirm_password')}}" required="required">
                        @error('confirm_password')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                    </div>
                    <input type="submit" class="btn btn-outline-success" value="Submit">
                </form>
                <div class="text-center small"> <a class="text-primary" href="{{ route('account.login')}}">Login</a></div>
            </div>
        </div>
    </section>
</main>
@endsection

