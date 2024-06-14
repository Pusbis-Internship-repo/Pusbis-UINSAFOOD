@extends('pointakses.admin.layouts.dashboard')

@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <h1>Edit Menu</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('updatemenu', $menus->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group">
                    <label for="menu_name">Nama Menu</label>
                    <input type="text" class="form-control" id="menu_name" name="menu_name" value="{{ $menus->menu_name }}">
                </div>

                <div class="form-group">
                    <label for="menu_price">Harga Menu</label>
                    <input type="number" class="form-control" id="menu_price" name="menu_price" value="{{ $menus->menu_price }}">
                </div>

                <label for="menu_pic">Gambar Menu</label>
                <input type="file" class="form-control @error('menu_pic') is-invalid @enderror" name="menu_pic">
                <br>

                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select class="form-control" id="category" name="category">
                        <option value="" selected>Select Category</option>
                            
                            @php
                              $categories = \App\Models\Category::all();   
                            @endphp
                            
                        @if ($categories && count($categories) > 0)
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}" {{ $category['id'] == $menus->category_id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="form-group">
                    <label for="menu_desc">Deskripsi Menu:</label>
                    <textarea class="form-control" name="menu_desc" id="menu_desc" rows="3">{{ $menus->menu_desc }}</textarea>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                <a href="{{ route('datamenu') }}" class="btn btn-primary btn-sm">Kembali ke Daftar Menu</a>
            </div>
        </form>
    </div>

@include('pointakses.admin.include.sidebar_admin')>

@endsection
