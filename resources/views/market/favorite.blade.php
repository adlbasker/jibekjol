@extends('market.layout')

@section('meta_title', __('Favorites'))

@section('meta_description', __('Favorites'))

@section('head')

@endsection

@section('content')

  <?php $items = session('items'); ?>
  <?php $favorite = session('favorite'); ?>

  <div class="page-header">
    <div class="page-header__container container">
      <br>
      <div class="page-header__title">
        <h1>{{ __('Favorites') }}</h1>
      </div>
    </div>
  </div>
  <div class="block">
    <div class="container">
      @if ($products->count() > 0)
        <table class="wishlist">
          <thead class="wishlist__head">
            <tr class="wishlist__row">
              <th class="wishlist__column wishlist__column--image">{{ __('Picture') }}</th>
              <th class="wishlist__column wishlist__column--product">{{ __('Product') }}</th>
              <th class="wishlist__column wishlist__column--stock">{{ __('Status') }}</th>
              <th class="wishlist__column wishlist__column--price">{{ __('Price') }}</th>
              <th class="wishlist__column wishlist__column--tocart"></th>
              <th class="wishlist__column wishlist__column--remove"></th>
            </tr>
          </thead>
          <tbody class="wishlist__body">
            @foreach($products as $product)
              <tr class="wishlist__row">
                <td class="wishlist__column wishlist__column--image">
                  <a class="product-image__body" href="/p/{{ $product->id.'-'.$product->slug }}"><img class="product-image__img" src="/img/products/{{ $product->path.'/'.$product->image }}"></a>
                </td>
                <td class="wishlist__column wishlist__column--product">
                  <a href="/p/{{ $product->id.'-'.$product->slug }}" class="wishlist__product-name">{{ $product->title }}</a>
                </td>
                <td class="wishlist__column wishlist__column--stock">
                  <div class="badge badge-success">{{ __('In stock') }}</div>
                </td>
                <td class="wishlist__column wishlist__column--price text-nowrap">{{ $product->price }}〒</td>
                <td class="wishlist__column wishlist__column--tocart">
                  @if ($product->count_web == 0)
                    <button class="btn btn-primary" type="button" data-product-id="{{ $product->id }}" onclick="preOrder(this);">{{ __('Pre-order') }}</button>
                  @elseif (is_array($items) AND isset($items['products_id'][$product->id]))
                    <a href="/cart" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="{{ __('Go to cart') }}">{{ __('Checkout') }}</a>
                  @else
                    <button class="btn btn-primary" type="button" data-product-id="{{ $product->id }}" onclick="addToCart(this);" title="{{ __('To cart') }}">{{ __('To cart') }}</button>
                  @endif
                </td>
                <td class="wishlist__column wishlist__column--remove">
                  <button class="btn btn-light d-none-d-sm-block <?php if (is_array($favorite) AND in_array($product->id, $favorite['products_id'])) echo 'btn-liked'; ?>" type="button" data-favourite-id="{{ $product->id }}" onclick="toggleFavourite(this);">
                    <svg width="18px" height="18px"><use xlink:href="/img/sprite.svg#wishlist-16"></use></svg>
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <h2>{{ __('No favorites') }}</h2>
        <p><a href="/" class="btn btn-primary btn-lg">{{ __('Go to selection') }}</a></p>
      @endif
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

    // Toggle favourite
    function toggleFavourite (btn) {
      var productId = btn.getAttribute('data-favourite-id');

      fetch('/{{ $lang }}/market/toggle-favourite/' + productId, {
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        var buttons = document.querySelectorAll('*[data-favourite-id="'+productId+'"]');
        if (data.status == true) {
          buttons.forEach(function(b) { b.classList.add('btn-liked'); });
        } else {
          buttons.forEach(function(b) { b.classList.remove('btn-liked'); });
        }
        
        var countFavoriteM = document.getElementById('count-favorite-m');
        if (countFavoriteM) countFavoriteM.textContent = data.countFavorite;

        var countFavorite = document.getElementById('count-favorite');
        if (countFavorite) countFavorite.textContent = data.countFavorite;
      })
      .catch(error => console.error('Error:', error));
    }
  </script>
@endsection