@extends('layouts.appUser')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header d-flex justify-content-between">
            <a href="/presence" onclick="history.back()" class="btn btn-secondary">Kembali</a>
            <span id="clock"></span>
          </div>
          <div class="card-body">
            {{-- camera --}}
            <div class="m-auto" id='my_camera'></div>
            {{-- hasil capture --}}
            <center>
              <div id="result" class="my-3"></div>
            </center>
            {{-- btn capture --}}
            <div class="d-grid my-3">
              <button class="btn btn-primary" onClick="take_snapshot()">Ambil Foto</button>
            </div>
            {{-- form --}}
            <form action="{{ route('presence.out_store') }}" method="post">
              @csrf
              {{-- url --}}
              <input type="hidden" class="image-tag" name="image">

              {{-- map --}}
              <div id="map" style="height: 400px;"></div>
              <!-- Tombol untuk ambil lokasi -->
              <div class="d-grid my-3">
                <button type="button" class="btn btn-primary" onclick="getLocation()">Ambil Lokasi</button>
              </div>

              {{-- Input lokasi tersembunyi --}}
              <input type="hidden" id="out_location" name="out_location">

              {{-- submit --}}
              <div class="d-grid">
                <button id="submitBtn" class="btn btn-danger" disabled>Absen</button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{-- jQuery CDN --}}
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  {{-- WebcamJS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
    integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  {{-- LeafletJS --}}
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  {{-- Webcam dan peta --}}
  <script>
    // Webcam setup
    Webcam.set({
      width: 320,
      height: 240,
      image_format: 'jpeg',
      jpeg_quality: 90
    });
    Webcam.attach('#my_camera');

    // Inisialisasi peta Leaflet
    var map = L.map('map').setView([-6.281859, 106.575034], 16); // Koordinat perusahaan dan zoom level
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
    }).addTo(map);
    var companyLocation = L.marker([-6.281859, 106.575034]).addTo(map).bindPopup("Lokasi Perusahaan").openPopup();

    // Ambil lokasi pengguna
    // Ambil lokasi pengguna
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    // Tampilkan lokasi pengguna
    function showPosition(position) {
      var userLat = position.coords.latitude;
      var userLng = position.coords.longitude;

      // Simpan nilai koordinat ke dalam input tersembunyi
      document.getElementById('out_location').value = userLat + ',' + userLng;

      // Lakukan validasi jarak dari lokasi perusahaan
      var companyLatLng = L.latLng(-6.281859, 106.575034); // Koordinat perusahaan
      var userLatLng = L.latLng(userLat, userLng); // Koordinat pengguna
      var distance = companyLatLng.distanceTo(userLatLng); // Hitung jarak

      if (distance <= 100) {
        // Lokasi pengguna valid, izinkan untuk absen
        alert("Anda berada di dalam radius 100 meter dari perusahaan.");
        // Aktifkan tombol "Masuk"
        document.getElementById("submitBtn").disabled = false;
      } else {
        // Lokasi pengguna di luar radius, beri notifikasi atau blokir absen
        alert("Maaf, Anda harus berada di dalam radius 100 meter dari perusahaan untuk melakukan absensi.");
        // Nonaktifkan tombol "Masuk"
        document.getElementById("submitBtn").disabled = true;
      }
    }
    // Fungsi ambil snapshot foto
    function take_snapshot() {
      Webcam.snap(function(data_uri) {
        // Masukkan URL gambar ke input hidden
        $(".image-tag").val(data_uri);
        // Tampilkan gambar hasil snapshot
        document.getElementById('result').innerHTML = '<img class="img-fluid" src="' + data_uri + '" alt="gambar">';
      });
    }

    // Timer untuk jam digital
    var myVar = setInterval(function() {
      myTimer();
    }, 1000);

    function myTimer() {
      var d = new Date();
      document.getElementById("clock").innerHTML = d.toLocaleTimeString();
    }
  </script>
@endpush
