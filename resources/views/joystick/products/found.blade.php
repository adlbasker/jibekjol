@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Продукты</h2>

  <h3>Поиск по запросу <b>"{{ $text }}"</b></h3>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-6">
      <form action="/{{ $lang }}/admin/products-search" method="get">
        <div class="input-group">
          <input type="search" class="form-control typeahead-goods" name="text" placeholder="Поиск...">
          <button class="btn btn-outline-secondary" type="submit"><i class="material-icons">search</i></button>
          <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Категории
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-category">
            <li><a class="dropdown-item" href="/{{ $lang }}/admin/products"><b>Все товары</b></a></li>
            <li><hr class="dropdown-divider"></li>
            <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $lang, $__env) { ?>
              <?php foreach ($nodes as $node) : ?>
                <li><a class="dropdown-item" href="/{{ $lang }}/admin/products-category/{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</a></li>
                <?php $traverse($node->children, $prefix.'___'); ?>
              <?php endforeach; ?>
            <?php }; ?>
            <?php $traverse($categories); ?>
          </ul>
        </div>
      </form>
    </div>

    <div class="col-md-6 text-end">
      <div class="btn-group">
        <button type="button" id="submit" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Функции
        </button>
        <ul class="dropdown-menu dropdown-menu-end" id="actions">
          @foreach(trans('statuses.data') as $num => $status)
            <li><a class="dropdown-item" data-action="{{ $num }}" href="#">Статус {{ $status['title'] }}</a></li>
          @endforeach
          <li><hr class="dropdown-divider"></li>
          @foreach($modes as $mode)
            <?php $titles = unserialize($mode->title); ?>
            <li><a class="dropdown-item" data-action="{{ $mode->slug }}" href="#">Режим {{ $titles[$lang]['title'] ?? '' }}</a></li>
          @endforeach
        </ul>
      </div>
      <a href="/{{ $lang }}/admin/products/create" class="btn btn-success"><i class="material-icons">add</i></a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 40px;"><input type="checkbox" onclick="toggleCheckbox(this)" class="form-check-input checkbox-ids"></th>
          <th>Картинка</th>
          <th>Название</th>
          <th>Компания</th>
          <th>Категория</th>
          <th style="width: 60px;">Номер</th>
          <th>Просмотры</th>
          <th>Язык</th>
          <th>Режим</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($productsLang as $productLang)
          <tr>
            <td><input type="checkbox" name="products_id[]" value="{{ $productLang->product->id }}" class="form-check-input checkbox-ids"></td>
            <td><img src="/img/products/{{ $productLang->product->path.'/'.$productLang->product->image }}" class="img-fluid" style="width:80px;height:auto;"></td>
            <td>{{ $productLang->title }}</td>
            <td>{{ (isset($productLang->product->company->title)) ? $productLang->product->company->title : '' }}</td>
            <td class="text-nowrap">
              {{ $productLang->category->title ?? $productLang->category_id }}<br>
            </td>
            <td>{{ $productLang->product->sort_id }}</td>
            <td>{{ $productLang->views }}</td>
            <td>{{ $productLang->lang }}</td>
            <td class="text-nowrap">
              @foreach ($productLang->product->modes as $mode)
                <?php $mode = unserialize($mode->title); ?>
                {{ $mode[$lang]['title'] }}<br>
              @endforeach
            </td>
            <td class="text-{{ __('statuses.data.'.$productLang->product->status.'.style') }}">{{ __('statuses.data.'.$productLang->product->status.'.title') }}</td>
            <td class="text-end text-nowrap">
              <a class="btn btn-link btn-sm" href="/{{ $productLang->lang }}/admin/products/{{ $productLang->product_id }}/edit" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form class="btn-delete" method="POST" action="{{ route('products.destroy', [$lang, $productLang->product_id]) }}" accept-charset="UTF-8">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-3">
    {{ $productsLang->links() }}
  </div>

@endsection

@section('head')
  <link href="/bower_components/typeahead.js/dist/typeahead.bootstrap.min.css" rel="stylesheet">
  <style>
    .dropdown-menu-category {
      max-height: 400px;
      overflow-y: auto;
    }
  </style>
@endsection

@section('scripts')
  <script src="/bower_components/typeahead.js/dist/typeahead.bundle.min.js"></script>
  <!-- Typeahead Initialization -->
  <script>
    jQuery(document).ready(function($) {
      // Set the Options for "Bloodhound" suggestion engine
      var engine = new Bloodhound({
        remote: {
          url: '/{{ $lang }}/search-ajax?text=%QUERY%',
          wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('text'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
      });

      $(".typeahead-goods").typeahead({
        hint: true,
        highlight: true,
        minLength: 2
      }, {
        limit: 10,
        source: engine.ttAdapter(),
        displayKey: 'title',

        templates: {
          empty: [
            '<div class="px-3 py-2">Ничего не найдено.</div>'
          ],
          suggestion: function (data) {
            return '<div class="px-3 py-1"><a href="/{{ $lang }}/admin/products/' + data.id + '/edit" class="text-decoration-none text-secondary"><img class="list-img" src="/img/products/' + data.path + '/' + data.image + '" style="width:30px;height:auto;"> ' + data.title + '<br><small class="text-muted">Код: ' + data.barcode + '</small></a></div>'
          }
        }
      });
    });

    // submit button click
    $("#actions > li > a").click(function(e) {
      e.preventDefault();
      var action = $(this).data("action");
      var productsId = new Array();

      $('input[name="products_id[]"]:checked').each(function() {
        productsId.push($(this).val());
      });

      if (productsId.length > 0) {
        $.ajax({
          type: "get",
          url: '/{{ $lang }}/admin/products-actions',
          dataType: "json",
          data: {
            "action": action,
            "products_id": productsId
          },
          success: function(data) {
            console.log(data);
            location.reload();
          }
        });
      }
    });

    function toggleCheckbox(source) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"].checkbox-ids');
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
          checkboxes[i].checked = source.checked;
      }
    }
  </script>
@endsection
