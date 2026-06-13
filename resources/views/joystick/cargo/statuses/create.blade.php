@extends('joystick.layout')


@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <p class="text-end">
    <a href="/{{ $lang }}/admin/statuses" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </p>
  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('statuses.store', $lang) }}" method="post">
            {!! csrf_field() !!}
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ (old('title')) ? old('title') : '' }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" maxlength="80" value="{{ (old('slug')) ? old('slug') : '' }}">
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Порядковый номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="80" value="{{ (old('sort_id')) ? old('sort_id') : '' }}">
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                @foreach($languages as $language)
                  @if (old('lang') == $language->slug)
                    <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
                  @else
                    <option value="{{ $language->slug }}">{{ $language->title }}</option>
                  @endif
                @endforeach
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
