<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('admin.sub_category.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validate_data = $request->validate([
            'subcategory_name' => 'required|string|max:100|min:4',
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create($validate_data);

        return redirect()->back()->with(['success' => true, 'message' => 'Sub Category Added Successfully']);
    }

    public function manage(){
        $subcategories = Subcategory::all();
        return view('admin.sub_category.manage', compact('subcategories'));
    }
}
