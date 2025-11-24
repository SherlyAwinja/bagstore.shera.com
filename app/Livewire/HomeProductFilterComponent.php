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
    }

    public function filterByCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
    }

    public function render()
    {
        $products = Product::with('images')->when($this->selectedCategory, function($query) {
            $query->where('category_id', $this->selectedCategory);
        })->take(12)->get();
        return view('livewire.home-product-filter-component', [
            'products' => $products,
        ]);
    }

}
