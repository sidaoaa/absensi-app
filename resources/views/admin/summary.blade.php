@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
  <style>
    #attendanceChart {
      width: 90% !important;
      height: 50% !important;
    }
  </style>

  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="card mb-3">
          <div class="card-header">Overview</div>
          <div class="card-body">
            <p>Total Employees: {{ $summary['total_employees'] }}</p>
            <p>Total Attendance: {{ $summary['total_present'] }}</p>
          </div>
        </div>
        <select id="modeSelector" class="form-select">
          <option value="in">Status Masuk</option>
          <option value="out">Status Keluar</option>
        </select>
        </br>
        <canvas id="attendanceChart"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
          var ctx = document.getElementById('attendanceChart').getContext('2d');
          var mode = 'in'; // Default mode

          // Data dan label untuk kedua mode
          var inData = [{{ $summary['on_time_in'] }}, {{ $summary['late_in'] }}];
          var outData = [{{ $summary['on_time_out'] }}, {{ $summary['late_out'] }}];

          // Function untuk memperbarui chart dengan label yang sesuai
          function updateChart() {
            var data = (mode === 'in') ? inData : outData;
            var labels = (mode === 'in') ? ['On Time', 'Late'] : ['Tepat', 'Bolos'];
            attendanceChart.data.datasets[0].data = data;
            attendanceChart.data.labels = labels;
            attendanceChart.update();
          }

          // Inisialisasi chart
          var attendanceChart = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: ['Tepat', 'Telat'], // Default labels for "Masuk"
              datasets: [{
                data: inData,
                backgroundColor: [
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                  'rgba(75, 192, 192, 1)',
                  'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              plugins: {
                legend: {
                  position: 'top',
                },
                tooltip: {
                  callbacks: {
                    label: function(tooltipItem) {
                      return tooltipItem.label + ': ' + tooltipItem.raw + ' employees';
                    }
                  }
                }
              }
            }
          });

          // Event listener untuk dropdown mode
          document.getElementById('modeSelector').addEventListener('change', function() {
            mode = this.value;
            updateChart();
          });
        </script>


      </div>

      <div class="col-md-8">
        <div class="card mb-3">
          <div class="card-header">Recent Activity</div>
          <div class="card-body h-100">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Employee Name</th>
                    <th>Masuk</th>
                    <th>Keluar</th>
                  </tr>
                </thead>
                <tbody>
                  @if ($recentActivities->isEmpty())
                    <tr>
                      <td colspan="3">No recent activities.</td>
                    </tr>
                  @else
                    @foreach ($recentActivities as $activity)
                      <tr>
                        <td>{{ $activity->user->name }}</td>
                        <td>{{ ucfirst($activity->in_info) }}</td>
                        <td>{{ ucfirst($activity->out_info) }}</td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <script>
        // Refresh data every 24 hours
        setInterval(function() {
          location.reload();
        }, 86400000); // 24 hours in milliseconds
      </script>



    </div>
  </div>

  </div>
  </div>
@endsection
