<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    //Memproses dan menyimpan pesanan yang ditempatkan oleh user
    public function placeOrder(Request $request): RedirectResponse
    {
        //Mendapatkan data pesanan dari sesi pengguna
        $orderData = Session::get("order_" . auth()->id());

        //Jika tidak ada item di keranjang, kembali ke halaman dengan pesan error
        if (!$orderData) {
            return redirect()->route('menu_user')->with('error', 'Tidak ada data pesanan yang tersedia.');
        }
    
        // Mendapatkan id_pesanan yang sama untuk semua menu dalam satu pesanan
        $orderId = Order::max('id_pesanan') + 1;
        
        // Mendapatkan catatan dari request
        $catatan = $request->input('catatan');

        //Menghitung total pesanan
        $total = $this->calculateTotal($orderData);
        
        //Menyimpan detail pemesanan ke database
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
                'fakultas' => $request->input('fakultas') === 'Lainnya..' ? $request->input('upt_lain') : $request->input('fakultas'),
                'tanggal' => $request->input('tanggal'), 
                'jam' => $request->input('jam'), 
                'min_order_time' => $request->input('min_order_time'),
                'catatan' => $request->input('catatan'), 
            ]);

            $order->save();
        }
    
        // Update nilai 'total' setelah semua item order ditambahkan
        $this->updateOrderTotal($orderId);
        
        //Hapus data pesanan dari session
        Session::forget("order_" . auth()->id());
        
        // Redirect ke halaman terima kasih atau halaman lainnya
        return redirect()->route('history_order')->with('success', 'Transaksi berhasil.')->with(compact('total'));
    }

    //Function untuk menghitung total pesanan
    private function calculateTotal($orderData)
    {
        $total = 0;

        //Menjumlahkan subtotal dari setiap item pesanan
        foreach ($orderData as $orderDetail) {
            $total += $orderDetail['subtotal'];
        }

        return $total;
    }

    //Memperbarui nilai total untuk pesanan berdasarkan id_pesanan
    private function updateOrderTotal($orderId)
    {
        //Mengambil semua item pesanan berdasarkan id_pesanan
        $orderItems = Order::where('id_pesanan', $orderId)->get();
    
        //Menghitung total dengan menjumlah subtotal
        $totalOrder = $orderItems->sum('subtotal');
    
        //Memperbarui total pesanan di setiap item pesanan
        foreach ($orderItems as $orderItem) {
            $orderItem->total = $totalOrder;
            $orderItem->save();
        }
    }
}