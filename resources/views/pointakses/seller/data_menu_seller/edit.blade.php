@extends('pointakses.seller.layouts.dashboard')

@section('content_seller')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <br>
        <h2 class="text-center"><strong>EDIT MENU</strong></h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('updatemenuseller', $menus->id) }}" method="POST" enctype="multipart/form-data">
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
                    <label for="min_order">Minimal Order</label>
                    <select class="form-control" id="min_order" name="min_order">
                        <option value="H-1" {{ $menus->min_order_time == 'H-1' ? 'selected' : '' }}>H-1</option>
                        <option value="H-2" {{ $menus->min_order_time == 'H-2' ? 'selected' : '' }}>H-2</option>
                        <option value="H-3" {{ $menus->min_order_time == 'H-3' ? 'selected' : '' }}>H-3</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="menu_desc">Deskripsi Menu:</label>
                    <textarea class="form-control" name="menu_desc" id="menu_desc" rows="3">{{ $menus->menu_desc }}</textarea>
                </div>
                    
                <!-- Input makanan_1 sampai makanan_8 -->
                <div id="makanan_prasmanan" style="display: flex;">
                    <div class="form-group">
                        <label for="makanan_1">Makanan 1</label>
                        <input type="text" class="form-control" id="makanan_1" name="makanan_1">
                    </div>
                    <div class="form-group">
                        <label for="makanan_2">Makanan 2</label>
                        <input type="text" class="form-control" id="makanan_2" name="makanan_2">
                    </div>
                    <div class="form-group">
                        <label for="makanan_3">Makanan 3</label>
                        <input type="text" class="form-control" id="makanan_3" name="makanan_3">
                    </div>
                    <div class="form-group">
                        <label for="makanan_4">Makanan 4</label>
                        <input type="text" class="form-control" id="makanan_4" name="makanan_4">
                    </div>
                    <div class="form-group">
                        <label for="makanan_5">Makanan 5</label>
                        <input type="text" class="form-control" id="makanan_5" name="makanan_5">
                    </div>
                    <div class="form-group">
                        <label for="makanan_6">Makanan 6</label>
                        <input type="text" class="form-control" id="makanan_6" name="makanan_6">
                    </div>
                    <div class="form-group">
                        <label for="makanan_7">Makanan 7</label>
                        <input type="text" class="form-control" id="makanan_7" name="makanan_7">
                    </div>
                    <div class="form-group">
                        <label for="makanan_8">Makanan 8</label>
                        <input type="text" class="form-control" id="makanan_8" name="makanan_8">
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                <a href="{{ route('data_menu_seller') }}" class="btn btn-primary btn-sm">Kembali ke Daftar Menu</a>
            </div>
        </form>
    </div>

    <script>
            document.getElementById('category').addEventListener('change', function() {
                var selectedCategory = this.options[this.selectedIndex].getAttribute('data-category');
                if (selectedCategory === 'prasmanan') {
                    document.getElementById('makanan_prasmanan').style.display = 'block';
                    // Aktifkan input makanan prasmanan
                    document.getElementById('makanan_1').required = true;
                    document.getElementById('makanan_2').required = true;
                    // Aktifkan input makanan lainnya sesuai kebutuhan
                } else {
                    document.getElementById('makanan_prasmanan').style.display = 'none';
                    // Nonaktifkan input makanan prasmanan
                    document.getElementById('makanan_1').required = false;
                    document.getElementById('makanan_2').required = false;
                    // Nonaktifkan input makanan lainnya sesuai kebutuhan
                }
            });
        </script>

@include('pointakses.seller.include.sidebar_seller')
@endsection
