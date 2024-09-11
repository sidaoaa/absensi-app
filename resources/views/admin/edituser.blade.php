@extends('layouts.app')
@include('layouts.sidebar')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Edit Pengguna</div>

          <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
              @csrf
              @method('PUT')

              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Nama</label>

                <div class="col-md-6">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>

                  @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div></br>


              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">

                  @error('email')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              </br>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" autocomplete="new-password">

                  <span toggle="#password" class="fa fa-fw fa-eye-slash field-icon toggle-password"
                    style="position: absolute; right: 140px; top: 51%; transform: translateY(15%); cursor: pointer;"></span>

                  @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div></br>

              <div class="form-group row">
                <label for="type" class="col-md-4 col-form-label text-md-right">Role</label>

                <div class="col-md-6">
                  <select id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                    <option value="2" {{ $user->type == 2 ? 'selected' : '' }}>Admin</option>
                    <option value="1" {{ $user->type == 1 ? 'selected' : '' }}>User</option>
                  </select>

                  @error('type')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror


                  @error('type')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div></br>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
