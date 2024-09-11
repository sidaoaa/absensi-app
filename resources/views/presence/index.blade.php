@extends('layouts.appUser')
@include('layouts.navbar')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">Data Kehadiran</div>
      <div class="card-body">
        <table class="table table-border">

          <thead>
            <tr>
              <th>No</th>
              <th>Foto Masuk</th>
              <th>Waktu Masuk</th>
              <th>Info Masuk</th>
              <th>Foto Keluar</th>
              <th>Waktu Keluar</th>
              <th>Info Keluar</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($presences as $index => $item)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  <a href="{{ asset('storage/absensi/masuk/' . $item->in_image) }}">Lihat Foto</a>
                </td>
                <td>
                  {{ $item->in_time }}
                </td>
                <td>
                  {{ $item->in_info }}
                </td>
                @if ($item->out_time)
                  <td>
                    <a href="{{ asset('storage/absensi/keluar/' . $item->out_image) }}">Lihat Foto</a>
                  </td>
                  <td>
                    {{ $item->out_time }}
                  </td>
                  <td>
                    {{ $item->out_info }}
                  </td>
                @else
                  <td colspan="3">Masih Bekerja</td>
                @endif
              </tr>
            @endforeach
          </tbody>

        </table>
      </div>
    </div>
  </div>
@endsection
