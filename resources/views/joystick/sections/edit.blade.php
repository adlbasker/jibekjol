@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/sections" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-9">
      <div class="card mb-3">
        <div class="card-body">
          <form action="{{ route('sections.update', [$lang, $section->id]) }}" method="post">
            @method('PUT')
            @csrf

            <div class="mb-3">
              <label for="title" class="form-label">Заголовок сервиса</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ old('title', $section->title) }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ old('slug', $section->slug) }}">
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ old('sort_id', $section->sort_id) }}">
            </div>
            <div class="mb-3">
              <label for="meta_title" class="form-label">Мета название (краткий заголовок, который отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $section->meta_title) }}">
            </div>
            <div class="mb-3">
              <label for="meta_description" class="form-label">Мета описание (краткое описание страницы, которое отображается в результатах поиска)</label>
              <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ old('meta_description', $section->meta_description) }}">
            </div>

            <div id="keyValue">
              <?php $data = unserialize($section->data); $c = 1; ?>
              @for ($i = 0; $i < count($data); $i++)
                <div class="row mb-3">
                  <div class="col-md-4">
                    <label for="data_{{ $i }}_key" class="form-label">Название {{ $i }}</label>
                    <input type="text" class="form-control" id="data_{{ $i }}_key" name="data[key][]" maxlength="255" value="{{ $data[$i]['key'] ?? null }}">
                  </div>
                  <div class="col-md-8">
                    <label for="data_{{ $i }}_value" class="form-label">Значение {{ $i }}. Разделитель /</label>
                    <input type="text" class="form-control" id="data_{{ $i }}_value" name="data[value][]" maxlength="255" value="{{ $data[$i]['value'] ?? null }}">
                  </div>
                </div>
              @endfor
            </div>
            <div class="mb-3">
              <button type="button" class="btn btn-outline-success" onclick="addInput(this);"><i class="material-icons">add</i> Добавить поля</button>
            </div>
            <div class="mb-3">
              <label for="content" class="form-label">Контент</label>
              <textarea class="form-control" id="content" name="content" rows="10">{{ old('content', $section->content) }}</textarea>
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <select id="lang" name="lang" class="form-select" required>
                @foreach($languages as $language)
                  <option value="{{ $language->slug }}" @if ($section->lang == $language->slug) selected @endif>{{ $language->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" @if ($section->status == 1) checked @endif>
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
<script>
  function addInput() {
    const container = document.getElementById('keyValue');
    const nextId = container.querySelectorAll('.row').length;

    const row = document.createElement('div');
    row.className = 'row mb-3';
    
    row.innerHTML = `<div class="col-md-4">
        <label for="key_${nextId}" class="form-label">Название ${nextId}</label>
        <input type="text" class="form-control" id="key_${nextId}" name="data[key][]" maxlength="255">
      </div>
      <div class="col-md-8">
        <label for="value_${nextId}" class="form-label">Значение ${nextId}. Разделитель /</label>
        <input type="text" class="form-control" id="value_${nextId}" name="data[value][]" maxlength="255">
      </div>`;
    container.appendChild(row);
    nextId + 1;
  }
</script>
@endsection