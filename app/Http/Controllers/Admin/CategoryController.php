<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryIndex(){
        $categories = Category::orderby('id', 'desc')->get();
        return view('Admin.category.categoryIndex', compact('categories'));
    }

    public function categoryCreate(Request $request){

        $request->validate([
            'name' => 'required|unique:categories,name|max:255',
            'description' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        Category::create($data);

        return redirect('admin/category');
    }

}
