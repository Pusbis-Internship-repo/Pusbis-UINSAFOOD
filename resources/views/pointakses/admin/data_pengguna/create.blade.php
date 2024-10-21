@extends('pointakses.admin.layouts.dashboard')'
@section('content')
    <div class="content">
        <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
            <div class="card card-primary mt-4">
                <div class="card-header">
                    <h3 class="card-title"> Tambah Users</h3>
                </div>
                <form action="{{ route('storeuser') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-goup">
                            <label for="nama_lengkap">Nama Lengkap</label>
                            <input type="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" id="exampleInputEmail1" placeholder="Nama Lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}">

                            <!-- error message untuk nama_lengkap -->
                            @error('nama_lengkap')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" placeholder="email" name="email" value="{{ old('email') }}">

                            <!-- error message untuk email -->
                            @error('email')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <!-- select -->
                            <div class="form-group">
                                <label for="role">Select</label>
                                <select class="custom-select rounded-0 @error('role') is-invalid @enderror" name="role">
                                    <option disabled selected value="">Pilih Role</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>user</option>
                                    {{-- <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>admin</option> --}}
                                </select>

                                <!-- error message untuk role -->
                                @error('role')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_tlp">No.tlp</label>
                            <input type="no_tlp" class="form-control @error('no_tlp') is-invalid @enderror" id="exampleInputEmail1" placeholder="Enter email" name="no_tlp" value="{{ old('no_tlp') }}">

                            <!-- error message untuk no_tlp -->
                            @error('no_tlp')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="unit_kerja">Unit Kerja</label>
                            <input type="unit_kerja" class="form-control @error('unit_kerja') is-invalid @enderror" id="email" placeholder="Enter email" name="unit_kerja" value="{{ old('unit_kerja') }}">

                            <!-- error message untuk unit_kerja -->
                            @error('unit_kerja')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="#">Alamat</label>
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
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="password" name="password" value="{{ old('password') }}">
                            <span class="toggle-btn" onclick="togglePassword()"><i class="fas fa-eye"></i> Show Password</span>

                            <!-- error message untuk password -->
                            @error('password')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('data.pengguna') }}" class="btn btn-primary">Kembali ke Daftar Seller</a>
                    </div>
                </form>
            </div>
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
