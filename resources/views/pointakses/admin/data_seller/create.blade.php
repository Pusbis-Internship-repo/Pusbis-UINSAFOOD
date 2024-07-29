@extends('pointakses.admin.layouts.dashboard')'

@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="600">

        <div class="card card-primary mt-4">
            <div class="card-header">
                <h3 class="card-title">Tambah Akun Seller</h3>
            </div>
            <form action="{{ route('storeseller') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="#">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" placeholder="Nama Seller" value="{{ old('nama_lengkap') }}">

                        <!-- error message untuk nama_lengkap -->
                        @error('nama_lengkap')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="#">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}">
                        <!-- error message untuk nama_lengkap -->
                        @error('email')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="#">Nomer Telepon</label>
                        <input type="text" name="no_tlp"  class="form-control @error('no_tlp') is-invalid @enderror" placeholder="Nomer Telepon" value="{{ old('no_tlp') }}">
                        <!-- error message untuk nama_lengkap -->
                        @error('no_tlp')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="#">UNIT KERJA</label>
                        <input type="text" name="unit_kerja"  class="form-control @error('unit_kerja') is-invalid @enderror" placeholder="UNIT KERJA" value="{{ old('unit_kerja') }}">
                        <!-- error message untuk nama_lengkap -->
                        @error('unit_kerja')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="#">ALAMAT LENGKAP</label>
                        <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="ALAMAT LENGKAP" value="{{ old('alamat') }}">
                        <!-- error message untuk nama_lengkap -->
                        @error('alamat')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password" value="{{ old('password') }}">
                        <span class="toggle-btn" onclick="togglePassword()"><i class="fas fa-eye"></i> Show Password</span>

                        <!-- error message untuk nama_lengkap -->
                        @error('password')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('dataseller') }}" class="btn btn-primary">Kembali ke Daftar Seller</a>
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
