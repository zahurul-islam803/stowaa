<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubcategoryRequest;
use App\Models\category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SubCategoryController extends Controller
{
    function index()
    {
        $categories = category::all();
        $subcategories = Subcategory::all();
        return view('admin.subcategory.index', [
            'categories' => $categories,
            'subcategories' => $subcategories,
        ]);
    }
    function insert(SubcategoryRequest $request)
    {

        if (Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exists', 'Subcategory Name Already Exist In This Category!');
        } else {
            Subcategory::insert([
                'category_id' => $request->category_id,
                'subcategory_name' => $request->subcategory_name,
                'created_at' => Carbon::now(),
            ]);
            return back()->with('subcategory', 'SubCategory Added!');
        }
    }
    function edit($subcategory_id)
    {
        $subcategories = Subcategory::find($subcategory_id);
        $categories = category::all();
        return view('admin.subcategory.edit', [
            'subcategories' => $subcategories,
            'categories' => $categories,
        ]);
    }
    function delete($subcategory_id)
    {
        Subcategory::find($subcategory_id)->delete();
        return back()->with('delete', 'SubCategory Deleted!');
    }
    function update(SubcategoryRequest $request)
    {
        if (Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()) {
            return back()->with('exist', 'Subcategory Name Already Exist In This Category!');
        } else {
            Subcategory::where('id', $request->id)->where('category_id', $request->category_id)->update([
                'subcategory_name' => $request->subcategory_name,
                'updated_at' => Carbon::now(),
            ]);
            return back()->with('edit', 'SubCategory Edit Successfully!');
        }
    }
}
