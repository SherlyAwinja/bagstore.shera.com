<div>
    <label for="category_id" class="fw-bold mb-2">Select Category For Your Product</label>
    <select class="form-control mb-2" name="category_id" wire:model="selectedCategory">
        <option value="">Select a Category</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
        @endforeach
    </select>

    <label for="subcategory_id" class="fw-bold mb-2">Select Subcategory For Your Product</label>
    <select class="form-control mb-2" name="subcategory_id">
        <option value="">Select A Subcategory</option>
        @foreach ($subcategories as $subcategory)
            <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
        @endforeach
    </select>
</div>
