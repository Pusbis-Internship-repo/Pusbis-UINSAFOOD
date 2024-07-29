@extends('pointakses.admin.layouts.dashboard')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .toggle-btn {
            cursor: pointer;
            margin-left: 5px;
        }
    </style>

    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="col md-2">
        <h1>Edit Pengguna</h1>
        </div>
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
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ $sellers->nama_lengkap }}">

                    <!-- error message untuk nama_lengkap -->
                    @error('nama_lengkap')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $sellers->email }}">

                    <!-- error message untuk email -->
                    @error('email')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" >
                    <span class="toggle-btn" onclick="togglePassword()"><i class="fas fa-eye"></i> Show Password</span>

                    <!-- error message untuk password -->
                    @error('password')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                <a href="{{ route('dataseller') }}" class="btn btn-primary btn-sm">Kembali ke Daftar Mitra</a>
            </div>
        </form>
    </div>

    <script>

        function togglePassword() {

            const passwordField = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-btn i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }

    </script>
@include('pointakses.admin.include.sidebar_admin')>

@endsection
