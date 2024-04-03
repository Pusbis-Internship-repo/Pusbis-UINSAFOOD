@extends('frontend.customer.layouts.menu')
@include('frontend.include.header')

<section id="page_header">
    <div class="page_title">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">History Order</h2>
                    <p>UINSA FOOD</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.card-header -->


    <div class="card-body table-responsive p-0">
        <br>
        <h3>Cari Transaksi</h3>
        <form method="GET" action="{{ route('history_order') }}">
            <div class="col-md-3">
                <label for="">Tanggal mulai</label>
                <input type="date" name="start_date" class="form-control">
            </div>
            <div class="col-md-3">
                <label for="">Tanggal akhir</label>
                <input type="date" name="end_date" class="form-control">
            </div>
            <div class="col-md-1 pt-4">
                <button type="submit" class="btn btn-info">Filter</button>
            </div>
    </form>

    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Data Order</th>
                <th>Invoice</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($groupedOrders as $groupedOrder)
            <tr>
                <td>
                    <strong>{{ $groupedOrder->tanggal }}, {{ $groupedOrder->jam }}</strong>
                </td>
                <td>
                    @isset($groupedOrder->id_pesanan)
                    <strong>ID Pesanan: {{ $groupedOrder->id_pesanan }}</strong>
                    @endisset
                    <br>Menu (Jumlah): <strong>{{ $groupedOrder->menu_with_quantity }}</strong>
                    <br>Total: Rp. {{ number_format($groupedOrder->total, 0, ',', '.') }}
                    <br>Nama Penerima: {{ $groupedOrder->nama_penerima }}
                    <br>Alamat Pengiriman: {{ $groupedOrder->alamat_pengiriman }}
                    <br>Fakultas: {{ $groupedOrder->fakultas }}
                    <br>Tanggal & Jam: {{ $groupedOrder->tanggal }}, {{ $groupedOrder->jam }}
                </td>
                <td>
                    @isset($groupedOrder->id_pesanan)
                    <a href="{{ route('user_invoice', ['id_pesanan' => $groupedOrder->id_pesanan]) }}"
                        class="btn btn-info" target="_blank">Buka Invoice</a>
                    @endisset
                </td>
                <td>
                    @if($groupedOrder->status === 'Setuju')
                        <strong class="text-success">{{ $groupedOrder->status }}</strong>
                    @elseif($groupedOrder->status === 'tolak')
                        <strong class="text-danger">{{ $groupedOrder->status }}</strong>
                    @else
                        <strong class="text-warning">{{ $groupedOrder->status }}</strong>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>