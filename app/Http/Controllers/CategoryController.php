<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    function category()
    {
        $categories = category::all();
        return view('admin.category.index', [
            'categories' => $categories,
        ]);
    }
    function insert(CategoryRequest $request)
    {
        $category_id =  category::insertGetId([
            'category_name' => $request->category_name,
            'added_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);
        $category_image = $request->category_image;
        $extension = $category_image->getClientOriginalExtension();
        $new_category_name = $category_id . '.' . $extension;

        Image::make($category_image)->resize(266, 232)->save(public_path('uploads/category/') . $new_category_name);

        category::find($category_id)->update([
            'category_image' => $new_category_name,
        ]);
        return back()->with('success', 'Category Added!');
    }
    function delete($category_id)
    {
        category::find($category_id)->delete();
        return back()->with('delete', 'Category Deleted!');
    }
    function edit($category_id)
    {
        $edit_category = category::find($category_id);
        return view('admin.category.edit', [
            'edit_category' => $edit_category,
        ]);
    }
    function update(CategoryRequest $request)
    {
        category::where('id', $request->id)->update([
            'category_name' => $request->category_name,
            'updated_at' => Carbon::now(),
        ]);
        return back()->with('edit', 'Category Edit Successfully!');
    }
}
