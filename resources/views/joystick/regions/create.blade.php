@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Создание</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/regions" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card mb-3">
        <div class="card-body">
          <form action="{{ route('regions.store', $lang) }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ old('slug') }}">
            </div>
            <div class="mb-3">
              <label for="region_id" class="form-label">Регионы</label>
              <select id="region_id" name="region_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}">{{ $prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($regions); ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ old('sort_id') }}">
            </div>
            <div class="mb-3">
              <label for="data" class="form-label">Группа</label>
              <input type="text" class="form-control" id="data" name="data" value="{{ old('data') }}">
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" @if (old('lang') == $language->slug) selected @endif>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" checked>
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
