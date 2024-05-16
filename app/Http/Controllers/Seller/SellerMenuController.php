<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Menu;

class SellerMenuController extends Controller
{
    //Menampilkan daftar menu penjual dengan search
    function data_menu_seller(Request $request)
    {
        //Mencari menu berdasarkan nama saat digunakan
        if ($request->has('search')) {
            $menus = Menu::where('menu_name', 'LIKE', '%' . $request->search . '%')->get();
        } else {
            //Jika tidak ada, ambil semua menu
            $menus = Menu::all();
        }
        return view('pointakses/seller/data_menu_seller/tampilkan_menu_seller', compact('menus'));
    }

    //Page create menu seller
    function create_menu()
    {
        //Mengambil semua kategori
        $categories = Category::all();

        return view('pointakses/seller/data_menu_seller/create', compact('categories'));
    }

    //Menyimpan menu ke database
    public function store_menu(Request $request): RedirectResponse
    {
        // Validasi input
        $this->validate($request, [
            'menu_pic' => 'required|image|mimes:jpeg,png|max:2048',
            'min_order' => 'required|in:H-1,H-2,H-3',
        ]);
    
        // Mendapatkan user yang sedang login
        $user = auth()->user();
    
        // Membuat instance model Menu
        $menu = new Menu();
        $menu->menu_name = $request->input('menu_name');
        $menu->menu_price = $request->input('menu_price');
        $menu->seller = $user->nama_lengkap;
        $menu->category_id = $request->input('category');
        $menu->menu_desc = $request->input('menu_desc');
        $menu->users_id = auth()->id();
        $menu->min_order_time = $request->input('min_order');
        $menu->makanan_1 = $request->input('makanan_1');
        $menu->makanan_2 = $request->input('makanan_2');
        $menu->makanan_3 = $request->input('makanan_3');
        $menu->makanan_4 = $request->input('makanan_4');
        $menu->makanan_5 = $request->input('makanan_5');
        $menu->makanan_6 = $request->input('makanan_6');
        $menu->makanan_7 = $request->input('makanan_7');
        $menu->makanan_8 = $request->input('makanan_8');
    
        // Simpan data menu ke dalam database
        $menu->save();
    
        // Jika terdapat file gambar yang diupload
        if ($request->hasFile('menu_pic')) {
            $image = $request->file('menu_pic');
    
            // Ubah nama file gambar menjadi ID menu
            $imageName = $menu->id . '.' . $image->getClientOriginalExtension();
    
            // Resize dan simpan gambar ke dalam penyimpanan
            $resizedImage = Image::make($image)->fit(600, 520)->encode();
            $imagePath = 'public/menu_images/' . $imageName;
            Storage::put($imagePath, $resizedImage);
    
            // Update path gambar pada model Menu
            $menu->menu_pic = $imagePath;
            $menu->save();
        }
    
        // Redirect dengan pesan sukses
        return redirect()->route('data_menu_seller')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    //Page edit menu seller
    function edit_menu(string $id): View
    {
        //Menampilkan semua menu
        $menus = Menu::findOrFail($id);

        return view('pointakses/seller/data_menu_seller/edit', compact('menus'));
    }

    //Function untuk update menu
    function menu_update(Request $request, $id): RedirectResponse
    {
        $menus = Menu::find($id);
        $menus->menu_name = $request->input('menu_name');
        $menus->menu_price = $request->input('menu_price');
        $menus->category_id = $request->input('category');
        $menus->menu_desc = $request->input('menu_desc');
        $menus->min_order_time = $request->input('min_order');
        $menus->makanan_1 = $request->input('makanan_1');
        $menus->makanan_2 = $request->input('makanan_2');
        $menus->makanan_3 = $request->input('makanan_3');
        $menus->makanan_4 = $request->input('makanan_4');
        $menus->makanan_5 = $request->input('makanan_5');
        $menus->makanan_6 = $request->input('makanan_6');
        $menus->makanan_7 = $request->input('makanan_7');
        $menus->makanan_8 = $request->input('makanan_8');
        $menus->users_id = auth()->id();
        $menus->save();

        // Ambil ID makanan yang baru saja disimpan
        $menuId = $menus->id;

        if ($request->hasFile('menu_pic')) {
            $image = $request->file('menu_pic');

            // Ubah nama file gambar menjadi ID makanan
            $imageName = $menuId . '.' . $image->getClientOriginalExtension();

            // Resize ukuran gambar menu
            $resizedImage = Image::make($image)->fit(600, 520)->encode();

            // Tentukan path penyimpanan
            $imagePath = 'public/menu_images/' . $imageName;

            // Simpan gambar yang telah diresize ke dalam penyimpanan
            Storage::put($imagePath, $resizedImage);

            // Update path gambar pada model Menu
            $menus->menu_pic = $imagePath;
            $menus->save();
        }

        return redirect()->route('data_menu_seller')->with('Berhasil', 'Menu berhasil diupdate.');
    }

    //Function untuk delete menu
    public function menu_delete($id)
    {
        //Mengambil menu berdasarkan id
        $menus = menu::find($id);
        $menus->delete();

        return redirect()->back();
    }
}