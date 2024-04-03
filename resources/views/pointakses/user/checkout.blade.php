@extends('frontend.customer.layouts.menu')
@include('frontend.include.header')

@section('menu')
<section id="page_header">
    <div class="page_title">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="title">Shopping Cart</h2>
                    <p>UINSA FOOD</p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <br>
    <h2>Checkout</h2>
    <br>
    <table id="cart" class="table table-bordered">
        <tr>
            <th>Menu</th>
            <th>Vendor</th>
            <th>Gambar Menu</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        @php $total = 0 @endphp
        @if(session("order_" . auth()->id()))
        @foreach(session("order_" . auth()->id()) as $id => $order_detail)
        <tr rowId="{{ $id }}">
            <td data-th="Menu">
                <div class="row">
                    <div class="col-sm-12">
                        <h4 class="nomargin">{{ $order_detail['menu_name'] }}</h4>
                    </div>
                </div>
            </td>
            <td data-th="Seller">{{ $order_detail['seller'] }}</td>
            <td class="text-center">
                <img src="{{ url('storage/menu_images/' . basename($order_detail['menu_pic'])) }}" class="rounded"
                    style="width: 150px">
            </td>
            <td data-th="Price">Rp. {{ number_format($order_detail['menu_price'], 0, ',', '.') }}</td>
            <td data-th="Quantity">{{ $order_detail['quantity'] }}</td>
            <td data-th="Subtotal" class="text-center">Rp. {{ number_format($order_detail['subtotal'], 0, ',', '.') }}
            </td>
            @php
            $total += $order_detail['subtotal'];
            @endphp
        </tr>
        @endforeach
        @endif
    </table>

    <h2>Delivery Details</h2>
    <!-- Add a form for entering delivery details -->
    <form action="{{ route('place.order') }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="nama_penerima" class="form-label">Nama Penerima</label>
            <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" required>
        </div>
        <div class="mb-3">
            <label for="alamat_pengiriman" class="form-label">Alamat Pengiriman</label>
            <select name="alamat_pengiriman" id="alamat_pengiriman" class="form-control">
                <option value="" disabled selected>-- Pilih Alamat --</option>
                <option value="Pusat Pengembangan Bisnis UINSA">Pusat Pengembangan Bisnis UINSA</option>
                <option value="UINSA Kampus 1, Ahmad Yani">UINSA Kampus 1, Ahmad Yani</option>
                <option value="UINSA Kampus 2, Gunung Anyar">UINSA Kampus 2, Gunung Anyar</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="fakultas" class="form-label">Fakultas</label>
            <select name="fakultas" id="fakultas" class="form-control">
                <option value="" disabled selected>-- Pilih Fakultas --</option>
                <option value="Adab dan Humaniora">Adab dan Humaniora</option>
                <option value="Dakwah dan Komunikasi">Dakwah dan Komunikasi</option>
                <option value="Syariah dan Hukum">Syariah dan Hukum</option>
                <option value="Tarbiyah dan Keguruan">Tarbiyah dan Keguruan</option>
                <option value="Ushuluddin dan Filsafat">Ushuluddin dan Filsafat</option>
                <option value="Ilmu Sosial dan Ilmu Politik">Ilmu Sosial dan Ilmu Politik</option>
                <option value="Ekonomi dan Bisnis Islam">Ekonomi dan Bisnis Islam</option>
                <option value="Psikologi dan Kesehatan">Psikologi dan Kesehatan</option>
                <option value="Sains dan Teknologi">Sains dan Teknologi</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" required style="width: 150px" 
                    min="{{ \Carbon\Carbon::now()->addDay()->format('Y-m-d') }}">
        </div>
        <div class="mb-3">
            <label for="jam" class="form-label">Jam</label>
            <input type="time" class="form-control" id="jam" name="jam" required style="width: 150px">
        </div>
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
        </div>
        <div class="text-right">
            <br>
            <button type="submit" class="btn btn-success">Place Order</button>
        </div>
    </form>

    <div class="text-right">
        <strong>Total: Rp. {{ number_format($total, 0, ',', '.') }}</strong>
    </div>
</div>
@endsection