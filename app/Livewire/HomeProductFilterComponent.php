<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class HomeProductFilterComponent extends Component
{
    public $selectedCategory = null;

    public $categories = [];

    public function mount()
    {
        $this->categories = Category::all();

        // If a category is provided via the query string (e.g. ?category=3),
        // validate and cast it before using it for database queries.
        // Ensure the category ID is positive (greater than 0) since database
        // category IDs typically start from 1.
        $category = request('category');
        if (is_numeric($category)) {
            $categoryId = (int) $category;
            $this->selectedCategory = $categoryId > 0 ? $categoryId : null;
        } else {
            $this->selectedCategory = null;
        }
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function render()
    {
        $products = Product::with('images')
            ->when($this->selectedCategory !== null, function ($query) {
                $query->where('category_id', $this->selectedCategory);
            })
            ->take(12)
            ->get();
        return view('livewire.home-product-filter-component', [
            'products' => $products,
        ]);
    }

}
