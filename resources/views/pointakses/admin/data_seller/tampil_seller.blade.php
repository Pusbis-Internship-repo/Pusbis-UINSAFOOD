@extends('pointakses.admin.layouts.dashboard')


@section('content')
<div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
  <div class="content">
    <br>
    <a href="{{ route('createseller') }}" class="btn btn-success">Tambah Akun Seller</a>
    <div class="col-12 mt-4">
      <div class="card">
      <div class="card-header">
        <h3 class="card-title">DATA SELLER</h3>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>NO Telepon</th>
                <th>Alamat Lengkap</th>
                <th>Unit Kerja</th>
                <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($sellers as $seller)
            <tr>
                <td>{{ $seller->nama_lengkap }}</td>
                <td>{{ $seller->email }}</td>
                <td>{{ $seller->no_tlp }}</td>
                <td>{{ $seller->alamat }}</td>
                <td>{{ $seller->unit_kerja }}</td>
                <td><a href="{{route('deleteseller', $seller->id)}}" class="btn btn-danger btn-sm" 
                  onclick="return confirm('Apakah yakin dihapus? {{ $seller->nama_lengkap }}');">Hapus</a></td>
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
@include('pointakses.admin.include.sidebar_admin')

@endsection