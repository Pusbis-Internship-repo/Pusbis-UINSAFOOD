@extends('pointakses.admin.layouts.dashboard')

@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <h1>Edit Pengguna</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('update.seller', $sellers->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Pengguna</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $sellers->nama_lengkap }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$sellers->email}}">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" >
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                <a href="{{ route('dataseller') }}" class="btn btn-primary btn-sm">Kembali ke Daftar Mitra</a>
            </div>
        </form>
    </div>

@include('pointakses.admin.include.sidebar_admin')>

@endsection
