@extends('market.layout')

@section('meta_title', __('Cart'))

@section('content')

  <div class="py-3 border-bottom mb-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <h4 class="col-12 col-sm-6 col-lg-4 mb-md-2 mb-lg-0">{{ __('Cart') }}</h4>
    </div>
  </div>

  <div class="container pb-5">
    @if(session('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if(session('warning'))
      <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if(!empty($items))
      <div class="table-responsive">
        <table class="table align-middle">
          <thead>
            <tr>
              <th>{{ __('Product') }}</th>
              <th>{{ __('Price') }}</th>
              <th>{{ __('Quantity') }}</th>
              <th>{{ __('Total') }}</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0; ?>
            @foreach($items as $id => $item)
              <?php $total += $item['price'] * $item['count']; ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <img src="/img/products/{{ $item['product']->image }}" alt="{{ $item['productLang']->title ?? $item['product']->title }}" style="width: 50px; height: 50px; object-fit: cover;" class="me-3 rounded">
                    <div>
                      <h6 class="mb-0">{{ $item['productLang']->title ?? $item['product']->title }}</h6>
                    </div>
                  </div>
                </td>
                <td>{{ $item['price'] }} ₸</td>
                <td>
                  <div class="d-flex align-items-center">
                    <a href="/{{ $lang }}/market/remove-from-cart/{{ $id }}" class="btn btn-sm btn-outline-secondary">-</a>
                    <span class="mx-2">{{ $item['count'] }}</span>
                    <a href="/{{ $lang }}/market/add-to-cart/{{ $id }}" class="btn btn-sm btn-outline-secondary">+</a>
                  </div>
                </td>
                <td>{{ $item['price'] * $item['count'] }} ₸</td>
                <td>
                  <a href="/{{ $lang }}/market/destroy-from-cart/{{ $id }}" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end fw-bold">{{ __('Total sum') }}:</td>
              <td colspan="2" class="fw-bold fs-5">{{ $total }} ₸</td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="d-flex justify-content-between mt-4">
        <a href="/{{ $lang }}/market/clear-cart" class="btn btn-outline-danger">{{ __('Clear cart') }}</a>
        <a href="/{{ $lang }}/market/checkout" class="btn btn-primary">{{ __('Proceed to Checkout') }}</a>
      </div>
    @else
      <div class="text-center py-5">
        <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
        <h3 class="mt-3">{{ __('Your cart is empty') }}</h3>
        <a href="/{{ $lang }}/market" class="btn btn-primary mt-3">{{ __('Go to Market') }}</a>
      </div>
    @endif
  </div>

@endsection
