@extends('pointakses.admin.layouts.dashboard')

@section('content')

<div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">

                    <br>
                    <h3>Cari Transaksi</h3>
                    <form method="GET" action="{{ route('admin.history') }}">
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

                    <div class="card-tools">
                        <form action="{{ route('admin.history') }}" method="GET">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right"
                                    placeholder="Search">
    
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
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
                            @foreach($groupedOrders as $groupedOrder)
                            <tr>
                                <td><strong>{{ $groupedOrder->tanggal }}, {{$groupedOrder->jam }}</strong></td>
                                <td><strong>ID Pesanan: {{ $groupedOrder->id_pesanan }} </strong>
                                    <br><strong>Pemesan: {{ $groupedOrder->nama_lengkap }}</strong>
                                    <br>Menu (Jumlah): {{ $groupedOrder->menu_with_quantity }}
                                    <br>Total: Rp. {{ number_format($groupedOrder->total, 0, ',', '.') }}
                                    <br>Nama Penerima: {{ $groupedOrder->nama_penerima }}
                                    <br>Alamat Pengiriman: {{ $groupedOrder->alamat_pengiriman }}
                                    <br>fakultas: {{ $groupedOrder->fakultas }}
                                    <br>Tanggal & Jam: {{ $groupedOrder->tanggal }}, {{$groupedOrder->jam}}
                                    <br>Status: {{ $groupedOrder->status }}
                                </td>
                                <td>@isset($groupedOrder->id_pesanan)
                                    <a href="{{ route('admin_invoice', ['id_pesanan' => $groupedOrder->id_pesanan]) }}"
                                        class="btn btn-info" target="_blank">Lihat Invoice</a>
                                    @endisset</td>
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
</div>
</div>
@include('pointakses.admin.include.sidebar_admin')
@endsection