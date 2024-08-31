@extends('admin.layouts.app')
@section('title', 'Edit Sub Category')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Sub Category</h1>
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
                    <form method="POST" action="" id="subCategoryForm" name="subCategoryForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">



                                    <label for="name">Category</label>

                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a category</option>
                                        @foreach ($category as $key => $item)
                                            <option {{ $sub_category->category_id == $item->id ? 'selected' : '' }}
                                                value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="invalid-feedback"></p>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $sub_category->name }}" placeholder="Name">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" readonly id="slug"
                                        value="{{ $sub_category->slug }}" class="form-control" placeholder="Slug">
                                    <p class="invalid-feedback"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" {{ $sub_category->status == 1 ? 'seleted' : '' }}>Active
                                        </option>
                                        <option value="0" {{ $sub_category->status == 0 ? 'seleted' : '' }}>Block
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="showHome">Show on home</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option {{ $sub_category->showHome == 'Yes' ? 'selected' : '' }} value="Yes">Yes</option>
                                        <option {{ $sub_category->showHome == 'No' ? 'selected' : '' }}  value="No">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- div image --}}


                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('sub_category.show') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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
        $("#subCategoryForm").submit(function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của form
            let element = $(this);
            $("button[type=submit]").prop('disabled', true);

            $.ajax({
                url: '{{ route('sub_category.update', $sub_category->id) }}', // Đảm bảo route đúng
                type: 'PUT',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response) {
                    $("button[type=submit]").prop('disabled', false);

                    // console.log(response); // Kiểm tra phản hồi từ server

                    if (response["status"] === true) {
                        window.location.href = "{{ route('sub_category.show') }}";

                        $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        $('#slug').removeClass('is-invalid').siblings('p.invalid-feedback')
                            .html("");

                        // Hiển thị thông báo thành công
                        alert('Category created successfully!');
                        // Xóa giá trị trong form
                        element[0].reset();

                    } else {

                        if (response.notFound === true) {
                            window.location.href = "{{ route('sub_category.show') }}";
                            return false;

                        }
                        var errors = response['errors'];
                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }

                        if (errors['slug']) {
                            $('#slug').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['slug']);

                        } else {

                            $('#slug').removeClass('is-invalid').siblings('p.invalid-feedback')
                                .html("");
                        }

                        if (errors['category']) {
                            $('#category').addClass('is-invalid').siblings('p.invalid-feedback')
                                .html(errors['category']);

                        } else {

                            $('#category').removeClass('is-invalid').siblings('p.invalid-feedback')
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
    </script>

@endsection
