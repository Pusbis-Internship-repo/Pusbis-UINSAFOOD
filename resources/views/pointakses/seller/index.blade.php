@extends('pointakses.seller.layouts.dashboard')
@section('content_seller')

<div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
    <div class="row mx-4">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{number_format($totalincome, 0, ',', '.')}}</h3>

                <p>Income</p>
              </div>
              <div class="icon">
                <i class="icon-moneybag"></i>
              </div>
              <a href="{{route('admin.orders')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $totalwaitorder }}</h3>
                <p>Pesanan diterima</p>
              </div>
              <div class="icon">
                <i class="icon-cart2"></i>
              </div>
              <a href="{{route('admin.history')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ $sellertotalmenus }}</h3>

                <p>Menu</p>
              </div>
              <div class="icon">
                <i class="icon-menu"></i>
              </div>
              <a href="{{route('datamenu')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row mx-4">
          <div class="col-12 bg-white rounded shadow">
            {!! $chart->container() !!}
          </div>
        </div>
      </div>
  </section>
</div>
</div>

<script src="{{ $chart->cdn() }}"></script>
        {{ $chart->script() }}
@include('pointakses.seller.include.sidebar_seller')
@endsection