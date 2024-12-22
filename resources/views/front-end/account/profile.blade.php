@extends('front-end.layouts.app')
@section('title', 'Profile')
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                   @include('front-end.account.common.sidebar')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                        </div>
                        <div class="card-body p-4">
                            <form action="" name="profileForm" id="profileForm" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{ $user->name}}" placeholder="Enter Your Name" class="form-control">
                                        <p class="invalid-feedback"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="text" name="email" id="email" value="{{ $user->email}}" readonly placeholder="Enter Your Email" class="form-control">
                                        <p class="invalid-feedback"></p>

                                    </div>
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" name="phone" id="phone" value="{{ $user->phone}}" placeholder="Enter Your Phone" class="form-control">
                                        <p class="invalid-feedback"></p>

                                    </div>

                                    <div class="d-flex">
                                        <button class="btn btn-dark">Update</button>
                                    </div>
                                </div>
                            </form>
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
    $("#profileForm").submit(function(e){
        e.preventDefault();

        let element =  $(this);
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: `{{ route('account.updateProfile') }}`,
            type: 'PUT',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                if(response.status == false){
                    console.log(response);

                    let errors = response['errors'];
                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }

                        if (errors['email']) {
                            $('#email').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['email']);
                        } else {

                            $('#email').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }
                        if (errors['phone']) {
                            $('#phone').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['phone']);
                        } else {

                            $('#phone').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }
                }else{
                    alert(response.message);
                    location.reload();
                }
            }
        });
    });
</script>
@endsection
