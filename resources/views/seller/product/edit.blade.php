@extends('seller.layouts.layout')
@section('seller_page_title')
Edit Product
@endsection
@section('seller_layout')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Product</h5>
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

@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
                <form action="{{ route('vendor.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label for="product_name" class="fw-bold mb-2">Give Name of Your Product</label>
                    <input type="text" class="form-control mb-2" name="product_name" value="{{ old('product_name', $product->product_name) }}" placeholder="Classic Tote Bag">

                    <label for="description" class="fw-bold mb-2">Description</label>
                    <textarea name="description" class="form-control mb-2" id="description" cols="30" rows="10">{{ old('description', $product->description) }}</textarea>

                    <label for="images" class="fw-bold mb-2">Upload Additional Product Images</label>
                    <input type="file" class="form-control mb-2" name="images[]" multiple>
                    
                    @if($product->images->count() > 0)
                    <div class="mb-2">
                        <label class="fw-bold mb-2">Current Images:</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($product->images as $image)
                            <div class="position-relative" style="width: 100px; height: 100px;">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <label for="sku" class="fw-bold mb-2">SKU</label>
                    <input type="text" class="form-control mb-2" name="sku" value="{{ old('sku', $product->sku) }}" placeholder="1234567890">
                    
                    <label for="category_id" class="fw-bold mb-2">Category</label>
                    <select name="category_id" class="form-control mb-2" id="category_id" onchange="loadSubcategories(this.value)">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>

                    <label for="subcategory_id" class="fw-bold mb-2">Subcategory</label>
                    <select name="subcategory_id" class="form-control mb-2" id="subcategory_id">
                        <option value="">Select Subcategory</option>
                        @if($product->category)
                            @foreach($product->category->subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $product->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->subcategory_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>

                    <label for="store_id" class="fw-bold mb-2">Select Store For This Product</label>
                    <select name="store_id" class="form-control mb-2" id="store_id">
                        @foreach ($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>{{ $store->store_name }}</option>
                        @endforeach
                    </select>

                    <label for="regular_price" class="fw-bold mb-2">Regular Price</label>
                    <input type="number" class="form-control mb-2" name="regular_price" value="{{ old('regular_price', $product->regular_price) }}">

                    <label for="discounted_price" class="fw-bold mb-2">Discounted Price</label>
                    <input type="number" class="form-control mb-2" name="discounted_price" value="{{ old('discounted_price', $product->discounted_price) }}">

                    <label for="tax_rate" class="fw-bold mb-2">Tax Rate</label>
                    <input type="number" class="form-control mb-2" name="tax_rate" value="{{ old('tax_rate', $product->tax_rate) }}">

                    <label for="stock_quantity" class="fw-bold mb-2">Stock Quantity</label>
                    <input type="number" class="form-control mb-2" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}">

                    <label for="slug" class="fw-bold mb-2">Slug</label>
                    <input type="text" class="form-control mb-2" name="slug" value="{{ old('slug', $product->slug) }}">

                    <label for="meta_title" class="fw-bold mb-2">Meta Title</label>
                    <input type="text" class="form-control mb-2" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}">

                    <label for="meta_description" class="fw-bold mb-2">Meta Description</label>
                    <input type="text" class="form-control mb-2" name="meta_description" value="{{ old('meta_description', $product->meta_description) }}">

                    <button type="submit" class="btn btn-primary w-100 mt-2">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function loadSubcategories(categoryId) {
    const subcategorySelect = document.getElementById('subcategory_id');
    const currentSubcategoryId = {{ $product->subcategory_id ?? 'null' }};
    
    subcategorySelect.innerHTML = '<option value="">Loading...</option>';
    
    if (!categoryId) {
        subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
        return;
    }
    
    fetch(`{{ url('/api/subcategories') }}/${categoryId}`)
        .then(response => response.json())
        .then(data => {
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            data.forEach(subcategory => {
                const option = document.createElement('option');
                option.value = subcategory.id;
                option.textContent = subcategory.subcategory_name;
                if (currentSubcategoryId && subcategory.id == currentSubcategoryId) {
                    option.selected = true;
                }
                subcategorySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            subcategorySelect.innerHTML = '<option value="">Error loading subcategories</option>';
        });
}
</script>
    
@endsection

