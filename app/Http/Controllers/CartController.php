<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->productId;
        $quantity = (int)$request->quantity;

        $product = Product::find($productId);
        
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Validate quantity
        if ($quantity < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity must be at least 1'
            ], 400);
        }

        // Check if product is in stock
        if ($product->stock_status === 'out of stock' || $product->stock_quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock'
            ], 400);
        }

        $cart = session()->get('cart', []);

        // Calculate total quantity (existing + new)
        $existingQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $totalQuantity = $existingQuantity + $quantity;

        // Check if total quantity exceeds stock
        if ($totalQuantity > $product->stock_quantity) {
            $available = $product->stock_quantity - $existingQuantity;
            if ($available <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum quantity already in cart'
                ], 400);
            }
            return response()->json([
                'success' => false,
                'message' => "Only {$available} item(s) available in stock"
            ], 400);
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

        return response()->json([
            'success' => true,
            'message' => 'Added to Cart',
            'cart' => $cart
        ]);
    }
    
    public function getCart()
    {
        $cart = session()->get('cart', []);
        $totalPrice = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        
        return response()->json([
            'cart' => $cart,
            'totalPrice' => $totalPrice
        ]);
    }
    
    public function increaseQuantity(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $productId = $request->productId;
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }

        $product = Product::find($productId);
        
        // Check stock availability
        if ($cart[$productId]['quantity'] + 1 > $product->stock_quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Maximum stock quantity reached'
            ], 400);
        }

        $cart[$productId]['quantity'] += 1;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Quantity increased',
            'cart' => $cart
        ]);
    }
    
    public function decreaseQuantity(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $productId = $request->productId;
        $cart = session()->get('cart', []);

        if (!isset($cart[$productId])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart'
            ], 404);
        }

        if ($cart[$productId]['quantity'] > 1) {
            $cart[$productId]['quantity'] -= 1;
            session()->put('cart', $cart);
            
            return response()->json([
                'success' => true,
                'message' => 'Quantity decreased',
                'cart' => $cart
            ]);
        } else {
            // Remove item if quantity would be 0
            return $this->removeItem($request);
        }
    }
    
    public function removeItem(Request $request)
    {
        $request->validate([
            'productId' => 'required|exists:products,id',
        ]);

        $productId = $request->productId;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart' => $cart
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }
}

