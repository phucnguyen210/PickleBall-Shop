@extends('front-end.layouts.app')
@section('title', 'Change password')
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">

                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Change password</a></li>
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
                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                        </div>
                        <div class="card-body p-4">
                            <form action="" method="POST" name="changePasswordForm" id="changePasswordForm">
                            @csrf
                                <div class="row">
                                    <div class="mb-3">
                                        <label for="old_password">Old Password</label>
                                        <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                        <p class="invalid-feedback"></p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="new_password">New Password</label>
                                        <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control">
                                        <p class="invalid-feedback"></p>

                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password">Confirm Password</label>
                                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Old Password" class="form-control">
                                        <p class="invalid-feedback"></p>

                                    </div>
                                    <div class="d-flex">
                                        <button type="submit" name="submit" id="submit" class="btn btn-dark">Save</button>
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
    $("#changePasswordForm").submit(function(e){
        e.preventDefault();
        let element = $(this);
        $("#submit").prop('disabled', false);

        $.ajax({
            url: `{{route('account.processChangePassword')}}`,
            type: 'PUT',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("#submit").prop('disabled', true);
                if(response.status == true){
                    window.location.href = "{{ route('account.showChangePassword') }}";

                    $('#old_password').removeClass('is-invalid').siblings('p.invalid-feedback')
                        .html("");

                    $('#new_password').removeClass('is-invalid').siblings('p.invalid-feedback')
                        .html("");
                    $('#confirm_password').removeClass('is-invalid').siblings('p.invalid-feedback')
                        .html("");

                    // Hiển thị thông báo thành công

                    // Xóa giá trị trong form
                    element[0].reset();

                }else{
                    var errors = response['errors'];
                        if (errors['old_password']) {
                            $('#old_password').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['old_password']);
                        } else {
                            $('#old_password').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }

                        if (errors['new_password']) {
                            $('#new_password').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['new_password']);
                        } else {
                            $('#new_password').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                        }

                        if (errors['confirm_password']) {
                            $('#confirm_password').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['confirm_password']);
                        } else {
                            $('#confirm_password').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                        }
                }

            }
        });
    });
</script>
@endsection
