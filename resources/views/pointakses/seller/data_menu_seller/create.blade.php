@extends('pointakses.seller.layouts.dashboard')

@section('content_seller')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="600">
        <div class="card card-primary mt-4">
            <div class="card-header">
                <h3 class="card-title">Tambah Menu</h3>
            </div>
            <form action="{{ route('menusseller') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="menu_name">Nama Menu</label>
                        <input type="text" class="form-control @error('menu_name') is-invalid @enderror" id="menu_name" placeholder="Nama Menu" name="menu_name" value="{{ old('menu_name') }}">
                        @error('menu_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="form-group">
                        <label for="menu_price">Harga Menu</label>
                        <input type="number" class="form-control @error('menu_price') is-invalid @enderror" id="menu_price" placeholder="Harga Menu" name="menu_price" value="{{ old('menu_price') }}">
                        @error('menu_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="form-group">
                        <label for="menu_pic">Gambar Menu</label>
                        <input type="file" class="form-control @error('menu_pic') is-invalid @enderror" name="menu_pic" accept="image/jpeg, image/png">
                        @error('menu_pic')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>                    
        
                    <div class="form-group">
                        <label for="category">Select Category</label>
                        <select class="form-control @error('category') is-invalid @enderror" id="category" name="category">
                            <option value="" selected>Select Category</option>
        
                            @if ($categories && count($categories) > 0)
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}" data-category="{{ $category->category_name }}">{{ $category->category_name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
        
                    <div class="col-sm-6">
                        <!-- textarea -->
                        <div class="form-group">
                            <label for="menu_desc">Deskripsi Menu:</label>
                            <textarea class="form-control @error('menu_desc') is-invalid @enderror" name="menu_desc" id="menu_desc" rows="3" maxlength="35" placeholder="Max 35 karakter.">{{ old('menu_desc') }}</textarea>
                            @error('menu_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="min_order">Minimal Order</label>
                        <select class="form-control @error('min_order') is-invalid @enderror" id="min_order" name="min_order">
                            <option value="" selected>Pilih Minimal Order</option>
                            <option value="H-1">H-1</option>
                            <option value="H-2">H-2</option>
                            <option value="H-3">H-3</option>
                        </select>
                        @error('min_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Input makanan_1 sampai makanan_8 -->
                    <div id="makanan_prasmanan" style="display: none;">
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
                        <!-- Tambahkan input untuk makanan selanjutnya sesuai kebutuhan -->
                    </div>
                </div>
                <!-- /.card-body -->
        
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ route('data_menu_seller') }}" class="btn btn-primary">Kembali ke Daftar Menu</a>
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
    </div>
@endsection