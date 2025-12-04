<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class GlobalCartManager extends Component
{
    protected $listeners = ['addToCartFromAnywhere' => 'addToCart'];
    
    public function addToCart($data)
    {
        // Extract productId and quantity from the dispatched event data
        $productId = is_array($data) ? ($data['productId'] ?? null) : $data;
        $quantity = is_array($data) ? (int)($data['quantity'] ?? 1) : 1;

        if (!$productId) {
            $this->dispatch('notify', title: 'Invalid product', type: 'error');
            return;
        }

        $product = Product::find($productId);
        
        if (!$product) {
            $this->dispatch('notify', title: 'Product not found', type: 'error');
            return;
        }

        // Validate quantity
        if ($quantity < 1) {
            $this->dispatch('notify', title: 'Quantity must be at least 1', type: 'error');
            return;
        }

        // Check if product is in stock
        if ($product->stock_status === 'out of stock' || $product->stock_quantity <= 0) {
            $this->dispatch('notify', title: 'Product is out of stock', type: 'error');
            return;
        }

        $cart = session()->get('cart', []);

        // Calculate total quantity (existing + new)
        $existingQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $totalQuantity = $existingQuantity + $quantity;

        // Check if total quantity exceeds stock
        if ($totalQuantity > $product->stock_quantity) {
            $available = $product->stock_quantity - $existingQuantity;
            if ($available <= 0) {
                $this->dispatch('notify', title: 'Maximum quantity already in cart', type: 'error');
                return;
            }
            $this->dispatch('notify', title: "Only {$available} item(s) available in stock", type: 'error');
            return;
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $product->product_name,
                'price' => $product->discounted_price,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $this->dispatch('cartUpdated');
        $this->dispatch('notify', title: 'Added to Cart', type: 'success');        
    }

    public function render()
    {
        return view('livewire.global-cart-manager');
    }
}
