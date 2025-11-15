<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MasterCategoryController extends Controller
{
    public function storecat(Request $request): RedirectResponse
    {
        $validate_data = $request->validate(rules:[
            'category_name' => 'unique:categories|max:100|min:4',
        ]);

        Category::create($validate_data);

        return redirect()->back()->with('message', 'Category Added Successfully');
    }

    public function showcategory($id){
        $category_info = Category::find($id);
        return view('admin.category.edit', compact('category_info'));
    }

    public function updatecategory(Request $request, $id){
        $category = Category::findOrfail($id);
        $validate_data = $request->validate(rules:[
            'category_name' => 'required|string|max:100|min:4',
        ]);

        $category->update($validate_data);

        return redirect()->back()->with('message','Category Updated Successflully');
    }

    public function deletecategory($id){
        Category::findOrfail($id)->delete();

        return redirect()->back()->with('message','Category Deleted Successflully');
    }
}
