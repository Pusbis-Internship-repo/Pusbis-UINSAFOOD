<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Charts\SellerChart;
use App\Models\Order;

class SellerController extends Controller
{
    //Page dashboard dengan statistik dan grafik
    function index(SellerChart $chart)
    {
        //Mengambil id seller yang sedang login
        $userId = Auth::id();

        //Menghitung total menu seller
        $sellertotalmenus = DB::table('table_menu')->where('users_id', $userId)->count();

        //Menghitung orderan masuk dengan status setuju
        $totalwaitorder = Order::whereHas('menu', function ($query) use ($userId) {
            $query->where('users_id', $userId);
        })
            ->where('status', 'setuju')
            ->count();

        //Menghitung total pemasukan berdasarkan penjualan tiap order
        $totalincome = Order::where('status', 'setuju')
            ->whereHas('menu', function ($query) use ($userId) {
                $query->where('users_id', $userId);
            })
            ->get()
            ->sum(function ($order) {
                return $order->quantity * $order->menu->menu_price;
            });

        //Membangun data grafik untuk ditampilkan
        $datachart['chart'] = $chart->build();

        //Mengambil dan mengelompokkan order
        $groupedOrders = DB::table('orders')
            ->join('table_menu', 'orders.menu_name', '=', 'table_menu.menu_name')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->select(
                'orders.id_pesanan',
                'orders.total',
                'orders.nama_penerima',
                'orders.alamat_pengiriman',
                'orders.fakultas',
                'orders.tanggal',
                'orders.jam',
                'users.nama_lengkap',
                'status',
                DB::raw('GROUP_CONCAT(CONCAT(orders.menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity')
            )
            ->where('table_menu.users_id', $userId)
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap', 'status')
            ->get();
        
        //Menggabungkan data untuk ditampilkan di view
        $data = compact('groupedOrders', 'sellertotalmenus', 'totalwaitorder', 'totalincome');
        $merge = array_merge($data, $datachart);
        return view('pointakses/seller/index', $merge);
    }

    //Page order seller
    public function seller_order(Request $request)
    {
        //Mengambil id seller yang sedang login
        $userId = Auth::id();

        //Mengambil parameter untuk fungsi search order
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        //Mengelompokkan order berdasarkan id_pesanan yang sama
        $groupedOrdersQuery = DB::table('orders')
            ->join('table_menu', 'orders.menu_name', '=', 'table_menu.menu_name')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->select(
                'orders.id_pesanan',
                'orders.total',
                'orders.nama_penerima',
                'orders.alamat_pengiriman',
                'orders.fakultas',
                'orders.tanggal',
                'orders.jam',
                'users.nama_lengkap',
                'status',
                DB::raw('GROUP_CONCAT(CONCAT(orders.menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity')
            )
            ->where('table_menu.users_id', $userId)
            ->whereIn('status', ['setuju']);

        //Memfilter tanggal saat menggunakan fungsi filter
        if ($startDate && $endDate) {
            $groupedOrdersQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }

        //Mencari pesanan saat menggunakan fungsi search
        if ($search) {
            $groupedOrdersQuery->where(function ($query) use ($search) {
                $query->where('id_pesanan', 'like', '%' . $search . '%')
                    ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('menu_name', 'like', '%' . $search . '%')
                    ->orWhere('total', 'like', '%' . $search . '%')
                    ->orWhere('nama_penerima', 'like', '%' . $search . '%')
                    ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%')
                    ->orWhere('fakultas', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        //Mengambil dan mengelompokkan data pesanan
        $groupedOrders = $groupedOrdersQuery
            ->orderBy('orders.id_pesanan', 'desc')
            ->groupBy('orders.id_pesanan', 'orders.total', 'orders.nama_penerima', 'orders.alamat_pengiriman', 'orders.fakultas', 'orders.tanggal', 'orders.jam', 'users.nama_lengkap', 'status')
            ->get();

        return view('pointakses/seller/data_order/tampilkan_order', ['groupedOrders' => $groupedOrders, 'search' => $search]);
    }

    //Menampilkan invoice di seller
    public function seller_invoice($id_pesanan)
    {
        //Mengambil id seller yang sedang login
        $userId = Auth::id();

        //Mengelompokkan order berdasarkan id_pesanan yang sama dan menu yang dipunyai
        $groupedOrders = DB::table('orders')
            ->join('table_menu', 'orders.menu_name', '=', 'table_menu.menu_name')
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
                'catatan',
                DB::raw('GROUP_CONCAT(orders.menu_name) as menu_names'),
                DB::raw('GROUP_CONCAT(orders.seller) as sellers'),
                DB::raw('GROUP_CONCAT(orders.menu_price) as menu_prices'),
                DB::raw('GROUP_CONCAT(orders.subtotal) as subtotals'),
                DB::raw('GROUP_CONCAT(orders.quantity SEPARATOR ", ") as quantities')
            )
            ->where('id_pesanan', $id_pesanan)
            ->where('table_menu.users_id', $userId)
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap', 'status', 'catatan')
            ->get();

        return view('pointakses/seller/data_order/seller_invoice', compact('groupedOrders'));
    }

    //Page edit profil seller
    public function selleredit()
    {
        return view('pointakses/seller/profile/profileedit');
    }

    //Function untuk update profil seller
    public function updateprofileseller(Request $request)
    {
        //Mengambil akun yang sedang login
        $users = auth()->user();
        $users->nama_lengkap = $request->input('nama_lengkap');
        $users->email = $request->input('email');
        $users->no_tlp = $request->input('no_tlp');
        $users->alamat = $request->input('alamat');
        $users->unit_kerja = $request->input('unit_kerja');
        $users->save();

        //Redirect dengan pesan sukses
        return back()->with('message', 'Update Profile Berhasil');
    }

    //Page edit password seller
    public function editpasswordseller()
    {
        return view('pointakses/seller/profile/password');
    }

    //Function untuk update password seller
    public function updatepasswordseller(Request $request)
    {
        //Validasi input password lama
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('change.password')
                ->withErrors($validator)
                ->withInput();
        }

        //Mengecek apakah password lama sesuai
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->route('change.password')
                ->with('error', 'Password lama tidak valid.')
                ->withInput();
        }

        // Update password baru
        auth()->user()->update(['password' => Hash::make($request->password)]);

        //Redirect dengan pesan sukses
        return redirect()->back()
            ->with('success', 'Password berhasil diperbarui.');
    }
}