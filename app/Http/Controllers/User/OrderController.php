<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;

use App\Models\Order;

use App\Models\Menu;

class OrderController extends Controller
{
    public function placeOrder(Request $request): RedirectResponse
    {
        $orderData = Session::get("order_" . auth()->id());

        if (!$orderData) {
            return redirect()->route('menu_user')->with('error', 'Tidak ada data pesanan yang tersedia.');
        }
    
        // Mendapatkan id_pesanan yang sama untuk semua menu dalam satu pesanan
        $orderId = Order::max('id_pesanan') + 1;
        
        // Mendapatkan catatan dari request
        $catatan = $request->input('catatan');

        $total = $this->calculateTotal($orderData);
        
        foreach ($orderData as $orderDetail) {
            $orderDetail['id_pesanan'] = $orderId; // Tetapkan id_pesanan ke setiap detail order
            
            $order = new Order([
                'users_id' => auth()->id(),
                'menu_id' => $orderDetail['menu_id'],
                'menu_name' => $orderDetail['menu_name'],
                'seller' => $orderDetail['seller'],
                'menu_pic' => $orderDetail['menu_pic'],
                'menu_price' => $orderDetail['menu_price'],
                'quantity' => $orderDetail['quantity'],
                'subtotal' => $orderDetail['subtotal'],
                'total' => $this->calculateTotal($orderData),
                'id_pesanan' => $orderId, 
                'nama_penerima' => $request->input('nama_penerima'), 
                'alamat_pengiriman' => $request->input('alamat_pengiriman')  === 'Lainnya..' ? $request->input('alamat_lain') : $request->input('alamat_pengiriman'),
                'fakultas' => $request->input('fakultas'), 
                'tanggal' => $request->input('tanggal'), 
                'jam' => $request->input('jam'), 
                'min_order_time' => $request->input('min_order_time'),
                'catatan' => $request->input('catatan'), 
            ]);

            $order->save();
        }
    
        // Update nilai 'total' setelah semua item order ditambahkan
        $this->updateOrderTotal($orderId);
        
        Session::forget("order_" . auth()->id());
        
        // Redirect ke halaman terima kasih atau halaman lainnya
        return redirect()->route('history_order')->with('success', 'Transaksi berhasil.')->with(compact('total'));
    }
    
    private function calculateTotal($orderData)
    {
        $total = 0;

        foreach ($orderData as $orderDetail) {
            $total += $orderDetail['subtotal'];
        }

        return $total;
    }

    private function updateOrderTotal($orderId)
    {
        $orderItems = Order::where('id_pesanan', $orderId)->get();
    
        $totalOrder = $orderItems->sum('subtotal');
    
        foreach ($orderItems as $orderItem) {
            $orderItem->total = $totalOrder;
            $orderItem->save();
        }
    }
    
}
