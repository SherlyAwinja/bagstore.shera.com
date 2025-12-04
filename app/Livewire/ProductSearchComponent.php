<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductSearchComponent extends Component
{
    public string $query = '';
    public array $results = [];

    public function updatedQuery()
    {
        $term = trim($this->query);

        // If the search box is cleared (or only whitespace), clear results
        // instead of returning all products.
        if ($term === '') {
            $this->results = [];
            return;
        }

        // Example search logic, adjust to your column names
        $this->results = Product::where('product_name', 'like', '%'.$term.'%')
            ->limit(10)
            ->get()
            ->toArray();
    }

    public function render()
    {
        return view('livewire.product-search-component', [
            'results' => $this->results,
        ]);
    }
}