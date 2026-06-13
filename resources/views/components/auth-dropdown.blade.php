@guest
  <a href="/{{ $lang }}/login" class="btn btn-light btn-lg me-2">{{ __('app.login_btn') }}</a>
  <a href="/{{ $lang }}/register" class="btn btn-warning btn-lg">{{ __('app.register_btn') }}</a>
@else
  <form method="POST" action="/{{ $lang }}/logout" class="btn btn-outline-light ms-md-auto ms-3 mt-1">
    @csrf
    <a class="dropdown-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('app.logout_btn') }}</a>
  </form>
@endguest