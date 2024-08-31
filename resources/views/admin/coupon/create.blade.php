@extends('admin.layouts.app')
@section('title', 'Create')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Coupons</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('admin.categories') }}" class="btn btn-primary">Back</a>
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
                    <form method="POST" action="" id="discountForm" name="discountForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Code</label>
                                    <input type="text" name="code" id="code" class="form-control"
                                        placeholder="Coupon Code">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Coupon code Name">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name">Max Uses</label>
                                    <input type="number" name="max_uses" id="max_uses" class="form-control" placeholder="Max Uses">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="name">Max uses user</label>
                                    <input type="number" name="max_uses_user" id="max_uses_user" class="form-control" placeholder="Max uses user">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="type">Type</label>
                                    <select name="type" id="type" class="form-control">
                                        <option value="percent">Percent</option>
                                        <option value="fixed">Fixed</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="discount_amount">Discount amount</label>
                                    <input type="number" name="discount_amount" id="discount_amount" class="form-control" placeholder="Discount amount">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="discount_amount">Min amount</label>
                                    <input type="number" name="min_amount" id="min_amount" class="form-control" placeholder="Min amount">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_at">Start at</label>
                                    <input autocomplete="off" type="text" name="start_at" id="start_at" class="form-control" placeholder="Start at">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expires_at">Expires at</label>
                                    <input autocomplete="off" type="expires_at" name="expires_at" id="expires_at" class="form-control" placeholder="Expires at">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Description</label>
                                    <textarea type="text" name="description" id="description" class="form-control" placeholder="Coupon code description"></textarea>
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                        </div>


                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('coupons.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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

        $(document).ready(function(){
            $('#start_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });

            $('#expires_at').datetimepicker({
                // options here
                format:'Y-m-d H:i:s',
            });
        });


        $("#discountForm").submit(function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của form
            let element = $(this);
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: `{{ route('coupons.store') }}`, // Đảm bảo route đúng
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);

                    // console.log(response); // Kiểm tra phản hồi từ server

                    if (response["status"] === true) {
                        window.location.href = "{{ route('coupons.index') }}";

                        $('#code').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        $('#discount_amount').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        // Hiển thị thông báo thành công
                        alert('Discount coupons created successfully!');
                        // Xóa giá trị trong form
                        element[0].reset();

                    } else {
                        var errors = response['errors'];
                        if (errors['code']) {
                            $('#code').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['code']);
                        } else {
                            $('#code').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }
                        if (errors['discount_amount']) {
                            $('#discount_amount').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['discount_amount']);
                        } else {
                            $('#discount_amount').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }
                        if (errors['start_at']) {
                            $('#start_at').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['start_at']);
                        } else {
                            $('#start_at').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }
                        if (errors['expires_at']) {
                            $('#expires_at').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['expires_at']);
                        } else {
                            $('#expires_at').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }

                    }
                },

                error: function(jqXHR, exception) {
                    console.log("something went wrong");
                    // Hiển thị thông báo lỗi chi tiết
                    alert('Failed to create category. Please try again.');
                }
            });

        });

    </script>

@endsection
