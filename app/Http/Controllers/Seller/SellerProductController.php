<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{
    public function index()
    {
        $authuserid = Auth::id();
        $stores = Store::where('user_id', $authuserid)->get();
        return view('seller.product.create', compact('stores'));
    }

    public function manage()
    {
        $currentSellerId = Auth::id();
        $products = Product::where('seller_id', $currentSellerId)->get();
        return view('seller.product.manage', compact('products'));
    }

    public function storeproduct(Request $request){
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'store_id' => 'required|exists:stores,id',
            'regular_price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug' => 'required|string|unique:products,slug',
        ]);

        $productData = [
            'product_name' => $request->product_name,
            'description' => $request->description,
            'sku' => $request->sku,
            'seller_id' => Auth::id(),
            'category_id' => $request->category_id,
            'store_id' => $request->store_id,
            'regular_price' => $request->regular_price,
            'discounted_price' => $request->discounted_price,
            'tax_rate' => $request->tax_rate,
            'stock_quantity' => $request->stock_quantity,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];

        if ($request->filled('subcategory_id')) {
            $productData['subcategory_id'] = $request->subcategory_id;
        }

        $product = Product::create($productData);

        if($request->hasFile('images')){
            foreach($request->file('images') as $file){
                $path = $file->store('products_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->back()->with('message', 'Product Created Successfully');
    }

    public function edit($id)
    {
        $currentSellerId = Auth::id();
        $product = Product::where('id', $id)
            ->where('seller_id', $currentSellerId)
            ->with('images')
            ->firstOrFail();

        $stores = Store::where('user_id', $currentSellerId)->get();
        $categories = Category::all();

        return view('seller.product.edit', compact('product', 'stores', 'categories'));
    }

    public function updateproduct(Request $request, $id)
    {
        $currentSellerId = Auth::id();
        $product = Product::where('id', $id)
            ->where('seller_id', $currentSellerId)
            ->firstOrFail();

        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
            'store_id' => 'required|exists:stores,id',
            'regular_price' => 'required|numeric|min:0',
            'discounted_price' => 'nullable|numeric|min:0',
            'tax_rate' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
        ]);

        $productData = [
            'product_name' => $request->product_name,
            'description' => $request->description,
            'sku' => $request->sku,
            'category_id' => $request->category_id,
            'store_id' => $request->store_id,
            'regular_price' => $request->regular_price,
            'discounted_price' => $request->discounted_price,
            'tax_rate' => $request->tax_rate,
            'stock_quantity' => $request->stock_quantity,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
        ];

        if ($request->filled('subcategory_id')) {
            $productData['subcategory_id'] = $request->subcategory_id;
        } else {
            $productData['subcategory_id'] = null;
        }

        $product->update($productData);

        // Handle new image uploads
        if($request->hasFile('images')){
            foreach($request->file('images') as $file){
                $path = $file->store('products_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        return redirect()->route('vendor.product.manage')->with('message', 'Product Updated Successfully');
    }

    public function destroy($id)
    {
        $currentSellerId = Auth::id();
        $product = Product::where('id', $id)
            ->where('seller_id', $currentSellerId)
            ->firstOrFail();

        // Delete associated product images
        ProductImage::where('product_id', $product->id)->delete();

        // Delete the product
        $product->delete();

        return redirect()->route('vendor.product.manage')->with('message', 'Product Deleted Successfully');
    }
}
