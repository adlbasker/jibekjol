@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/posts" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-9">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('posts.update', [$lang, $post->id]) }}" method="post" id="postForm" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ old('title', $post->title) }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">URI</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ old('slug', $post->slug) }}">
            </div>
            <div class="mb-3">
              <label for="category_id" class="form-label">Категории</label>
              <select id="category_id" name="category_id" class="form-select" required>
                <option value="NULL"></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $post, $__env) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}" @if($node->id == $post->category_id) selected @endif>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($categories); ?>
              </select>
            </div>
            <div class="mb-3" id="banner">
              <label for="image" class="form-label">Фон</label><br>
              <input type="file" class="form-control image-input" name="image" accept="image/*" data-preview="preview">
              <div class="my-2">
                <img id="preview" src="/img/posts/{{ $post->image }}" class="img-fluid border" style="width: auto; max-height: 260px;">
              </div>
            </div>
            <div class="mb-3">
              <label for="headline" class="form-label">Заголовок</label>
              <input type="text" class="form-control" id="headline" name="headline" minlength="2" maxlength="500" value="{{ old('headline', $post->headline) }}">
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ old('sort_id', $post->sort_id) }}">
            </div>
            <div class="mb-3">
              <label for="meta_title" class="form-label">Мета название (краткий заголовок, который отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $post->meta_title) }}" required>
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Мета описание (краткое описание страницы, которое отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ old('meta_description', $post->meta_description) }}">
            </div>
            <div class="mb-3">
              <label for="content" class="form-label">Контент</label>
              <div>
                @include('components.bootstrap-5-editor', ['attribute' => 'content', 'content' => old('content', $post->content)])
              </div>
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                <option value=""></option>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" @if($post->lang == $language->slug) selected @endif>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" @if ($post->status == 1) checked @endif>
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
  <script src="/joystick/js/bootstrap5editor.js"></script>

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
