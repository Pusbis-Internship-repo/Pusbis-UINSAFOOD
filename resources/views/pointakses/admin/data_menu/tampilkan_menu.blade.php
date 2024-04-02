@extends('pointakses.admin.layouts.dashboard')
@section('content')

    <div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
        <div class="content">
            <br>
            <a href="{{ route('createmenu') }}" class="btn btn-success">Tambah Menu</a>
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">DATA MENU</h3>

                        <div class="card-tools">
                            <form action="{{route('datamenu')}}" method="GET">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="search" name="search" class="form-control float-right"
                                        placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Gambar Menu</th>
                                    <th>Nama Menu</th>
                                    <th>Harga Menu</th>
                                    <th>Kategori</th>
                                    <th>Vendor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>M{{ $menu->id }}</td>
                                        <td class="text-center">
                                        <img src="{{ url('storage/menu_images/' . basename($menu->menu_pic)) }}" class="rounded" style="width: 150px">
                                        </td>
                                        <td>{{ $menu->menu_name }}</td>
                                        <td>{{ $menu->menu_price }}</td>
                                        <td>
                                            @if ($menu->category)
                                                {{ $menu->category->category_name }}
                                            @else
                                                No Category
                                            @endif
                                        </td>
                                        <td>
                                            {{ $menu->user->nama_lengkap}}
                                        <td>
                                            <a href="{{ route('deletemenu', ['id' => $menu->id]) }}" class="btn btn-danger"
                                                onclick="return confirmDelete('{{ $menu->id }}', '{{ $menu->menu_name }}');">
                                                Hapus
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('editmenu', $menu->id) }}" class="btn btn-info">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

    @include('pointakses.admin.include.sidebar_admin')
@endsection
