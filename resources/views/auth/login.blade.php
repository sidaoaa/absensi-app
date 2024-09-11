<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Custom CSS -->
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Nunito', sans-serif;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%
    }

    .card {
      border: none;
      border-radius: 10px;
      width: 40%;
    }

    .card-header {
      background-color: #6c63ff;
      color: white;
      font-weight: 600;
      padding: 12px;
      border-radius: 10px 10px 0 0;
    }

    .form-control {
      border: 1px solid #ced4da;
      border-radius: 5px;
      transition: box-shadow 0.3s;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
      background-color: #6c63ff;
      transition: background-color 0.3s;
    }

    .btn-primary:hover {
      background-color: #6c63ff;
      transition: background-color 0.3s;

    }

    input[type='password']::-ms-reveal {
      display: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="card shadow-lg">
      <div class="card-header text-center">{{ __('LOGIN') }}</div>

      <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label text-md-end">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
              name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
          <div class="mb-3">
            <label for="password" class="form-label  text-md-end">Password</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
              placeholder="Password" autocomplete="new-password" name="password">
            <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"
              style="position: absolute; right: 25px; top: 66%; transform: translateY(15%); cursor: pointer;"></span>
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror

          </div>
          <div class="d-grid">
            <button type="submit" class="btn btn-primary">
              {{ __('Login') }}
            </button>
          </div>
      </div>
    </div>
    </form>
  </div>
  </div>
</body>
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

</html>
