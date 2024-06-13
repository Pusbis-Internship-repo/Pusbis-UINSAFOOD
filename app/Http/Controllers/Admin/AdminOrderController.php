<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Order;

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
        $orders = Order::with('user')
            ->where('id_pesanan', $id_pesanan)
            ->get();

        $groupedOrders = $orders->groupBy('id_pesanan')->map(function($group){
            $first = $group->first();
            return(object)[
                'id_pesanan' => $first->id_pesanan,
                'total' => $first->total,
                'nama_penerima' => $first->nama_penerima,
                'alamat_pengiriman' => $first->alamat_pengiriman,
                'fakultas' => $first->fakultas,
                'tanggal' => $first->tanggal,
                'jam' => $first->jam,
                'nama_lengkap' => $first->user->nama_lengkap,
                'status' => $first->status,
                'catatan' => $first->catatan,
                'menu_names' => $group->pluck('menu_name')->implode(', '),
                'sellers' => $group->pluck('seller')->implode(', '),
                'menu_prices' => $group->pluck('menu_price')->implode(', '),
                'subtotals' => $group->pluck('subtotal')->implode(', '),
                'quantities' => $group->pluck('quantity')->implode(', ')
            ];
        });

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
