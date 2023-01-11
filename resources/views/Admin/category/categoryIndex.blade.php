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
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->description }}</td>
                                <td>{{ $category->status == '0' ? 'Hidden' : 'Visible' }}</td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-sm btn-primary mr-2" data-toggle="modal"
                                            data-target="{{ '#edit' . $category->id . 'CategoryModal' }}"><i
                                                class="fa-regular fa-pen-to-square"></i></button>

                                        <form action="{{ url('admin/category/delete/' . $category->id) }}" method="post">
                                            @csrf
                                            <button href="{{ url('admin/category/delete/' . $category->id) }}"
                                                class="delete btn btn-sm btn-danger delete_product"
                                                data-id="{{ $category->id }}"><i class="fa-regular fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Category Edit Modal-->
                            <div class="modal fade" id="{{ 'edit' . $category->id . 'CategoryModal' }}" tabindex="-1"
                                role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ url('admin/category/update/' . $category->id) }}" method="post">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCategoryModalLabel">{{ $category->name }}
                                                </h5>
                                                <button class="close" type="button" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Category Name</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        name="name" value="{{ $category->name }}">
                                                    @error('name')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ $category->description }}</textarea>
                                                    @error('description')
                                                        <span class="invalid-feedback">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="" class="mb-1">Status
                                                        @error('status')
                                                            <strong class="text-danger">{{ $message }}</strong>
                                                        @enderror
                                                    </label>
                                                    <input type="checkbox" name="status"
                                                        {{ $category->status == '1' ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</a>
                                                <button class="btn btn-primary" type="submit">Update category</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Category Edit Modal-->
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
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="" class="mb-1">Status
                                @error('status')
                                    <strong class="text-danger">{{ $message }}</strong>
                                @enderror
                            </label>
                            <input type="checkbox" name="status">
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
