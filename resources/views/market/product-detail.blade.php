@extends('market.layout')

@section('meta_title', $productLang->meta_title ?? $productLang->title.' - '.$category->title)
@section('meta_description', $productLang->meta_description ?? $productLang->title.' - '.$category->title)

@section('head')
  <!-- <link rel="stylesheet" href="/vendor/photoswipe/photoswipe.css"> -->
  <!-- <link rel="stylesheet" href="/vendor/photoswipe/default-skin/default-skin.css"> -->
  <script src="https://unpkg.com/htmx.org@1.9.6"></script>
@endsection

@section('content')

  <?php
  $product = $productLang->product;
  $items = session('items');
  ?>
  <div class="py-3 border-bottom mb-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <h4 class="col-12 col-sm-6 col-lg-4 mb-md-2 mb-lg-0">{{ __('Market') }}</h4>

      @include('components.form-search')
    </div>
  </div>

  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/{{ $lang }}/market">{{ __('Home') }}</a></li>
        <li class="breadcrumb-item"><a href="/{{ $lang }}/market/{{ $productLang->category->slug.'/'.$productLang->category->id }}">{{ $productLang->category->title }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $productLang->title }}</li>
      </ol>
    </nav>
    <div class="row g-3">
      <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <div id="carousel" class="carousel slide">
          <div class="carousel-inner">
            <?php $images = unserialize($product->images); ?>
            @if(!empty($images))
              <?php $firstItem = [0 => 'active']; ?>
              @foreach ($images as $k => $image)
                <div class="carousel-item {{ $firstItem[$k] ?? null }}">
                  <img src="/img/products/{{ $product->path.'/'.$images[$k]['image'] }}" class="d-block w-100" alt="{{ $product->title }}">
                </div>
              @endforeach
            @else
              <div class="carousel-item active">
                <img src="/img/products/{{ $product->image }}" class="d-block w-100" alt="{{ $product->title }}">
              </div>
            @endif
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>

      <div class="col-12 col-sm-12 col-md-6 col-lg-6">
        <h1>{{ $productLang->title }}</h1>
        <dl class="row">
          @if(isset($product->company))
            <dt class="col-4 col-sm-3">{{ __('Brand') }}</dt>
            <dd class="col-8 col-sm-9">{{ $product->company->title }}</dd>
          @endif

          <dt class="col-4 col-sm-3">{{ __('Product') }}</dt>
          <dd class="col-8 col-sm-9">{{ trans('statuses.types.'.$product->type) }}</dd>

          <dt class="col-4 col-sm-3 text-truncate">{{ __('Quantity') }}</dt>
          <dd class="col-8 col-sm-9">{{ $product->count_web }}{{ __('pcs') }}</dd>

          <dt class="col-4 col-sm-3">{{ __('Price') }}</dt>
          <dd class="col-8 col-sm-9"><h4>{{ $product->price }}₸</h4></dd>

          <dt class="col-4 col-sm-3">{{ __('SKU') }}</dt>
          <dd class="col-8 col-sm-9">
            <?php $barcodes = json_decode($product->barcodes, true) ?? []; ?>
            @foreach($barcodes as $barcode)
              {{ $barcode }}<br>
            @endforeach
            &nbsp;
          </dd>

        </dl>
        <div class="col-sm-9">{!! $productLang->description !!}</div>

        <p></p>

        <div>
          @foreach($product->modes as $mode)
            <?php $titles = unserialize($mode->title); ?>
            <span class="btn-xs product-card__badge--<?= (in_array($mode->slug, ['new', 'sale', 'hot'])) ? $mode->slug : 'default'; ?>">{{ $titles[$lang]['title'] }}</span>
          @endforeach
        </div>
        <br>

        <div class="d-flex align-items-center mb-4">
          <div class="input-group me-3" style="width: 130px;">
            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('quantity').stepDown()">-</button>
            <input type="number" id="quantity" class="form-control text-center" value="1" min="1" max="{{ $product->count > 0 ? $product->count : 999 }}">
            <button class="btn btn-outline-secondary" type="button" onclick="document.getElementById('quantity').stepUp()">+</button>
          </div>

          @if (is_array($items) AND isset($items[$product->id]))
            <a href="/{{ $lang }}/market/cart" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="{{ __('Go to cart') }}">{{ __('Checkout') }}</a>
          @else
            <!-- <button class="btn btn-primary" data-product-id="{{ $product->id }}" onclick="addToCart(this)">
              <i class="bi bi-cart-plus me-2"></i> {{ __('Add to cart') }}
            </button> -->
          @endif
        </div>

      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <!-- <script src="/vendor/photoswipe/photoswipe.min.js"></script> -->
  <!-- <script src="/vendor/photoswipe/photoswipe-ui-default.min.js"></script> -->

  <script>
    const carousel = new bootstrap.Carousel('#carousel')

    // Add to cart
    function addToCart(btn) {
      var productId = btn.getAttribute('data-product-id');
      var quantity = document.getElementById('quantity').value || 1;

      fetch('/{{ $lang }}/market/add-to-cart/' + productId + '?count=' + quantity, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        var buttons = document.querySelectorAll('*[data-product-id="'+productId+'"]');
        buttons.forEach(function(b) {
            b.outerHTML = '<a href="/{{ $lang }}/market/cart" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="{{ __('Go to cart') }}">{{ __('Checkout') }}</a>';
        });

        var countItemsM = document.getElementById('count-items-m');
        if (countItemsM) countItemsM.textContent = data.countItems;
        
        var countItems = document.getElementById('count-items');
        if (countItems) countItems.textContent = data.countItems;

        alert('{{ __('Item added to cart') }}');
      })
      .catch(error => console.error('Error:', error));
    }
  </script>
  @endsection