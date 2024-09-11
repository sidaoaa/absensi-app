<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f0f2f5;
      overflow-x: hidden;
    }

    .sidebar {
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      background-color: #f8f9fa;
      border-right: 1px solid #dee2e6;
      transition: transform 0.3s ease, opacity 0.3s ease;
      z-index: 100;
    }

    .sidebar.collapsed {
      transform: translateX(-100%);
      opacity: 0;
    }

    .sidebar .nav-item {
      padding: 0.75rem 1.25rem;
    }

    .sidebar .nav-item:hover {
      background-color: #e9ecef;
    }

    .content {
      margin-left: 250px;
      padding-top: 80px;
      /* Disesuaikan untuk memberikan ruang di bawah navbar */
      transition: margin-left 0.3s ease;
    }

    .content.collapsed {
      margin-left: 0;
    }

    .navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 200;
    }

    .toggle-sidebar-btn {
      cursor: pointer;
      position: fixed;
      top: 10px;
      left: 10px;
      background-color: #fff;
      padding: 5px 10px;
      border-radius: 5px;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container-fluid">
      <span class="btn btn-outline-secondary me-2 toggle-sidebar-btn">
        <i class="fa-solid fa-bars me-2"></i>
      </span>
      <span class="navbar-brand mx-5">ABSENSI-APP</span>
      <div class="ms-auto d-flex align-items-center">
        <div class="dropdown">
          <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
            data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://www.366icons.com/media/01/profile-avatar-account-icon-16699.png" alt="User Image"
              class="rounded-circle" style="width: 32px; height: 32px;">
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><span class="dropdown-item-text">{{ Auth::user()->name }}</span></li>
            <li><span class="dropdown-item-text">{{ Auth::user()->email }}</span></li>
            <li><a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a></li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar">
    <ul class="nav flex-column mt-5">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.summary') }}">
          <i class="fa-solid fa-house-chimney me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterDataMenu" role="button"
          aria-expanded="false" aria-controls="masterDataMenu">
          <i class="fa-solid fa-database me-2"></i> Master Data
          <i class="fa-solid fa-chevron-right float-end"></i>
        </a>
        <div class="collapse" id="masterDataMenu">
          <ul class="nav flex-column ms-3">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.karyawan') }}">
                <i class="fa-solid fa-user me-2"></i> Karyawan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.in') }}">
                <i class="fa-solid fa-person-circle-check me-2"></i> Absen Masuk
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('admin.out') }}">
                <i class="fa-solid fa-person-circle-check me-2"></i> Absen Keluar
              </a>
            </li>
          </ul>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.report') }}">
          <i class="fa-solid fa-clipboard-check me-2"></i> Report
        </a>
      </li>
    </ul>
  </div>

  <!-- Alerts for success and danger messages -->
  @if (session('success'))
    <div class="alert alert-success" role="alert">
      <div class="container">
        {{ session('success') }}
      </div>
    </div>
  @endif

  @if (session('danger'))
    <div class="alert alert-danger" role="alert">
      <div class="container">
        {{ session('danger') }}
      </div>
    </div>
  @endif

  <!-- Main Content -->
  <div class="content">
    @yield('content')
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelector('.toggle-sidebar-btn').addEventListener('click', function() {
      document.querySelector('.sidebar').classList.toggle('collapsed');
      document.querySelector('.content').classList.toggle('collapsed');
    });
  </script>
</body>

</html>
