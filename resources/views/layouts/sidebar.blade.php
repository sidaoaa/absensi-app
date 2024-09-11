{{-- <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
  <div class="container-fluid">
    <button class="btn btn-outline-secondary me-2 " type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">
      <i class="fa-solid fa-list-check me-2"></i>
    </button>
    <span class="navbar-brand">
      <i class=""></i> ABSENSI-APP
    </span>
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
<div class="offcanvas offcanvas-start sidebar" tabindex="-1" id="sidebar">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title"><i class="fa-solid fa-list-check me-2"></i> ABSENSI-APP</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.summary') }}">
          <i class="fa-solid fa-house-chimney me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#masterDataMenu" role="button"
          aria-expanded="false" aria-controls="masterDataMenu">
          <i class="fa-solid fa-database me-2"></i> Master Data
          <i class="fa-solid fa-chevron-down float-end"></i>
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
  </div>
  </li>
  </ul>
</div>
</div> --}}
