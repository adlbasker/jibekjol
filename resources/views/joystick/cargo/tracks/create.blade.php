@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <p class="text-end">
    <a href="/{{ $lang }}/admin/tracks" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </p>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('tracks.store', $lang) }}" method="post">
            {!! csrf_field() !!}
            <div class="mb-3">
              <label for="user_search" class="form-label">Пользователь</label>
              <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id') }}">
              <div class="position-relative">
                <input
                  type="text"
                  class="form-control"
                  id="user_search"
                  name="text"
                  placeholder="Поиск пользователя"
                  autocomplete="off"
                  hx-get="/{{ $lang }}/admin/tracks/search/users"
                  hx-trigger="keyup changed delay:500ms"
                  hx-target="#dropdown-users">

                <div id="dropdown-users" class="position-absolute top-100 start-0 w-100 z-3"></div>
              </div>
            </div>
            <div class="mb-3">
              <label for="code" class="form-label">Трек код</label>
              <input type="text" class="form-control" id="code" name="code" maxlength="80" value="{{ (old('code')) ? old('code') : '' }}" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Описание</label>
              <input type="text" class="form-control" id="description" name="description" maxlength="80" value="{{ (old('description')) ? old('description') : '' }}">
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" @if($language->slug == $lang) selected @endif>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Статус</label>
              <select id="status" name="status" class="form-select" required>
                @foreach($statuses as $status)
                  <option value="{{ $status->id }}" @if(old('status') == $status->id) selected @endif>{{ $status->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="region_id" class="form-label">Регионы</label>
              <select id="region_id" name="region_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($regions); ?>
              </select>
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-success"><i class="material-icons">save</i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  <script>
    document.getElementById('dropdown-users')?.addEventListener('click', (event) => {
      const option = event.target.closest('.track-user-option');
      if (!option) {
        return;
      }

      document.getElementById('user_id').value = option.dataset.userId;
      document.getElementById('user_search').value = option.dataset.userLabel;
      document.getElementById('dropdown-users').innerHTML = '';
    });
  </script>
@endsection
