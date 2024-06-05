@extends('pointakses.admin.layouts.dashboard')'


@section('content')
<div class="content-wrapper iframe-mode" data-widget="iframe" data-loading-screen="750">
<div class="content">
<div class="col-12 mt-4">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">DATA PENGGUNA</h3>

        <div class="card-tools">
          <div class="input-group input-group-sm" style="width: 150px;">
            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

            <div class="input-group-append">
              <button type="submit" class="btn btn-default">
                <i class="fas fa-search"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>NO Telepon</th>
                <th>Unit Kerja</th>
                <th>Opsi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>{{ $user->no_tlp }}</td>
                <td>{{ $user->unit_kerja }}</td>
                <td><a href="{{route('deleteuser', $user->id)}}" class="btn btn-danger btn-sm" 
                  onclick="return confirm('Apakah yakin dihapus? {{ $user->nama_lengkap }}');">Hapus</a></td>
                <td><a href="{{route('edit.data.pengguna', $user->id)}}" class="btn btn-info btn-sm">Edit</a></td>
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
@include('pointakses.admin.include.sidebar_admin')>

@endsection
