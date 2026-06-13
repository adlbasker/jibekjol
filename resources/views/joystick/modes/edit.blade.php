@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-6 mb-2">
      <ul class="nav nav-tabs">
        @foreach ($languages as $language)
          <li class="nav-item">
            <a class="nav-link @if ($language->slug == $lang) active @endif" href="/{{ $language->slug }}/admin/modes/{{ $mode->id }}/edit">{{ $language->title }}</a>
          </li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-6 text-end">
      <a href="/{{ $lang }}/admin/modes" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('modes.update', [$lang, $mode->id]) }}" method="post">
            @method('PUT')
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <?php $titles = unserialize($mode->title); ?>
              <input type="text" class="form-control" id="title" name="title" maxlength="80" value="{{ old('title', $titles[$lang]['title']) }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" maxlength="80" value="{{ old('slug', $mode->slug) }}">
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ old('sort_id', $mode->sort_id) }}">
            </div>
            <div class="mb-3">
              <label for="data" class="form-label">Данные</label>
              <input type="text" class="form-control" id="data" name="data" value="{{ old('data', $mode->data) }}">
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
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" @if ($mode->status == 1) checked @endif>
                <label class="form-check-label" for="status">Активен</label>
              </div>
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
