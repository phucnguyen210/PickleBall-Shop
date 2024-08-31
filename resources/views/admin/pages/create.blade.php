@extends('admin.layouts.app')
@section('title', 'Create')
@section('content')
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Page</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="pages.html" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="" method="POST" name="pageForm" id="pageForm" enctype="multipart/form-data">
            <div class="card">
                <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" class="summernote" cols="30" rows="10"></textarea>
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
                        </div>

                </div>
            </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{ route('page.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
    <!-- /.card -->
</section>
@endsection

@section('js')

<script>
    $("#name").change(function() {
        let element = $(this);
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route('getSlug') }}', // Đảm bảo route đúng
            type: 'GET',
            data: {
                title: element.val()
            },
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] === true) {
                    $("#slug").val(response["slug"]);
                }
            }
        });
    });

    $("#pageForm").submit(function(event) {
        event.preventDefault(); // Ngăn chặn hành vi mặc định của form
        let element = $(this);
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: `{{ route("page.store") }}`, // Đảm bảo route đúng
            type: 'POST',
            data: element.serializeArray(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);


                if (response["status"] === true) {
                    window.location.href = "{{ route('page.index') }}";

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
                        $('#name').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['name']);
                    } else {
                        $('#name').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
                    }

                    if (errors['slug']) {
                        $('#slug').addClass('is-invalid').siblings('p.invalid-feedback').html(errors['slug']);
                    } else {
                        $('#slug').removeClass('is-invalid').siblings('p.invalid-feedback').html("");
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
