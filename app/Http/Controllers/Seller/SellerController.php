<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;

use App\Charts\SellerChart;

use App\Models\Menu;

class SellerController extends Controller
{
    function index(SellerChart $chart){
    
        $userId = Auth::id();

        $sellertotalmenus = DB::table('table_menu')->where('users_id', $userId)->count();
        $totalwaitorder = DB::table('orders')->where('status', 'setuju')->where('users_id', $userId)->count();

        $datachart['chart'] =  $chart->build();

        $groupedOrders = DB::table('orders')
            ->join('table_menu', 'orders.menu_name', '=', 'table_menu.menu_name')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->select('orders.id_pesanan', 'orders.total', 'orders.nama_penerima', 'orders.alamat_pengiriman', 'orders.fakultas', 'orders.tanggal', 'orders.jam', 'users.nama_lengkap', 'status',
                DB::raw('GROUP_CONCAT(CONCAT(orders.menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity'))
            ->where('table_menu.users_id', $userId)
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap', 'status')
            ->get();

        $data = compact('groupedOrders', 'sellertotalmenus', 'totalwaitorder');
        $merge = array_merge($data, $datachart);
        return view('pointakses/seller/index', $merge);
    }

    public function seller_order(Request $request)
    {
        $userId = Auth::id();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $search = $request->input('search');
    
        $groupedOrdersQuery = DB::table('orders')
        ->join('table_menu', 'orders.menu_name', '=', 'table_menu.menu_name')
        ->join('users', 'orders.users_id', '=', 'users.id')
        ->select('orders.id_pesanan', 'orders.total', 'orders.nama_penerima', 'orders.alamat_pengiriman', 'orders.fakultas', 'orders.tanggal', 'orders.jam', 'users.nama_lengkap', 'status',
            DB::raw('GROUP_CONCAT(CONCAT(orders.menu_name, " (", quantity, ")") SEPARATOR ", ") as menu_with_quantity'))
        ->where('table_menu.users_id', $userId)
        ->whereIn('status', ['setuju']);

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
            ->groupBy('orders.id_pesanan', 'orders.total', 'orders.nama_penerima', 'orders.alamat_pengiriman', 'orders.fakultas', 'orders.tanggal', 'orders.jam', 'users.nama_lengkap','status')
            ->get();

    return view('pointakses/seller/data_order/tampilkan_order', ['groupedOrders' => $groupedOrders, 'search' => $search]);
    }

    public function seller_invoice($id_pesanan)
    {
        $userId = Auth::id();
        
        $groupedOrders = DB::table('orders')
            ->join('table_menu', 'orders.menu_name', '=', 'table_menu.menu_name')
            ->join('users', 'orders.users_id', '=', 'users.id')
            ->select('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap','status','catatan', 
                DB::raw('GROUP_CONCAT(orders.menu_name) as menu_names'), 
                DB::raw('GROUP_CONCAT(orders.seller) as sellers'), 
                DB::raw('GROUP_CONCAT(orders.menu_price) as menu_prices'), 
                DB::raw('GROUP_CONCAT(orders.subtotal) as subtotals'), 
                DB::raw('GROUP_CONCAT(orders.quantity SEPARATOR ", ") as quantities'))
            ->where('id_pesanan', $id_pesanan)
            ->where('table_menu.users_id', $userId)
            ->groupBy('id_pesanan', 'total', 'nama_penerima', 'alamat_pengiriman', 'fakultas', 'tanggal', 'jam', 'users.nama_lengkap','status','catatan')
            ->get();
        
        // Return the view with the data
        return view('pointakses/seller/data_order/seller_invoice', compact('groupedOrders'));
    }

    public function selleredit()
    {
        return view('pointakses/seller/profile/profileedit');
    }

    public function updateprofileseller(Request $request)
    {
        $users = auth()->user();
        $users->nama_lengkap = $request->input('nama_lengkap');
        $users->email = $request->input('email');
        $users->no_tlp = $request->input('no_tlp');
        $users->alamat = $request->input('alamat');
        $users->unit_kerja = $request->input('unit_kerja');
        $users->save();

        return back()->with('message','Update Profile Berhasil');
    }

    public function editpasswordseller()
    {
        return view('pointakses/seller/profile/password');
    }
    public function updatepasswordseller( Request $request){
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('change.password')
                ->withErrors($validator)
                ->withInput();
        }

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return redirect()->route('change.password')
                ->with('error', 'Password lama tidak valid.')
                ->withInput();
        }
    
        // Update password baru
        auth()->user()->update(['password' => Hash::make($request->password)]);
    
        return redirect()->back()
            ->with('success', 'Password berhasil diperbarui.');
    }
}