@extends('market.layout')

@section('meta_title', (!empty($category->meta_title)) ? $category->meta_title : $category->title)

@section('meta_description', (!empty($category->meta_description)) ? $category->meta_description : $category->title)

@section('content')

  <?php $items = session('items'); ?>
  <div class="py-3 border-bottom mb-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <h4 class="col-12 col-lg-4 mb-md-2 mb-lg-0">{{ $category->title }}</h4>

      @include('components.form-search')
    </div>
  </div>

  <div class="container">
    <div class="row g-3">
      <div class="col-12 col-sm-12 col-md-12 col-lg-3">

        <div class="list-group d-none d-md-none d-lg-block">
          <?php
          $traverse = function ($nodes, $depth = 0) use (&$traverse, $lang) { ?>
            <?php foreach ($nodes as $node) : ?>
              <?php 
                $paddingClass = $depth > 0 ? 'ps-' . ($depth + 2) . ' fw-normal text-muted' : 'fw-bold';
              ?>
              <a href="/{{ $lang }}/market/{{ $node->slug.'/'.$node->id }}" 
                 class="list-group-item list-group-item-action <?= $paddingClass ?>">
                 
                 <?php if ($depth > 0): ?>
                   &mdash; 
                 <?php endif; ?>
                 
                 {{ $node->title }}
              </a>
              
              <?php if (count($node->children) > 0) {
                  $traverse($node->children, $depth + 1); 
              } ?>
            <?php endforeach; ?>
          <?php }; ?>
          
          <?php $traverse($categories); ?>
        </div>

        <div class="dropdown d-block d-md-block d-lg-none">
          <div class="text-end">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('Categories') }}</button>
            <ul class="dropdown-menu dropdown-menu-end" style="display: static;">
              <li><a class="dropdown-item" href="/{{ $lang }}/market">{{ __('All') }}</a></li>
              <?php $traverseM = function ($nodes, $prefix = null) use (&$traverseM, $lang) { ?>
                <?php foreach ($nodes as $node) : ?>
                  <li><a class="dropdown-item" href="/{{ $lang }}/market/{{ $node->slug.'/'.$node->id }}">{{ $node->title }}</a></li>
                  <?php $traverseM($node->children, $prefix.'___'); ?>
                <?php endforeach; ?>
              <?php }; ?>
              <?php $traverseM($categories); ?>
            </ul>
          </div>
        </div>

      </div>
      <div class="col-12 col-sm-12 col-md-12 col-lg-9">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-lg-3 g-1 gy-2 g-md-3">
          @foreach($productsLang as $productLang)
            <?php 
              $product = $productLang->product;
            ?>
            <div class="col">
            <div class="card shadow-sm">
              <a href="/{{ $lang }}/market/{{ $product->id.'-'.$productLang->slug }}">
                <img src="/img/products/{{ $product->path.'/'.$product->image }}" class="card-img-top" alt="{{ $productLang->title }}">
              </a>
              <div class="card-body">
                <p class="card-text"><a href="/{{ $lang }}/market/{{ $product->id.'-'.$productLang->slug }}">{{ $productLang->title }}</a></p>
                <div class="d-flex justify-content-between align-items-center">
                  @if (is_array($items) AND isset($items[$product->id]))
                    <a href="/{{ $lang }}/market/cart" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="{{ __('Go to cart') }}">{{ __('Checkout') }}</a>
                  @else
                    <!-- <button class="btn btn-primary" data-product-id="{{ $product->id }}" onclick="addToCart(this)">{{ __('Add to cart') }}</button> -->
                  @endif
                  <small class="text-body-secondary">{{ $product->price }}〒</small>
                </div>
              </div>
            </div>
            </div>
          @endforeach
        </div>

        {{ $productsLang->links() }}
      </div>
    </div>
  </div>

@endsection

@section('scripts')
  <script>
    // Add to cart
    function addToCart(btn) {
      var productId = btn.getAttribute('data-product-id');

      fetch('/{{ $lang }}/market/add-to-cart/' + productId, {
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