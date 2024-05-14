<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    //Menampilkan data pesanan masuk
    public function groupDataByCreatedAt(Request $request)
    {
        //Menghitung jumlah order masuk dengan status pending
        $totalPendingOrders = DB::table('orders')
            ->where('status', 'pending')
            ->distinct('id_pesanan')
            ->count('id_pesanan');

        //Menghitung jumlah order masuk dengan status setuju
        $totalAcceptedOrders = DB::table('orders')
            ->where('status', 'setuju') 
            ->distinct('id_pesanan')
            ->count('id_pesanan');
        
        //Mengambil input tanggal mulai dan akhir saat menggunakan filter & search
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        //Mengelompokkan order berdasarkan id_pesanan yang sama
        $groupedOrdersQuery = DB::table('orders')
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
                DB::raw('GROUP_CONCAT(CONCAT(menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity')
            )
            ->whereIn('status', ['pending']);

        //Mengambil tanggal mulai dan akhir saat menggunakan filter
        if ($startDate && $endDate) {
            $groupedOrdersQuery->whereBetween('orders.tanggal', [$startDate, $endDate]);
        }

        //Mengambil tanggal mulai dan akhir saat menggunakan search
        if ($search) {
            $groupedOrdersQuery->where(function ($query) use ($search) {
                $query->where('id_pesanan', 'like', '%' . $search . '%')
                    ->orWhere('menu_name', 'like', '%' . $search . '%')
                    ->orWhere('total', 'like', '%' . $search . '%')
                    ->orWhere('nama_penerima', 'like', '%' . $search . '%')
                    ->orWhere('alamat_pengiriman', 'like', '%' . $search . '%')
                    ->orWhere('fakultas', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        //Mengambil data berdasarkan id_pesanan yang sama
        $groupedOrders = $groupedOrdersQuery
            ->orderBy('id_pesanan', 'desc')
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap')
            ->get();

        return view('pointakses/admin/data_transaksi/tampilkan_transaksi', [
            'groupedOrders' => $groupedOrders,
            'search' => $search,
            'totalPendingOrders' => $totalPendingOrders,
            'totalAcceptedOrders' => $totalAcceptedOrders,
        ]);
    }

    //Invoice order admin
    public function admin_invoice($id_pesanan)
    {
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
                'catatan',
                DB::raw('GROUP_CONCAT(menu_name) as menu_names'),
                DB::raw('GROUP_CONCAT(seller) as sellers'),
                DB::raw('GROUP_CONCAT(menu_price) as menu_prices'),
                DB::raw('GROUP_CONCAT(subtotal) as subtotals'),
                DB::raw('GROUP_CONCAT(quantity SEPARATOR ", ") as quantities')
            )
            ->where('id_pesanan', $id_pesanan)
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap', 'status', 'catatan')
            ->get();

        return view('pointakses.admin.data_transaksi.admin_invoice', compact('groupedOrders'));
    }

    //Function untuk merubah status pesanan menjadi setuju
    public function accept($id_pesanan)
    {
        DB::table('orders')

            ->where('id_pesanan', $id_pesanan)
            ->update(['status' => 'Setuju']);

        return redirect()->route('admin.orders')->with('sucess', 'Order Telah Disetujui');
    }

    //Function untuk merubah status pesanan menjadi tolak
    public function reject($id_pesanan)
    {
        DB::table('orders')

            ->where('id_pesanan', $id_pesanan)
            ->update(['status' => 'Tolak']);

        return redirect()->route('admin.orders')->with('success', 'Order Telah Ditolak');
    }

    //Page history order admin
    public function history_order(Request $request)
    {
        //Mengambil parameter untuk fungsi search order
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

        //Mengambil dan mengelompokkan order
        $groupedOrdersQuery = DB::table('orders')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->select(
                'id_pesanan',
                'total',
                'nama_penerima',
                'alamat_pengiriman',
                'fakultas',
                'tanggal',
                'jam',
                'status',
                'users.nama_lengkap',
                DB::raw('GROUP_CONCAT(CONCAT(menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity')
            )
            ->whereIn('status', ['Setuju', 'Tolak']);

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
            ->orderBy('id_pesanan', 'desc')
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'status', 'users.nama_lengkap')
            ->get();

        return view('pointakses/admin/data_transaksi/history', ['groupedOrders' => $groupedOrders, 'search' => $search]);
    }
}