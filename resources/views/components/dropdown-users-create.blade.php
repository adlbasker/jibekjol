@if($users->count() > 0)
  <ul class="dropdown-menu show w-100 shadow mt-1">
    @foreach($users as $user)
      <li>
        <button
          type="button"
          class="dropdown-item track-user-option"
          data-user-id="{{ $user->id }}"
          data-user-label="ID: {{ $user->id_client }}. {{ $user->name }} {{ $user->lastname }}"
        >
          <span class="fw-semibold">ID: {{ $user->id_client }}</span>
          <span class="text-muted">{{ $user->name }} {{ $user->lastname }}</span>
        </button>
      </li>
    @endforeach
  </ul>
@endif
