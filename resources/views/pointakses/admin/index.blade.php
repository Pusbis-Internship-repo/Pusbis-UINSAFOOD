@extends('pointakses.admin.layouts.dashboard')
@section('content')
    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalsellers }}</h3>

                                <p>Vendor</p>
                            </div>
                            <div class="icon">
                                <i class="icon-users5"></i>
                            </div>
                            <a href="{{ route('dataseller') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalPendingOrders }}</h3>
                                <p>Pesanan menunggu</p>
                            </div>
                            <div class="icon">
                                <i class="icon-moneybag"></i>
                            </div>
                            <a href="{{ route('admin.orders') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $totalAcceptedOrders }}</h3>
                                <p>Pesanan diterima</p>
                            </div>
                            <div class="icon">
                                <i class="icon-cart2"></i>
                            </div>
                            <a href="{{ route('admin.history') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totalmenus }}</h3>

                                <p>Menu</p>
                            </div>
                            <div class="icon">
                                <i class="icon-menu"></i>
                            </div>
                            <a href="{{ route('datamenu') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
            </div>

            <div class="container px-4 mx-auto">

                <div class="p-6 m-20 bg-white rounded shadow">
                    {!! $chart->container() !!}
                </div>

            </div>
        </section>



        <script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}

        @include('pointakses.admin.include.sidebar_admin')
    @endsection
