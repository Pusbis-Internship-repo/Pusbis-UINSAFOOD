<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Menu;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MenuController extends Controller
{
    //Menampilkan daftar menu dengan search
    function data_menu(Request $request)
    {
        //Cari menu berdasarkan nama saat menggunakan search
        if ($request->has('search')) {
            $menus = Menu::where('menu_name', 'LIKE', '%' . $request->search . '%')->get();
        } else {
            $menus = Menu::all();
        }
        return view('pointakses/admin/data_menu/tampilkan_menu', compact('menus'));
    }

    //Menampilkan page create menu admin
    function create_menu()
    {
        //Mengambil semua kategori dan user dengan role seller
        $categories = Category::all();
        $users = User::where('role', 'seller')->get();

        return view('pointakses/admin/data_menu/create', compact('categories', 'users'));
    }

    //Function untuk menyimpan menu ke database
    function store_menu(Request $request): RedirectResponse
    {
        //Validasi input
        $this->validate($request, [
            'menu_pic' => 'required|image|mimes:jpeg,jpg,png',
            'min_order' => 'required|in:H-1,H-2,H-3',
            'menu_name' => 'required',
            'menu_price' => 'required',
            'category' => 'required',
            'vendor' => 'required',
            'menu_desc' => 'required',
        ]);
        
        //Mendapatkan seller berdasarkan id
        $vendor = User::find($request->input('vendor'));

        //Menyimpan instance model baru
        $menu = new Menu();
        $menu->menu_name = $request->input('menu_name');
        $menu->menu_price = $request->input('menu_price');
        $menu->category_id = $request->input('category');
        $menu->users_id = $request->input('vendor');
        $menu->seller = $vendor->nama_lengkap;
        $menu->menu_desc = $request->input('menu_desc');
        $menu->min_order_time = $request->input('min_order');

        //Ambil ID makanan yang baru saja disimpan
        $menuId = $menu->id;

        //Jika terdapat file gambar yang diupload
        if ($request->hasFile('menu_pic')) {
            $image = $request->file('menu_pic');
            // Ubah nama file gambar menjadi ID makanan
            $imageName = $menuId . '.' . $image->getClientOriginalExtension();
            // dd($imageName, $menu);

            //Resize ukuran gambar menu
            $resizedImage = Image::make($image)->fit(600, 520)->encode();
            //Tentukan path penyimpanan baru
            // $imagePath = 'public/menu_images/' . $imageName;
            $path = $request->file('menu_pic')->store('menu_images', 'public');
            // dd($path);
            //Simpan gambar yang telah diresize ke dalam penyimpanan
            // Storage::put($imagePath, $resizedImage);

            // Update path gambar pada model Menu
            $menu->menu_pic = $path;

            //Menyimpan menu ke database
            $menu->save();
        }

        return redirect()->route('datamenu')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    //Page edit menu admin
    function edit_menu(string $id): View
    {
        //Menampilkan semua menu dari database
        $menus = Menu::findOrFail($id);

        return view('pointakses/admin/data_menu/edit', compact('menus'));
    }

    //Function untuk update menu admin
    function menu_update(Request $request, $id)
    {
        //Mengambil menu berdasarkan id
        $menus = Menu::find($id);
        $menus->menu_name = $request->input('menu_name');
        $menus->menu_price = $request->input('menu_price');
        $menus->category_id = $request->input('category');
        $menus->menu_desc = $request->input('menu_desc');
        $menus->save();

        // Ambil ID makanan yang baru saja disimpan
        $menuId = $menus->id;

        //Jika mengupdate gambar menu
        if ($request->hasFile('menu_pic')) {
            $image = $request->file('menu_pic');

            //Ubah nama file gambar menjadi ID makanan
            $imageName = $menuId . '.' . $image->getClientOriginalExtension();

            //Resize ukuran gambar menu
            $resizedImage = Image::make($image)->fit(600, 520)->encode();

            //Tentukan path penyimpanan
            $imagePath = 'public/menu_images/' . $imageName;

            //Simpan gambar yang telah diresize ke folder penyimpanan
            Storage::put($imagePath, $resizedImage);

            //Update path gambar pada model menu
            $menus->menu_pic = $imagePath;
            $menus->save();
        }

        return redirect()->route('datamenu')->with('Berhasil', 'Menu berhasil diupdate.');
    }

    ////Function untuk delete menu admin
    public function menu_delete($id)
    {
        //Mengambil menu berdasarkan id
        $menus = menu::find($id);
        $menus->delete();

        return redirect()->back();
    }
}