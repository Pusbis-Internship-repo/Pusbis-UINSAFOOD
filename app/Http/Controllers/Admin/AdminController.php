<?php

namespace App\Http\Controllers\Admin;
use App\Charts\AdminMenuReviewChart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    //Menampilkan halaman dashboard admin dengan data statistik dan grafik
    public function index(AdminMenuReviewChart $chart)
    {
        //Menghitung jumlah order dengan status setuju
        $totalOrders = DB::table('orders')->count();
        $totalAcceptedOrders = DB::table('orders')
            ->where('status', 'setuju')
            ->distinct('id_pesanan')
            ->count('id_pesanan');
        
        //Menghitung jumlah order 
        $totalPendingOrders = DB::table('orders')
            ->where('status', 'pending')
            ->distinct('id_pesanan')
            ->count('id_pesanan');

        //Menghitung total user dengan role seller
        $totalsellers = DB::table('users')->where('role', 'seller')->count();

        //Menghitung jumlah menu di database
        $totalmenus = DB::table('table_menu')->count();

        // Membuat chart
        $datachart['chart'] =  $chart->build();

        //Mengelompokkan order berdasarkan id_pesanan yang sama
        $groupedOrders = DB::table('orders')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->select(
                'id_pesanan',
                'total',
                'nama_penerima',
                'alamat_pengiriman',
                'fakultas',
                'tanggal',
                'jam',
                'users.nama_lengkap',
                'status',
                DB::raw('GROUP_CONCAT(CONCAT(menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity')
            )
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap', 'status')
            ->get();

        // Menggabungkan semua variabel ke dalam satu array
        $data = compact('totalOrders', 'totalAcceptedOrders', 'totalsellers', 'totalmenus', 'groupedOrders', 'totalPendingOrders');

        // Menggabungkan $datachart ke dalam array $data
        $datamerge = array_merge($data, $datachart);

        // Mengirimkan semua variabel ke tampilan
        return view('pointakses/admin/index', $datamerge);
    }

    //Page seller admin
    function seller()
    {
        //Menampilkan user dengan role seller
        $sellers = User::where('role', 'seller')->get();

        return view('pointakses/admin/data_seller/tampil_seller', compact('sellers'));
    }

    //Page create seller admin
    function sellercreate()
    {
        return view('pointakses/admin/data_seller/create');
    }

    //Function untuk menyimpan akun seller ke database
    function storeseller(Request $request)
    {
        // Validasi data input jika diperlukan
        $request->validate([
            'nama_lengkap' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'no_tlp' => 'required|string',
            'alamat' => 'required|string',
            'unit_kerja' => 'required|string',
            'password' => 'required|min:8',
        ]);

        // Membuat akun seller baru
        $seller = new User();
        $seller->nama_lengkap = $request->input('nama_lengkap');
        $seller->email = $request->input('email');
        $seller->no_tlp = $request->input('no_tlp');
        $seller->alamat = $request->input('alamat');
        $seller->unit_kerja = $request->input('unit_kerja');
        $seller->password = Hash::make($request->input('password'));
        $seller->role = 'seller'; // Menetapkan role sebagai 'seller'

        // Simpan data ke database
        $seller->save();

        //Redirect dengan pesan sukses
        return redirect()->route('dataseller')->with('message', 'data berhasil dibuat');
    }

    //Page edit seller admin
    function editpenjual($id){
        //Mengambil user berdasarkan id
        $sellers = User::findOrFail($id);
        return view('pointakses/admin/data_seller/edit', compact('sellers'));
    }

    //function untuk update akun seller
    function updateseller(Request $request, $id){

        //Mengambil user berdasarkan id
        $sellers = User::findOrFail($id);

        // Validasi data
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:6', // Password bisa kosong
        ]);
    
        // Update data pengguna
        $sellers->nama_lengkap = $request->nama_lengkap;
        $sellers->email = $request->email;
    
        // Jika password dimasukkan, enkripsi password baru
        if ($request->filled('password')) {
            $sellers->password = Hash::make($request->password);
        }
    
        $sellers->save();
    
        return redirect()->route('dataseller')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    //Function untuk delete akun seller
    function deleteseller($id)
    {
        //Mengambil user berdasarkan id
        $sellers = User::find($id);
        $sellers->delete();

        return redirect()->back();
    }

    //Page user biasa
    function pengguna()
    {
        //Menampilkan list pengguna dengan role user
        $users = User::where('role', 'user')->get();

        return view('pointakses/admin/data_pengguna/tampilkan_data', compact('users'));
    }

    //Page edit akun pengguna
    function editpengguna($id){
        $user = User::findOrFail($id);
        return view('pointakses/admin/data_pengguna/edit', compact('user'));
    }

    //Function untuk update akun pengguna biasa
    function updatepengguna(Request $request, $id){

        //Mengambil user berdasarkan id
        $user = User::findOrFail($id);

        // Validasi data
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'password' => 'required|string|min:6', // Password bisa kosong
        ]);
    
        // Update data pengguna
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
    
        // Jika password dimasukkan, enkripsi password baru
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        //Menyimpan akun ke database
        $user->save();
    
        return redirect()->route('data.pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }
}