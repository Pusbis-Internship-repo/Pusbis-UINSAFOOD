<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function groupDataByCreatedAt(Request $request)
    {
        $totalPendingOrders = DB::table('orders')
            ->where('status', 'pending')
            ->distinct('id_pesanan')
            ->count('id_pesanan');
        $totalAcceptedOrders = DB::table('orders')
            ->where('status', 'setuju') 
            ->distinct('id_pesanan')
            ->count('id_pesanan');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

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

        if ($startDate && $endDate) {
            $groupedOrdersQuery->whereBetween('orders.tanggal', [$startDate, $endDate]);
        }

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

        $groupedOrders = $groupedOrdersQuery
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap')
            ->get();

        return view('pointakses/admin/data_transaksi/tampilkan_transaksi', [
            'groupedOrders' => $groupedOrders,
            'search' => $search,
            'totalPendingOrders' => $totalPendingOrders,
            'totalAcceptedOrders' => $totalAcceptedOrders,
        ]);
    }

    public function admin_invoice($id_pesanan)
    {
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

    public function accept($id_pesanan)
    {
        DB::table('orders')

            ->where('id_pesanan', $id_pesanan)
            ->update(['status' => 'Setuju']);

        return redirect()->route('admin.orders')->with('sucess', 'Order Telah Disetujui');
    }
    public function reject($id_pesanan)
    {
        DB::table('orders')

            ->where('id_pesanan', $id_pesanan)
            ->update(['status' => 'Tolak']);

        return redirect()->route('admin.orders')->with('success', 'Order Telah Ditolak');
    }

    public function history_order(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');

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

        if ($startDate && $endDate) {
            $groupedOrdersQuery->whereBetween('tanggal', [$startDate, $endDate]);
        }

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
        $groupedOrders = $groupedOrdersQuery
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'status', 'users.nama_lengkap')
            ->get();

        return view('pointakses/admin/data_transaksi/history', ['groupedOrders' => $groupedOrders, 'search' => $search]);
    }
}