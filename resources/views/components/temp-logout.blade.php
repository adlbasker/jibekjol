  <div class="flex-shrink-0 dropdown ms-md-auto ps-3">
    <a href="#" class="d-block link-light text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="bi bi-person-circle fs-4 text-white"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end text-small shadow">
      <div class="text-muted px-3 py-1">{{ Auth::user()->name . ' ' . Auth::user()->lastname }}</div>
      <li><hr class="dropdown-divider"></li>
      <li>
        <form method="POST" action="/{{ $lang }}/logout">
          @csrf
          <a class="dropdown-item py-2" href="#" onclick="event.preventDefault(); this.closest('form').submit();">{{ __('app.logout_btn') }}</a>
        </form>
      </li>
    </ul>
  </div>