@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/users" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">Основная информация</div>
        <div class="card-body">
          <form method="POST" action="/{{ $lang }}/admin/users/password/{{ $user->id }}">
            @method('PUT')
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">{{ __('E-Mail') }}</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autofocus>

              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">{{ __('Password') }}</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>

              @error('password')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
