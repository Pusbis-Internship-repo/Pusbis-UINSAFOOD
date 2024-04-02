<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text font-weight-light">Seller Controller</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('frontend/images/favicon.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <span>
                    <a href="{{route('selleredit')}}" class="d-block"> {{ Auth::user()->nama_lengkap }}</a>
                </span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                <li class="nav-item">
                    <span>
                        <a href="{{ route('seller') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </span>
                </li>
                <li class="nav-item">
                    <span>
                        <a href="{{route('data_menu_seller')}}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Menu
                            </p>
                        </a>
                    </span>
                </li>
                <li class="nav-item">
                    <span>
                        <a href="{{ route('seller.orders') }}" class="nav-link">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Pesanan
                            </p>
                        </a>
                    </span>
                </li>

                <!-- Control Sidebar -->
                <aside class="control-sidebar control-sidebar-dark">
                    <!-- Control sidebar content goes here -->
                </aside>