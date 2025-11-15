@extends('admin.layouts.layout')
@section('admin_page_title')
Create Sub Category
@endsection
@section('admin_layout')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create Sub Category</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
    <div class="alert alert-warning alert-dismissible fade show">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    @if (session('success'))

    @endif
                    <form action="{{ route('store.subcategory') }}" method="POST">
                        @csrf
                        <label for="subcategory_name" class="fw-bold mb-2">Give Name of Your Subcategory</label>
                        <input type="text" class="form-control mb-3" name="subcategory_name" id="subcategory_name" placeholder="Tote Bag">

                        <label for="category_id" class="fw-bold mb-2">Select Category</label>
                        <select name="category_id" class="form-control mb-3" id="category_id">
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>

                        <button type="submit" class="btn btn-primary w-100 mt-2">Add Sub Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection