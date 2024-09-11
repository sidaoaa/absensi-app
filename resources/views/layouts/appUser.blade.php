<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Scripts -->
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <!-- Leaflet JavaScript -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Custom CSS -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <style>
    .navbar-custom-user,
    .navbar-custom-admin {
      background-color: #6c63ff;
    }

    .navbar-custom-user .navbar-brand,
    .navbar-custom-user .nav-link,
    .navbar-custom-user .navbar-toggler-icon,
    .navbar-custom-admin .navbar-brand,
    .navbar-custom-admin .nav-link,
    .navbar-custom-admin .navbar-toggler-icon {
      color: #ffffff;
    }

    .navbar-custom-user .nav-link:hover,
    .navbar-custom-admin .nav-link:hover {
      color: #5d5d5d;
    }

    .dropdown-menu-end {
      background-color: #6c63ff;
    }

    .dropdown-menu-end .dropdown-item {
      color: #ffffff;
    }

    .dropdown-menu-end .dropdown-item:hover {
      background-color: #5d5d5d;
      color: #ffffff;
    }

    input[type='password']::-ms-reveal {
      display: none;
    }
  </style>

</head>

<body>
  <div id="app">

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
    </br>
    </br>




    <!-- Main content -->
    <main class="col-md-9 mx-auto col-lg-10 px-md-5 d-flex justify-content-center align-items-start vh-100">

      @yield('content')
    </main>



  </div>
  </div>

  <!-- Additional scripts -->
  @stack('js')
  <script>
    document.querySelector('.toggle-password').addEventListener('click', function() {
      const passwordInput = document.querySelector(this.getAttribute('toggle'));
      this.classList.toggle('fa-eye-slash');
      this.classList.toggle('fa-eye');

      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    });
  </script>
  </div>
</body>

</html>
