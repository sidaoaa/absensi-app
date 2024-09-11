@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
  <div class="card mb-3">
    <div class="card-header">Ringkasan</div>
    <div class="card-body">
      <p>Total Absen Masuk: {{ $summary['total_inpresent'] }}</p>
    </div>
  </div>

  <div class="card mb-3">
    <div class="card-header">Absen Masuk</div>
    <div class="card-body">
      <form action="{{ route('admin.in') }}" method="GET" class="mb-3">
        <label for="filter">Filter berdasarkan:</label>
        <select name="filter" id="filter" onchange="this.form.submit()">
          <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Hari Ini</option>
          <option value="weekly" {{ request('filter') == 'weekly' ? 'selected' : '' }}>Minggu Ini</option>
          <option value="monthly" {{ request('filter') == 'monthly' ? 'selected' : '' }}>Bulan Ini</option>
        </select>
      </form>

      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Nama</th>
              <th>Waktu Masuk</th>
              <th>Status</th>
              <th>Lokasi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($attendances as $attendance)
              <tr>
                <td>{{ $attendance->user->name }}</td>
                <td>{{ $attendance->in_time }}</td>
                <td>{{ $attendance->in_info }}</td>
                <td>{{ $attendance->in_location }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
