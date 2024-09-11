<!DOCTYPE html>
<html>

<head>
  <title>Laporan Absen Masuk dan Keluar</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 20px;
      position: relative;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      border: 1px solid #dcdcdc;
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #6c63ff;
      color: #ffffff;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    tr:hover {
      background-color: #e9e9e9;
    }

    .total-row {
      font-weight: bold;
      background-color: #e2e2e2;
    }

    .total-row td {
      text-align: center;
    }

    button {
      background-color: #6c63ff;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      margin-right: 10px;
    }

    button:hover {
      background-color: #5d5d5d;
    }

    .btn-back {
      background-color: #6c63ff;
      color: #ffffff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      border-radius: 5px;
      margin-right: 10px;
    }

    .btn-back:hover {
      background-color: #5d5d5d;
    }

    form {
      margin-bottom: 20px;
      padding-top: 60px;
    }

    input[type="date"] {
      border: 1px solid #dcdcdc;
      padding: 8px;
      border-radius: 4px;
    }

    input[type="date"]:focus {
      border-color: #6c63ff;
      outline: none;
    }

    label {
      font-weight: bold;
    }

    p {
      font-size: 16px;
    }

    @media print {
      body {
        margin: 0;
        font-size: 12px;
      }

      table {
        width: 100%;
        border: 1px solid #dcdcdc;
        box-shadow: none;
      }

      th,
      td {
        border: 1px solid #dcdcdc;
        padding: 8px;
        text-align: left;
      }

      th {
        background-color: #6c63ff;
        color: #ffffff;
      }

      tr:nth-child(even) {
        background-color: #f2f2f2;
      }

      .total-row {
        font-weight: bold;
        background-color: #e2e2e2;
      }

      .total-row td {
        text-align: left;
      }

      button,
      form {
        display: none;
      }

      p {
        font-size: 12px;
      }
    }
  </style>
</head>

<body>
  <h1>Laporan Absen Masuk dan Keluar</h1>

  <!-- Form untuk memilih rentang tanggal -->
  <form action="{{ route('admin.report') }}" method="GET">
    <label for="start_date">Mulai Tanggal:</label>
    <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $start_date) }}" required>

    <label for="end_date">Sampai Tanggal:</label>
    <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $end_date) }}" required>

    <button type="submit">Tampilkan Laporan</button>
    <!-- Print Button -->
    <button type="button" onclick="printPage()">Print Laporan</button>

    <!-- Print Script -->
    <script>
      function printPage() {
        window.print();
      }
    </script>
  </form>

  <p>Rentang Tanggal: {{ $start_date }} s/d {{ $end_date }}</p>

  <!-- Tabel laporan absensi -->
  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Waktu Masuk</th>
        <th>Waktu Keluar</th>
        <th>Status Masuk</th>
        <th>Status Keluar</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($attendances as $attendance)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $attendance->user->name }}</td>
          <td>{{ $attendance->in_time }}</td>
          <td>{{ $attendance->out_time ?? 'Belum Keluar' }}</td>
          <td>{{ $attendance->in_info }}</td>
          <td>{{ $attendance->out_info ?? 'Belum Keluar' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6">Tidak ada data untuk rentang tanggal ini</td>
        </tr>
      @endforelse
      <tr class="total-row">
        <td colspan="5" style="text-align: center;">Total Absen Masuk</td>
        <td>{{ $summary['total_inpresent'] }}</td>
      </tr>
    </tbody>
  </table>
  <br>
  <!-- Back Button -->
  <a href="/admin" onclick="history.back()" class="btn-back text-decoration-none">Kembali</a>

</body>

</html>
