@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/categories" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('categories.store', $lang) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
              <label for="title_extra" class="form-label">Название дополнительное</label>
              <input type="text" class="form-control" id="title_extra" name="title_extra" minlength="2" maxlength="80" value="{{ old('title_extra') }}">
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ old('slug') }}">
            </div>
            <div class="mb-3">
              <label for="category_id" class="form-label">Категории</label>
              <select id="category_id" name="category_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $__env) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($categories); ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Картинка</label>
              <div class="input-group">
                <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#filemanager"><i class="material-icons align-middle">folder</i> Выбрать</button>
                <input type="text" class="form-control" id="image" name="image" value="{{ old('image') }}">
              </div>
              <!-- Filemanager -->
              <div class="modal fade" id="filemanager" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="myModalLabel">Файловый менеджер</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <iframe src="{{ url($lang.'/admin/frame-filemanager') }}" frameborder="0" style="width:100%;min-height:600px"></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ old('sort_id', 0) }}">
            </div>
            <div class="mb-3">
              <label for="meta_title" class="form-label">Мета заголовок</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title') }}">
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Мета описание</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ old('meta_description') }}">
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" {{ old('lang') == $language->slug ? 'selected' : '' }}>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label d-block">Статус</label>
              @foreach(trans('statuses.data') as $num => $status)
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="status" id="status{{ $num }}" value="{{ $num }}" {{ $num == 1 ? 'checked' : '' }}>
                  <label class="form-check-label" for="status{{ $num }}">
                    {{ $status['title'] }}
                  </label>
                </div>
              @endforeach
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
