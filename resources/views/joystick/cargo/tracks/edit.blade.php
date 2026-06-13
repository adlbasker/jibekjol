@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <p class="text-end">
    <a href="/{{ $lang }}/admin/tracks" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </p>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="/{{ $lang }}/admin/tracks/{{ $track->id }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            {!! csrf_field() !!}
            <div class="mb-3">
              <label for="user_id" class="form-label">Пользователь</label>
              @if($track->user)
                <div class="input-group">
                  <input type="text" class="form-control" id="user_id" name="user_id" value="{{ $track->user->name . ' ' . $track->user->lastname }}" disabled>
                  <a href="/{{ $lang }}/admin/tracks/{{ $track->id }}/unpin-user" class="btn btn-outline-secondary"><span class="material-icons" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Открепить пользователя">close</span></a>
                </div>
              @else
                <div class="position-relative">
                  <input type="text" class="form-control" id="user_id" name="text"
                    placeholder="Поиск пользователя"
                    autocomplete="off"
                    hx-get="/{{ $lang }}/admin/tracks/{{ $track->id }}/search/users"
                    hx-trigger="keyup changed delay:500ms"
                    hx-target="#dropdown-users">

                  <div id="dropdown-users" class="position-absolute top-100 start-0 w-100 z-3"></div>
                </div>
              @endif
            </div>
            <div class="mb-3">
              <label for="code" class="form-label">Трек код</label>
              <input type="text" class="form-control" id="code" name="code" maxlength="80" value="{{ (old('code')) ? old('code') : $track->code }}" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Описание</label>
              <input type="text" class="form-control" id="description" name="description" maxlength="80" value="{{ (old('description')) ? old('description') : $track->description }}">
            </div>
            <div class="mb-3">
              <label for="updated_at" class="form-label">Дата</label>
              <input type="text" class="form-control" id="updated_at" name="updated_at" maxlength="80" value="{{ (old('updated_at')) ? old('updated_at') : $track->updated_at }}" disabled>
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                <option value=""></option>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" @if($language->slug == $track->lang) selected @endif>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Статус</label>
              <select id="status" name="status" class="form-select" required>
                @foreach($statuses as $status)
                  <option value="{{ $status->id }}" @if($status->id == $track->status) selected @endif>{{ $status->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <?php $regionId = $track->statuses->last()->pivot->region_id; ?>
              <label for="region_id" class="form-label">Регионы</label>
              <select id="region_id" name="region_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $regionId) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}" <?= ($node->id == $regionId) ? 'selected' : ''; ?>>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
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
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
      new bootstrap.Tooltip(el);
    });
  </script>
@endsection