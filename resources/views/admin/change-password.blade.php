@extends('admin.layouts.app')
@section('title', 'Change password')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Change password</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            @include('admin.message')
            <div class="card-body">
                <form method="POST" action="" id="changePasswordForm" name="changePasswordForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="old_password">Old Password</label>
                                <input type="password" name="old_password" id="old_password" class="form-control" placeholder="old password">
                                <p class="invalid-feedback"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control"
                                    placeholder="new password">
                                <p class="invalid-feedback"></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" name="confirm_password" id="confirm password" class="form-control"
                                    placeholder="confirm_password">
                                <p class="invalid-feedback"></p>
                            </div>
                        </div>



                    <div class="pb-5 pt-3">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Change</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!-- /.card -->
</section>
@endsection
@section('js')
<script>
    $("#changePasswordForm").submit(function(e){
        e.preventDefault();
        let element = $(this);
        $("#submit").prop('disabled', false);

        $.ajax({
            url: `{{route('setting.processChangePassword')}}`,
            type: 'PUT',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response){
                $("#submit").prop('disabled', true);
                if(response.status == true){
                    window.location.href = "{{ route('setting.showChangePasswordForm') }}";

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
