@extends('admin.layouts.app')
@section('title', ' Sub Category')
@section('content')
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sub Categories</h1>

                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('sub_category.create') }}" class="btn btn-primary">New Sub Category</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="card">
                @include('admin.message')
                <div class="card-header">
                    <div class="card-title">
                        <button onclick="window.location.href='{{ route('sub_category.show') }}' "
                            class="btn btn-default btn-sm">Back</button>
                    </div>
                    <div class="card-tools">
                        <form action="{{ route('sub_category.show') }}" method="GET">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ request('keyword') }}" name="keyword"
                                    class="form-control float-right" placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Category</th>
                                <th width="100">Status</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sub_category as $item => $row)
                                <tr>
                                    <td>{{ $item + 1 }}</td>
                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->slug }}</td>
                                    <td>{{ $row->categoryName }} </td>


                                    <td>
                                        @if ($row->status == 1)
                                            <svg class="text-success-500 h-6 w-6 text-success"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="{{ route('sub_category.edit', $row->id) }}">
                                            <svg class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path
                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                </path>
                                            </svg>
                                        </a>


                                        <a href="" data-id="{{ $row->id }}"
                                            class="text-danger w-4 h-4 mr-1 delete-category">
                                            <svg wire:loading.remove.delay="" wire:target=""
                                                class="filament-link-icon w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path ath fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </a>


                                    </td>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">

                    <div class="float-right">
                        {{ $sub_category->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </section>

@endsection
@section('js')

    <script>
        $(document).ready(function() {
            $('.delete-category').on('click', function(e) {
                e.preventDefault(); // ngăn hành vi mặc định của form
                let categoryId = $(this).data('id'); // lấy giá trị của thuộc tính data-id
                let url = '{{ route('sub_category.destroy', ':id') }}';
                url = url.replace(':id', categoryId);

                if (confirm('Are you sure you want to delete this sub category?')) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                alert('Sub Category deleted successfully!');
                                location.reload();
                            } else {
                                if (response.notFound === true) {

                                    location.reload();
                                    return false;

                                }
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log('Error:', textStatus, errorThrown);
                            alert('Failed to delete sub category.');
                            location.reload();

                        }
                    });
                }
            });
        });
    </script>

@endsection
