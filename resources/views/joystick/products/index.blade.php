@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Продукты @if (isset($category)) - {{ $category->title }} @endif</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-6 mb-2">
      <form action="/{{ $lang }}/admin/products-search" method="get">
        <div class="input-group">
          <input type="search" class="form-control" name="text" placeholder="Поиск...">
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
          <th>Категории</th>
          <th style="width: 60px;">Номер</th>
          <th>Просмотры</th>
          <th>Язык</th>
          <th>Режим</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
          <tr>
            <td><input type="checkbox" name="products_id[]" value="{{ $product->id }}" class="form-check-input checkbox-ids"></td>
            <td><img src="/img/products/{{ ($product->image == 'no-image-middle.png') ? 'no-image-mini.png' : $product->path.'/'.$product->image }}" class="img-fluid" style="width:80px;height:auto;"></td>
            <td>
              @foreach ($product->productsLang as $productLang)
                {{ $productLang->title }}<br>
              @endforeach
            </td>
            <td>{{ (isset($product->company->title)) ? $product->company->title : '' }}</td>
            <td class="text-nowrap">
              @foreach ($product->productsLang as $productLang)
                {{ $productLang->category->title ?? $productLang->category_id }}<br>
              @endforeach
            </td>
            <td>{{ $product->sort_id }}</td>
            <td>{{ $product->views }}</td>
            <td>
              @foreach ($product->productsLang as $productLang)
                {{ $productLang->lang }}<br>
              @endforeach
            </td>
            <td class="text-nowrap">
              @foreach ($product->modes as $mode)
                <?php $mode = unserialize($mode->title); ?>
                {{ $mode[$lang]['title'] }}<br>
              @endforeach
            </td>
            <td class="text-{{ __('statuses.data.'.$product->status.'.style') }}">{{ __('statuses.data.'.$product->status.'.title') }}</td>
            <td class="text-end text-nowrap">
              <a class="btn btn-link btn-sm" href="{{ route('products.edit', [$lang, $product->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form class="btn-delete" method="POST" action="{{ route('products.destroy', [$lang, $product->id]) }}" accept-charset="UTF-8">
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
    {{ $products->links() }}
  </div>

@endsection

@section('head')
  <style>
    .dropdown-menu-category {
      max-height: 400px;
      overflow-y: auto;
    }
  </style>
@endsection

@section('scripts')

  <script>

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
