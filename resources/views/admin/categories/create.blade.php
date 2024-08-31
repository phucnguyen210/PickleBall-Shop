@extends('admin.layouts.app')
@section('title', 'Create')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
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
                    <form method="POST" action="" id="categoryForm" name="categoryForm" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" readonly name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
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
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="showHome">Show on home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- div image --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image">Image</label>
                                <input type="hidden" value="" name="image_id" id="image_id">
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop file here or click to upload.<br>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                            <a href="{{ route('admin.categories') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#categoryForm").submit(function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của form
            let element = $(this);
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '{{ route('admin.category.store') }}', // Đảm bảo route đúng
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);

                    // console.log(response); // Kiểm tra phản hồi từ server

                    if (response["status"] === true) {
                        window.location.href = "{{ route('admin.categories') }}";

                        $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        $('#slug').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        // Hiển thị thông báo thành công
                        alert('Category created successfully!');
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
                    alert('Failed to create category. Please try again.');
                }
            });

        });

        $("#name").change(function() {
            let element = $(this);
            $("button[type=submit]").prop('disabled', true);


            $.ajax({

                url: '{{ route('getSlug') }}', 
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

        // tạo 1 khu vực để tải lên tệp tin cho phép người dùng kéo thả hoặc nhấp vào khu vực đó để upload file lên
        Dropzone.autoDiscover = false; // vô hiệu hóa việc tự động phát hiện dropzone để tránh các lỗi không kiểm soát được
        const dropzone = $("#image").dropzone({ // khởi tạo thủ công dropzone có id 'image'
            init: function() {
                this.on('addedfile', function(file) { // sự kiện này sẽ kích hoạt khi có 1 file upload vào
                    if (this.files.length > 1) { // nếu có nhiều hơn 1 tệp thì sẽ xóa tệp đầu tiên đi
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true, // thêm 1 liên kết cho người dùng xóa tệp tin đã thêm
            acceptedFiles: "image/jpeg, image/png, image/gif,, image/jpg", // các loại tệp tin được chấp nhận
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response
                .image_id); // lấy image_id từ phản hồi sau đó đặt giá trị này vào phần tử có id = 'image_id'
            },
            error: function(file, response) {
                console.log("Failed to upload file:", response); // Log thông báo lỗi
            }

        });
    </script>

@endsection
