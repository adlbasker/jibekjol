@if($users->count() > 0)
  <ul class="dropdown-menu show w-100 shadow mt-1">
    @foreach($users as $user)
      <li>
        <a class="dropdown-item" href="/{{ $lang }}/admin/tracks/{{ $trackId }}/pin-user/{{ $user->id }}">
          <span class="fw-semibold">ID: {{ $user->id_client }}</span>
          <span class="text-muted">{{ $user->name }} {{ $user->lastname }}</span>
        </a>
      </li>
    @endforeach
  </ul>
@endif
