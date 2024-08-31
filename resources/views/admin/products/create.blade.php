@extends('admin.layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('product.index')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <!-- Default box -->
        <form action="" method="POST" name="productForm" id="productForm" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Title">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input type="text" readonly name="slug" id="slug"
                                                class="form-control" placeholder="Slug">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="short_description">Short Description</label>
                                            <textarea name="short_description" id="short_description" cols="30" rows="10" class="summernote"
                                                placeholder="short description"></textarea>
                                            <p class="error "></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                placeholder="Description"></textarea>
                                            <p class="error "></p>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="shipping_returns">Shipping & returns</label>
                                            <textarea name="shipping_returns" id="shipping_returns" cols="30" rows="10" class="summernote"
                                                placeholder="shipping returns"></textarea>
                                            <p class="error "></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div id="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="product-garllery">

                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price"
                                                class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at
                                                price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control"placeholder="sku">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control"
                                                placeholder="Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" value="No" name="track_qty" id="hidden_track_qty">
                                                <input class="custom-control-input" type="checkbox" value="Yes" id="track_qty" checked>
                                                <label for="track_qty" class="custom-control-label">Track Quantity</label>

                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                            <p class="error"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>

                                        @if ($categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option  value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                            <p class="error"></p>

                                        @endif

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">Select a Sub Category</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control">
                                        <option value="">Select a brand</option>
                                        @if ($brands->isNotEmpty())
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Related Product</h2>
                                <div class="mb-3">
                                    <select multiple class="related-product w-100" name="related_products[]" id="related_products">

                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('product.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </div>
        </form>
        <!-- /.card -->
    </section>
@endsection
@section('js')
    <script>
        $('.related-product').select2({
            ajax: {
                url: `{{ route('product.getProduct') }}`,
                dataType: 'json',
                tags: true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function (data) {
                    return {
                        results: data.tags // ánh xạ các trường dữ liệu vào id và text trong select2,
                        // sau khi submit thì select2 chỉ gửi mảng id các sản phẩm đã chọn sang controller
                    }
                }
            }
        });


        $("#title").change(function() {
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

        $("#productForm").submit(function(event){
            event.preventDefault();
            let element = $(this);
            $("button[type=submit]").prop('disabled', true); // tránh việc người dùng bấm liên tục vào nút submit khi yêu cầu đang được xử lý
            // Update the hidden input value based on the checkbox state
            if ($('#track_qty').is(':checked'))
            {
                $('#hidden_track_qty').val('Yes');
            } else
            {
                $('#hidden_track_qty').val('No');
            }

            $.ajax({

                url: `{{ route("product.store") }}`,
                type: 'POST',
                data: element.serializeArray(),
                dataType: 'json',
                success: function(response){
                    $("button[type=submit]").prop('disabled', false); // sau khi dữ liếu sử lý xong thì mở lại chức năng submit
                    if(response['status'] === true){
                        alert(response.message);
                        window.location.href="{{ route('product.index')}}";

                    }else{
                        let errors = response['errors'];

                        $(".error").removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number']").removeClass('is-invalid');
                        $.each(errors, function(key,value){
                            $(`#${key}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(value);
                        });
                    }
                },


                error: function(){
                    console.log("Some thing went wrong");
                }
            });
        });


        $("#category").change(function(){
            let category_id = $(this).val();
            $.ajax({
                url: '{{ route("product-subcategories") }}',
                type: 'GET',
                data: {category_id:category_id},//element.serializeArray(),
                dataType: 'json',
                success: function(response){
                    $("#sub_category").find("option").not(":first").remove();    //Sử dụng jQuery để chọn phần tử HTML có ID là sub_category sau đó tìm các phần tử option bên trong, lọc ra các phần tử ngoại trừ phần tử đầu tiên và xóa chúng

                    $.each(response["subCategories"], function(key, item){    // Duyệt qua mảng subCategories trả về từ phản hồi AJAX,  chọn
                        $("#sub_category").append(`<option value= "${item.id}"> ${item.name} </option>`) //  chọn sub_category, tạo một phần tử <option> mới và thêm vào bên trong phần tử sub_category
                    });

                },
                error: function(){
                    console.log("Some thing went wrong");
                }
            });
        });


        // tạo 1 khu vực để tải lên tệp tin cho phép người dùng kéo thả hoặc nhấp vào khu vực đó để upload file lên
        Dropzone.autoDiscover = false; // vô hiệu hóa việc tự động phát hiện dropzone để tránh các lỗi không kiểm soát được
        const dropzone = $("#image").dropzone({ // khởi tạo thủ công dropzone có id 'image'
            init: function() {
                this.on('addedfile', function(file) { // sự kiện này sẽ kích hoạt khi có 1 file upload vào
                    if (this.files.length > 4) { // nếu có nhiều hơn 1 tệp thì sẽ xóa tệp đầu tiên đi
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: `{{ route('temp-images.create') }}`,
            maxFiles: 4,
            paramName: 'image',
            addRemoveLinks: true, // thêm 1 liên kết cho người dùng xóa tệp tin đã thêm
            acceptedFiles: "image/jpeg, image/png, image/gif", // các loại tệp tin được chấp nhận
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                let html = `
                    <div class="col-md-3">
                        <div class="card" id="image-row-${response.image_id}">
                            <input type="hidden" name="image_array[]" value="${response.image_id}">
                            <img class="card-img-top" src="${response.imagePath}" alt="Card image cap">
                            <div class="card-body">
                                <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger">Delete</a>
                            </div>
                        </div>
                    </div>`;
                $("#product-garllery").append(html);
                this.removeFile(file);
            },

            error: function(file, response) {
                console.log("Failed to upload file:", response); // Log thông báo lỗi
            }

        });

        function deleteImage(id){
            $("#image-row-"+id).closest('.col-md-3').remove();
        }
    </script>

@endsection
