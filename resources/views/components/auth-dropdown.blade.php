@guest
  <a href="/{{ $lang }}/login" class="btn btn-light btn-lg me-2">{{ __('app.login_btn') }}</a>
  <a href="/{{ $lang }}/register" class="btn btn-warning btn-lg">{{ __('app.register_btn') }}</a>
@else
  <ul class="navbar-nav ms-auto">
    <!-- <li class="nav-item">
      <a class="nav-link link-body-emphasis px-3" href="/{{ $lang }}/market/cart" aria-current="page"><i class="bi bi-cart"></i> {{ __('Cart') }}</a>
    </li> -->
    <li class="nav-item">
      <form method="POST" action="/{{ $lang }}/logout">
        @csrf
        <a class="nav-link link-body-emphasis px-3" style="color: rgb(255 255 255 / 80%);" href="#" onclick="event.preventDefault(); this.closest('form').submit();"><i class="bi bi-box-arrow-right"></i> {{ __('app.logout_btn') }}</a>
      </form>
    </li>
  </ul>
@endguest