@extends('pointakses.admin.layouts.dashboard')

@section('content')

    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <h1>Edit Pengguna</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif --}}

        <form action="{{ route('update.pengguna', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Pengguna</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ $user->nama_lengkap }}">

                    <!-- error message untuk nama_lengkap -->
                    @error('nama_lengkap')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$user->email}}">

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
                        <label for="role">Select Role</label>
                        <select class="custom-select rounded-0 @error('role') is-invalid @enderror" name="role">
                            <option disabled selected value="">Pilih Role</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>user</option>
                            {{-- <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>admin</option> --}}
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
                    <input type="no_tlp" class="form-control @error('no_tlp') is-invalid @enderror" id="exampleInputEmail1" placeholder="Enter No. Telepon" name="no_tlp" value="{{ $user->no_tlp }}">

                    <!-- error message untuk no_tlp -->
                    @error('no_tlp')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="unit_kerja">Unit Kerja</label>
                    <input type="unit_kerja" class="form-control @error('unit_kerja') is-invalid @enderror" id="unit_kerja" placeholder="Enter email" name="unit_kerja" value="{{ $user->unit_kerja }}">

                    <!-- error message untuk unit_kerja -->
                    @error('unit_kerja')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="#">Alamat</label>
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror" placeholder="ALAMAT LENGKAP" value="{{ $user->alamat }}">
                    <!-- error message untuk nama_lengkap -->
                    @error('alamat')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="">

                    <!-- error message untuk unit_kerja -->
                    @error('unit_kerja')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
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
