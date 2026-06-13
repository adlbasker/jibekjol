@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-6 mb-2">
      <ul class="nav nav-tabs">
        @foreach ($languages as $language)
          <li class="nav-item">
            <a class="nav-link @if ($language->slug == $lang) active @endif" href="/{{ $language->slug }}/admin/products/{{ $product->id }}/edit">{{ $language->title }}</a>
          </li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-6 text-end">
      <a href="/{{ $lang }}/admin/products" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  <form action="/{{ $lang }}/admin/products/{{ $product->id }}" method="POST" id="postForm" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
      <div class="col-md-7">
        <div class="card mb-3">
          <div class="card-header">Основная информация</div>
          <div class="card-body">
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="255" value="{{ old('title', $product->title) }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">URI адрес</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="255" value="{{ old('slug', $product->slug) }}">
            </div>
            <div class="mb-3">
              <label for="meta_title" class="form-label">Мета название (краткий заголовок, который отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $product->meta_title) }}">
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Мета описание (краткое описание страницы, которое отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ old('meta_description', $product->meta_description) }}">
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Порядковый номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ old('sort_id', $product->sort_id) }}">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Описание</label>
              <div>
                @include('components.bootstrap-5-editor', ['attribute' => 'description', 'content' => old('description')])
              </div>
            </div>
            <div class="mb-3">
              <label for="characteristic" class="form-label">Характеристика</label>
              <input type="text" class="form-control" id="characteristic" name="characteristic" minlength="2" maxlength="80" value="{{ old('characteristic', $product->characteristic) }}">
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="count" class="form-label">Количество</label>
                  <input type="number" class="form-control" id="count" name="count" minlength="5" maxlength="80" value="{{ old('count', $product->count) }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="barcodes" class="form-label">Штрихкод</label>
                  <input type="text" class="form-control" id="barcodes" name="barcodes" value="{{ old('barcodes', $product->barcodes) }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="wholesale_price" class="form-label">Цена оптовая</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="wholesale_price" name="wholesale_price" maxlength="10" value="{{ old('wholesale_price', $product->wholesale_price) }}">
                    <span class="input-group-text">{{ $currency->symbol }}</span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="price" class="form-label">Цена розничная</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="price" name="price" maxlength="10" value="{{ old('price', $product->price) }}">
                    <span class="input-group-text">{{ $currency->symbol }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">Изображения</div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label text-muted">Галерея</label><br>
              <?php $images = ($product->images == true) ? unserialize($product->images) : []; ?>
              <?php $key_last = array_key_last($images); ?>
              <div class="row" id="gallery">
                @for ($i = 0; $i <= (($key_last >= 6) ? $key_last : 5); $i++)
                  @if(array_key_exists($i, $images))
                    <div class="col-md-6">
                      <label class="form-label">Image {{ $i }}</label>
                      <input type="file" class="form-control image-input" name="images[]" accept="image/*" data-preview="preview{{ $i }}">
                      <div class="my-2 position-relative" style="min-height: 250px;">
                        <img id="preview{{ $i }}" src="/img/products/{{ $product->path.'/'.$images[$i]['present_image'] }}" alt="Preview {{ $i }}" class="img-fluid border" style="width: auto; max-height: 260px;">
                        <div class="position-absolute bottom-0 start-0 form-check d-inline-block ms-2" style="text-shadow: 0 0 5px #fff">
                          <input class="form-check-input" type="checkbox" name="remove_images[]" id="remove_image{{ $i }}" value="{{ $i }}">
                          <label class="form-check-label" for="remove_image{{ $i }}">Удалить</label>
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="alt_description_{{ $i }}" class="form-label">Alt описание</label>
                        <input type="text" class="form-control" id="alt_description_{{ $i }}" name="alt_descriptions[]" value="{{ $images[$i][$lang.'_description'] ?? '' }}">
                        <input type="hidden" class="form-control" name="initial_alt_descriptions[]" value="{{ $images[$i][$lang.'_description'] ?? '' }}">
                      </div>
                    </div>
                  @else
                    <div class="col-md-6">
                      <label class="form-label">Image {{ $i }}</label>
                      <input type="file" class="form-control image-input" name="images[]" accept="image/*" data-preview="preview{{ $i }}">
                      <div class="my-2">
                        <img id="preview{{ $i }}" src="/joystick/no-image-middle.png" alt="Preview {{ $i }}" class="img-fluid border" style="width: auto; max-height: 260px;">
                      </div>
                      <div class="mb-3">
                        <label for="alt_description_{{ $i }}" class="form-label">Alt описание</label>
                        <input type="text" class="form-control" id="alt_description_{{ $i }}" name="alt_descriptions[]" value="">
                      </div>
                    </div>
                  @endif
                @endfor
              </div>
            </div>
            <div class="mb-3">
              <button type="button" class="btn btn-outline-success" onclick="addFileinput(this);"><i class="material-icons">add</i> Добавить загрузчик</button>
            </div>
          </div>
        </div>

        <div class="card mb-3">
          <div class="card-header">Статус</div>
          <div class="card-body">
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" @if(old('lang', $lang) == $language->slug) selected @endif>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Статус</label>
              @foreach(trans('statuses.data') as $num => $status)
                <div class="form-check">
                  <input class="form-check-input" type="radio" id="status{{ $num }}" name="status" value="{{ $num }}" @if ($num == $product->status) checked @endif>
                  <label class="form-check-label" for="status{{ $num }}">{{ $status['title'] }}</label>
                </div>
              @endforeach
            </div>
            <div class="mb-3 mt-4">
              <button type="submit" class="btn btn-success"><i class="material-icons">save</i></button>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="card mb-3">
          <div class="card-header">Параметры</div>
          <div class="card-body">
            <div class="mb-3">
              <label for="company_id" class="form-label">Компания</label>
              <select id="company_id" name="company_id" class="form-select">
                <option value=""></option>
                @foreach($companies as $company)
                  <option value="{{ $company->id }}" @if ($company->id == $product->company_id) selected @endif>{{ $company->title }}</option>
                @endforeach
              </select>
            </div>
            <p class="mb-2"><b>Категории</b></p>
            <div class="card mb-3">
              <div class="card-body py-2" style="max-height: 250px; overflow-y: auto;">
                <?php foreach ($categories as $category) : ?>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="category_id" id="category{{ $category->id }}" value="{{ $category->id }}" @if ($category->id == $product->category_id) checked @endif required>
                    <label class="form-check-label" for="category{{ $category->id }}">{{ $category->title }}</label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            <p class="mb-2"><b>Опции</b></p>
            <div class="card mb-3">
              <div class="card-body py-2" style="max-height: 250px; overflow-y: auto;">
                <?php $grouped = $options->groupBy('data'); ?>
                @forelse ($grouped as $data => $group)
                  <?php $data = json_decode($data, true); ?>
                  <p class="mb-1 mt-2 small text-muted text-uppercase"><b>{{ $data[$lang]['data'] ?? '' }}</b></p>
                  @foreach ($group as $option)
                    <?php $titles = json_decode($option->title, true); ?>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="options_id[]" id="option{{ $option->id }}" value="{{ $option->id }}" @if ($product->options->contains($option->id)) checked @endif>
                      <label class="form-check-label" for="option{{ $option->id }} small">{{ $titles[$lang]['title'] ?? '' }}</label>
                    </div>
                  @endforeach
                @empty
                   <p class="small text-muted">Нет опций</p>
                @endforelse
              </div>
            </div>
            <p class="mb-2"><b>Режимы</b></p>
            <div class="card">
              <div class="card-body py-2" style="max-height: 150px; overflow-y: auto;">
                @foreach($modes as $mode)
                  <?php $titles = unserialize($mode->title); ?>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="modes_id[]" id="mode{{ $mode->id }}" value="{{ $mode->id }}" @if ($product->modes->contains($mode->id)) checked @endif>
                    <label class="form-check-label" for="mode{{ $mode->id }} small">{{ $titles[$lang]['title'] ?? '' }}</label>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>


@endsection

@section('head')

@endsection

@section('scripts')
  <script src="/joystick/js/bootstrap5editor.js"></script>

  <script>
    function addFileinput() {
      const gallery = document.getElementById('gallery');
      if (!gallery) return;

      const inputs = gallery.querySelectorAll('.image-input');
      const indices = Array.from(inputs)
        .map((input) => {
          const m = (input.dataset.preview || '').match(/^preview(\d+)$/);
          return m ? parseInt(m[1], 10) : null;
        })
        .filter((n) => n !== null);
      const nextIndex = indices.length ? Math.max(...indices) + 1 : inputs.length;

      const slot = document.createElement('div');
      slot.className = 'col-md-6';
      slot.innerHTML = `<label class="form-label">Image ${nextIndex}</label>
        <input type="file" class="form-control image-input" name="images[]" accept="image/*" data-preview="preview${nextIndex}">
        <div class="my-2">
          <img id="preview${nextIndex}" src="/joystick/no-image-middle.png" alt="Preview ${nextIndex}" class="img-fluid border"
            style="width: auto; max-height: 260px;">
        </div>
        <div class="mb-3">
          <label for="alt_description_${nextIndex}" class="form-label">Alt описание</label>
          <input type="text" class="form-control" id="alt_description_${nextIndex}" name="alt_descriptions[]" value="">
        </div>`;

      gallery.appendChild(slot);
    }

    document.addEventListener('DOMContentLoaded', function () {
      const gallery = document.getElementById('gallery');
      if (!gallery) return;
      gallery.addEventListener('change', function (e) {
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
