@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
  <div class="card mb-3">
    <div class="card-header">Ringkasan</div>
    <div class="card-body">
      <p>Total Karyawan: {{ $summary['total_employees'] }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
      Karyawan
      <a href="{{ route('admin.createuser') }}" class="btn btn-primary">Tambah Akun</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Email</th>
              <th>Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($employees as $employee)
              <tr>
                <td>{{ $employee->name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->type }}</td>
                <td>
                  <a href="{{ route('admin.edituser', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>

                  <form action="{{ route('admin.users.destroy', $employee->id) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                      onclick="return confirm('Anda yakin ingin menghapus pengguna ini?')">Hapus</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
