@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/pages" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-10">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('pages.store', $lang) }}" method="post" id="postForm">
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" maxlength="80" value="{{ old('slug') }}">
            </div>
            <div class="mb-3">
              <label for="keywords" class="form-label">Keywords</label>
              <input type="text" class="form-control" id="keywords" name="keywords" maxlength="80" value="{{ old('keywords') }}">
            </div>
            <div class="mb-3">
              <label for="page_id" class="form-label">Иерархия</label>
              <select id="page_id" name="page_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $__env) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($pages); ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Картинка</label>
              <div class="input-group">
                <button class="btn btn-outline-dark" type="button" data-bs-toggle="modal" data-bs-target="#filemanager"><i class="material-icons">folder</i> Выбрать</button>
                <input type="text" class="form-control" id="image" name="image" minlength="2" maxlength="80" value="{{ old('image') }}">
              </div>

              <!-- Filemanager -->
              <div class="modal fade" id="filemanager" tabindex="-1" aria-labelledby="filemanagerLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="filemanagerLabel">Файловый менеджер</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <iframe src="<?= url($lang.'/admin/frame-filemanager'); ?>" frameborder="0" style="width:100%;min-height:600px"></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ old('sort_id') }}">
            </div>
            <div class="mb-3">
              <label for="meta_title" class="form-label">Мета название (краткий заголовок, который отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title') }}">
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Мета описание (краткое описание страницы, которое отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ old('meta_description') }}">
            </div>
            <div class="mb-3">
              <label for="content" class="form-label">Контент</label>
              <div>
                @include('components.bootstrap-5-editor', ['attribute' => 'content', 'content' => old('content')])
              </div>
            </div>
            <div class="mb-3">
              <label for="text" class="form-label">Дополнительный текст</label>
              <input type="text" class="form-control" id="text" name="text" maxlength="255" value="{{ old('text') }}">
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

@section('scripts')
  <script src="/joystick/js/bootstrap5editor.js"></script>
@endsection
