<link rel="stylesheet" href="{{ asset('frontend/css/style.c') }}">
<!-- Menu -->

<div class="menu" id="Menu">
    <h1><span>Menu</span></h1>
    
    @guest
    <form action="{{ route('menu') }}" method="GET">
        <div class="form-group" style="display: flex; ">
            <div style="max-width: 180px; margin-right: 6px;">
                <input type="search" name="search" class="form-control" placeholder="Cari makanan disini...">
            </div>
            <button type="submit" class="btn btn-default">
                <i class="icon-search"></i>
            </button>
        </div>
    </form>
    <form action="{{ route('filter.menu') }}" method="GET" style="display: flex;">
        <select name="category" id="category" class="form-control" style="max-width: 178px; margin-right: 6px;">
            <option value="">Select Category</option>
            @if($categories && count($categories) > 0)
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}</option>
                @endforeach
            @endif
        </select>
        <select name="seller" id="seller" class="form-control" style="max-width: 178px; margin-right: 6px;">
            <option value="">Select Seller</option>
            @if($sellers && count($sellers) > 0)
                @foreach($sellers as $seller)
                    <option value="{{ $seller->id }}" {{ request('seller') == $seller->id ? 'selected' : '' }}>
                    {{ $seller->nama_lengkap }}</option>
                @endforeach
            @endif
        </select>
        <button type="submit" class="btn btn-default">Filter</button>
    </form>
    @endguest
    @auth
    <form action="{{ route('menu_user') }}" method="GET">
        <div class="form-group" style="display: flex; ">
            <div style="max-width: 180px; margin-right: 6px;">
                <input type="search" name="search" class="form-control" placeholder="Cari disini..">
            </div>
            <button type="submit" class="btn btn-default">
                <i class="icon-search"></i>
            </button>
        </div>
    </form>
    
    <form action="{{ route('filter.menu.user') }}" method="GET" style="display: flex;">
        <select name="category" id="category" class="form-control" style="max-width: 178px; margin-right: 6px;">
            <option value="">Pilih Kategori</option>
            @if($categories && count($categories) > 0)
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}</option>
                @endforeach
            @endif
        </select>
        <select name="seller" id="seller" class="form-control" style="max-width: 178px; margin-right: 6px;">
            <option value="">Pilih Penjual</option>
            @if($sellers && count($sellers) > 0)
                @foreach($sellers as $seller)
                    <option value="{{ $seller->id }}" {{ request('seller') == $seller->id ? 'selected' : '' }}>
                    {{ $seller->nama_lengkap }}</option>
                @endforeach
            @endif
        </select>
        <button type="submit" class="btn btn-default">Filter</button>
    </form>
    @endauth


    <br>
    <br>

    <div class="menu_box">
        @foreach($menus as $menu)
        <div class="menu_card">
            <div class="menu_image">
                <img src="{{ url('storage/menu_images/' . basename($menu->menu_pic)) }}">
            </div>
            <div class="small_card">
                <a href="{{ route('addMenu.to.order', $menu->id) }}" class="add-to-cart" data-menu-id="{{ $menu->id }}">
                    <i class="icon-basket2"></i>
                </a>
            </div>
            <div class="menu_info">
            <h2>{{ $menu->menu_name }}</h2>
            @if ($menu->reviews->count() > 0)
            <div class="rating">
                @php
                    $averageRating = $menu->averageRating();
                    $fullStars = floor($averageRating);
                    $halfStar = $averageRating - $fullStars >= 0.5;
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $fullStars)
                        <i class="icon-star-full"></i>
                    @elseif ($i == $fullStars + 1 && $halfStar)
                        <i class="icon-star-half"></i>
                    @else
                        <i class="icon-star-empty"></i>
                    @endif
                @endfor
                <span>{{ number_format($menu->averageRating(), 1) }}</span>
            </div>
            @else
            <div class="rating">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="icon-star-empty"></i>
                @endfor
                <span>0</span>
            </div>
            @endif
            <p>{{ $menu->seller }}</p>
            <p>{{ $menu->menu_desc }}</p>
            <h3>Rp. {{ number_format($menu->menu_price, 0, ',', '.') }}</h3>
            <div class="menu_icon">
                <i class="icon-basket2"></i>
            </div>
            @auth
            <a href="{{ route('addMenu.to.order', $menu->id) }}" class="menu_btn">Order Now</a>   
            @endauth
            @guest
            <a href="{{ route('auth') }}" class="menu_btn">Order Now</a> 
            @endguest
        </div>
        </div>
        @endforeach
    </div>
</div>