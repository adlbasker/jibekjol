@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/options" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('options.store', $lang) }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" maxlength="80" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" maxlength="80" value="{{ old('slug') }}">
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ old('sort_id') }}">
            </div>
            <div class="mb-3">
              <label for="data" class="form-label">Группа</label>
              <input type="text" class="form-control" id="data" name="data" value="{{ old('data') }}">
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" @if(old('lang') == $language->slug) selected @endif>{{ $language->title }}</option>
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
