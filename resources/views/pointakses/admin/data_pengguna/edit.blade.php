@extends('pointakses.admin.layouts.dashboard')

@section('content')
</style>
    
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <h1>Edit Pengguna</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('update.pengguna', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Pengguna</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $user->nama_lengkap }}">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="">
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                <a href="{{ route('data.pengguna') }}" class="btn btn-primary btn-sm">Kembali ke Daftar Pengguna</a>
            </div>
        </form>
    </div>

@include('pointakses.admin.include.sidebar_admin')>

@endsection
