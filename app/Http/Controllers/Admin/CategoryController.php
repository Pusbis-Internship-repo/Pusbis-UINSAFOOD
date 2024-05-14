<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //Page data kategori admin
    public function data_kategori()
    {
        //Menampilkan semua kategori
        $categories = Category::all();
        return view('pointakses/admin/data_kategori/tampilkan_data', compact('categories'));
    }

    //Page create category admin
    function create_category()
    {
        return view('pointakses/admin/data_kategori/create');
    }

    //Function menyimpan menu ke database
    function store_category(Request $request)
    {
        // Membuat instance model category
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->save();

        //Redirect dengan pesan sukses
        return redirect()->route('datakategori')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    //Page edit category admin
    function edit_category(string $id): View
    {
        //Menampilkan kategori berdasarkan id
        $categories = Category::findOrFail($id);

        return view('pointakses/admin/data_kategori/edit', compact('categories'))->with(['success' => 'Data Berhasil Disimpan!']);
    }

    //Function untuk update kategori admin
    function category_update(Request $request, $id)
    {
        //Menampilkan kategori berdasarkan id
        $categories = Category::find($id);

        // Perbaikan disini
        $categories->category_name = $request->input('category_name');

        //Menyimpan update ke database
        $categories->save();

        return redirect()->route('datakategori')->with('Berhasil', 'Kategori berhasil diupdate.');
    }

    //Function untuk delete category admin
    public function category_delete($id)
    {
        //Menampilkan kategori berdasarkan id
        $category = Category::find($id);
        $category->delete();

        return redirect()->back();
    }
}