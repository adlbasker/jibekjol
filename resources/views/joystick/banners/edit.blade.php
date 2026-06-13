@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/banners" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('banners.update', [$lang, $banner->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label for="marketing" class="form-label">Заголовок (Маркетинг)</label>
              <input type="text" class="form-control" id="marketing" name="marketing" minlength="2" maxlength="80" value="{{ old('marketing', $banner->marketing) }}">
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Подзаголовок</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ old('title', $banner->title) }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ old('slug', $banner->slug) }}">
            </div>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label for="color" class="form-label">Цвет текста</label>
                <input type="color" class="form-control form-control-color w-100" id="color" name="color" value="{{ old('color', $banner->color) }}">
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label d-block">Позиция текста</label>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="direction" id="directionLeft" value="left" {{ $banner->direction == 'left' ? 'checked' : '' }}>
                  <label class="form-check-label" for="directionLeft">По левой стороне</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="direction" id="directionRight" value="right" {{ $banner->direction == 'right' ? 'checked' : '' }}>
                  <label class="form-check-label" for="directionRight">По правой стороне</label>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Позиция фона в процентах</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ old('sort_id', $banner->sort_id) }}">
            </div>
            <div class="mb-3">
              <label for="link" class="form-label">Ссылка на продукт</label>
              <div class="input-group">
                <span class="input-group-text" id="basic-addon3">{{ $_SERVER['SERVER_NAME'] }}/</span>
                <input type="text" name="link" class="form-control" id="link" aria-describedby="basic-addon3" maxlength="255" value="{{ old('link', $banner->link) }}">
              </div>
            </div>
            <div class="mb-3" id="banner">
              <label for="image" class="form-label">Фон</label><br>
              <input type="file" class="form-control image-input" name="image" accept="image/*" data-preview="preview">
              <div class="my-2">
                <img id="preview" src="/img/banners/{{ $banner->image }}" class="img-fluid border" style="width: auto; max-height: 260px;">
              </div>
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                <option value=""></option>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" {{ $banner->lang == $language->slug ? 'selected' : '' }}>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" {{ $banner->status == 1 ? 'checked' : '' }}>
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

@section('head')

@endsection

@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const banner = document.getElementById('banner');
      if (!banner) return;
      banner.addEventListener('change', function (e) {
        const input = e.target.closest('.image-input');
        if (!input) return;
        const file = input.files && input.files[0] ? input.files[0] : null;
        const previewId = input.dataset.preview;
        const previewImg = previewId ? document.getElementById(previewId) : null;
        if (!previewImg) return;
        if (file && file.type && file.type.startsWith('image/')) {
          const reader = new FileReader();
          reader.onload = function (evt) {
            previewImg.src = evt.target.result;
          };
          reader.readAsDataURL(file);
        } else {
          previewImg.src = '/joystick/no-image-middle.png';
        }
      });
    });

  </script>
@endsection
