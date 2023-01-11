<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    public function categoryIndex()
    {
        $categories = Category::orderby('id', 'desc')->get();
        return view('Admin.category.categoryIndex', compact('categories'));
    }

    public function categoryCreate(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            'description' => 'required'
        ]);

        $category = new Category;

        $category->name = $request->name;
        $category->description = $request->description;

        $category->status = $request->status == true ? '1' : '0';
        $category->created_by = Auth::guard('admin')->user()->id;

        $category->save();

        $notify = [
            'message' => 'Category Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notify);
    }

    public function categoryUpdate(Request $request, $category_id)
    {
        $category = Category::find($category_id);

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id . '|max:255',
            'description' => 'required',
        ]);

        $category->name = $request->name;
        $category->description = $request->description;
        $category->status = $request->status == true ? '1' : '0';
        $category->updated_by = Auth::guard('admin')->user()->id;

        $category->update();

        $notify = [
            'message' => 'Category Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notify);
    }

    public function categoryDelete(Request $request, $category_id)
    {
        $category = Category::find($category_id);

        $category->delete();

        $notify = [
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notify);
    }
}
