@extends('Admin.layouts.app')

@section('title', 'Category')

@php
    $page = 'Categories';
@endphp

@section('mainpart')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3>All Categories</h3>
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addCategoryModal">Add Category</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover text-center" id="dataTable" width="100%"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary"><i
                                            class="fa-regular fa-pen-to-square"></i></button>
                                    <button class="btn btn-sm btn-danger deleteCategoryBtn" type="submit"
                                        value="{{ $category->id }}"><i class="fa-regular fa-trash-can"></i></button>
                                </td>
                            </tr>
                        @empty
                            <h4>No Data Found!</h4>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Category Add Modal-->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ url('admin/category/add') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" name="description" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</a>
                        <button class="btn btn-primary" type="submit">Add category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Category Add Modal-->
    <!-- deleteModal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ url('admin/category/delete') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Delete Category with its posts</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="category_delete_id" id="category_id">
                        <h5>Are you sure you want to delete category with its post?</h5>
                    </div>
                    <div class="modal-footer">
                        <a class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</a>

                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- deleteModal -->
@endsection

@section('scripts')
    {{-- deleteCategoryBtn --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deleteCategoryBtn', function(e) {
                e.preventDefault();
                var category_id = $(this).val();
                $('#category_id').val(category_id);
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection
