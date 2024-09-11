@extends('layouts.app')

@section('content')
  <div class="container">
    <h5><b>Dashboard</b></h5>
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-header">Overview</div>
          <div class="card-body">
            <p>Total Employees: {{ $summary['total_employees'] }}</p>
            <p>Total Attendance: {{ $summary['total_attendance'] }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">Recent Activity</div>
          <div class="card-body">
            <!-- Recent activity table or list -->
          </div>
        </div>
      </div>
    </div>
    <div class="card mb-3">
      <div class="card-header">Monthly Statistics</div>
      <div class="card-body">
        <!-- Charts or graphs for monthly statistics -->
      </div>
    </div>
  </div>
  {{-- Chart --}}
  <div class="bg-white shadow-none drop-shadow-lg rounded-xl mt-5">
    <canvas id="transactionsChart" class="w-full h-full"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var ctx = document.getElementById('transactionsChart').getContext('2d');
      var months = {!! json_encode($months) !!};
      var transactionData = {!! json_encode($transactionData) !!};

      var transactionsChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: months,
          datasets: [{
            label: 'Jumlah Transaksi per Bulan',
            data: transactionData,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              precision: 0
            }
          }
        }
      });
    });
  </script>
@endsection
