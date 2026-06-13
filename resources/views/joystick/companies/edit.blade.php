@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/companies" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('companies.update', [$lang, $company->id]) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="mb-3">
              <label for="title" class="form-label">Название</label>
              <input type="text" class="form-control" id="title" name="title" minlength="2" maxlength="80" value="{{ old('title', $company->title) }}" required>
            </div>
            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ old('slug', $company->slug) }}">
            </div>
            <div class="mb-3">
              <label for="bin" class="form-label">БИН</label>
              <input type="text" class="form-control" id="bin" name="bin" value="{{ old('bin', $company->bin) }}">
            </div>
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ old('sort_id', $company->sort_id) }}">
            </div>
            <div class="mb-3">
              <label for="region_id" class="form-label">Регионы</label>
              <circle-progress-bar></circle-progress-bar>
              <select id="region_id" name="region_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $company) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}" {{ $node->id == $company->region_id ? 'selected' : '' }}>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($regions); ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="currency_id" class="form-label">Валюты</label>
              <select id="currency_id" name="currency_id" class="form-select">
                <option value=""></option>
                @foreach ($currencies as $currency)
                  <option value="{{ $currency->id }}" {{ $company->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->symbol }} - {{ $currency->currency }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="legal_address" class="form-label">Юридический адрес</label>
              <input type="text" class="form-control" id="legal_address" name="legal_address" value="{{ old('legal_address', $company->legal_address) }}">
            </div>
            <div class="mb-3">
              <label for="actual_address" class="form-label">Фактический адрес</label>
              <input type="text" class="form-control" id="actual_address" name="actual_address" value="{{ old('actual_address', $company->actual_address) }}">
            </div>
            <div class="mb-3" id="logo">
              <label for="image" class="form-label">Логотип</label><br>
              <input type="file" class="form-control image-input" name="image" accept="image/*" data-preview="preview">
              <div class="my-2">
                <img id="preview" src="/img/companies/{{ $company->image }}" class="img-fluid border" style="width: auto; max-height: 260px;">
              </div>
            </div>
            <div class="mb-3">
              <label for="about" class="form-label">О компании</label>
              <textarea class="form-control" id="about" name="about" rows="5">{{ old('about', $company->about) }}</textarea>
            </div>
            <div class="mb-3">
              <label for="phones" class="form-label">Номера телефонов</label>
              <input type="text" class="form-control" id="phones" name="phones" value="{{ old('phones', $company->phones) }}">
            </div>
            <div class="mb-3">
              <label for="links" class="form-label">Website</label>
              <input type="text" class="form-control" id="links" name="links" value="{{ old('links', $company->links) }}">
            </div>
            <div class="mb-3">
              <label for="emails" class="form-label">Emails</label>
              <input type="text" class="form-control" id="emails" name="emails" value="{{ old('emails', $company->emails) }}">
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_supplier" name="is_supplier" {{ $company->is_supplier == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="is_supplier">Поставщик</label>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_customer" name="is_customer" {{ $company->is_customer == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="is_customer">Заказщик</label>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" {{ $company->status == 1 ? 'checked' : '' }}>
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
      const logo = document.getElementById('logo');
      if (!logo) return;
      logo.addEventListener('change', function (e) {
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
