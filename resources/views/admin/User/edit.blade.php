@extends('admin.layouts.app')
@section('title', 'Update User')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit User</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('user.index') }}" class="btn btn-primary">Back</a>
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
                <div class="card-body">
                    <form method="POST" action="" id="userForm" name="userForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value="{{ $users->name}}" type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input value="{{ $users->email}}" type="text" name="email" id="email" class="form-control"
                                        placeholder="email">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="password">
                                    <span>To change password you have to enter a value, otherwise leave blank.</span>
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone</label>
                                    <input value="{{ $users->phone}}" type="text" name="phone" id="phone" class="form-control"
                                        placeholder="phone">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{($users->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                        <option {{($users->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                    </select>
                                </div>
                            </div>

                        </div>


                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('user.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#userForm").submit(function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của form
            let element = $(this);
            
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: `{{ route('user.update', $users->id) }}`, // Đảm bảo route đúng
                type: 'PUT',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);

                    // console.log(response); // Kiểm tra phản hồi từ server

                    if (response["status"] === true) {
                        window.location.href = "{{ route('user.index') }}";

                        $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        $('#slug').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        // Hiển thị thông báo thành công
                        alert(response.message);
                        // Xóa giá trị trong form
                        element[0].reset();

                    } else {
                        var errors = response['errors'];
                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }

                        if (errors['email']) {
                            $('#email').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['email']);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                        }

                        if (errors['password']) {
                            $('#password').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['password']);
                        } else {
                            $('#password').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                        }

                        if (errors['phone']) {
                            $('#phone').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['phone']);
                        } else {
                            $('#phone').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                        }
                    }
                },

                error: function(jqXHR, exception) {
                    console.log("something went wrong");
                    // Hiển thị thông báo lỗi chi tiết
                    alert('Failed to create user. Please try again.');
                }
            });

        });

    </script>

@endsection
