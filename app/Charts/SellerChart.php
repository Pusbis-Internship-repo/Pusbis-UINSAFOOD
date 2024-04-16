<?php

namespace App\Charts;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class SellerChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
            $sellerId = Auth::id();

                // Mendapatkan semua pesanan berdasarkan seller yang sedang login
                $orders = Order::whereHas('menu', function($query) use ($sellerId) {
                    $query->where('users_id', $sellerId);
                })
                ->where('status', 'setuju')
                ->whereBetween('created_at', [now()->subYear(), now()])
                ->get();

                // Memproses data pesanan untuk ditampilkan pada grafik
                $labels = [];
                $totalincome=[];
                $data = [];

                // Inisialisasi total pendapatan untuk setiap bulan
                for ($i = 1; $i <= 12; $i++) {
                    $totalincome[$i] = 0;
                }

                
                foreach ($orders as $order) {
                    $month = $order->created_at->format('n'); // Ambil bulan dari tanggal pesanan
                    $labels[] = $order->menu_name; // Tambahkan tanggal pesanan ke label
                    $data[] = $order->quantity; // Jumlah pesanan untuk setiap menu
                    $totalincome[$month]+=$order->menu->menu_price*$order->quantity; //menghitung total pendapatan
                }

                // Array nama bulan
                    $monthNames = [
                        1 => 'Januari', 
                        2 => 'Februari', 
                        3 => 'Maret', 
                        4 => 'April', 
                        5 => 'Mei', 
                        6 => 'Juni', 
                        7 => 'Juli', 
                        8 => 'Agustus', 
                        9 => 'September', 
                        10 => 'Oktober', 
                        11 => 'November', 
                        12 => 'Desember'
                    ];

                    // Mengonversi total pendapatan menjadi format dengan titik pemisah ribuan
                    // $formattedincome = array_map(function ($income) {
                    //     return number_format($income, 0, ',', '.');
                    // }, array_values($totalincome));
                    
                    
            
            return $this->chart->LineChart()
            ->setTitle('Banyaknya Pendapatan Penjual')
            ->setSubtitle('',)
            ->addData('Jumlah Pendapatan', array_values($totalincome)) // Menggunakan array data
            ->setLabels(array_map(function($month) use ($monthNames) {
                return $monthNames[$month];
            }, range(1, 12)));
    }


            
}
