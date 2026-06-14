@extends('market.layout')

@section('meta_title', __('Checkout'))

@section('content')

  <div class="py-3 border-bottom mb-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <h4 class="col-12 col-sm-6 col-lg-4 mb-md-2 mb-lg-0">{{ __('Checkout') }}</h4>
    </div>
  </div>

  <div class="container pb-5">
    <div class="row">
      <div class="col-md-8">
        <div class="card shadow-sm border-0 mb-4">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">{{ __('Contact Details') }}</h5>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/{{ $lang }}/market/store-order" method="POST">
              @csrf
              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label">{{ __('Name') }} *</label>
                  <input type="text" name="name" class="form-control" required value="{{ auth()->check() ? auth()->user()->name : old('name') }}">
                </div>
                <div class="col-md-6">
                  <label class="form-label">{{ __('Phone') }} *</label>
                  <input type="text" name="phone" class="form-control" required value="{{ auth()->check() ? auth()->user()->phone : old('phone') }}">
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">{{ __('Email') }}</label>
                <input type="email" name="email" class="form-control" value="{{ auth()->check() ? auth()->user()->email : old('email') }}">
              </div>
              
              <h5 class="card-title mt-5 mb-4">{{ __('Delivery Address') }}</h5>
              <div class="row mb-3">
                <div class="col-md-6">
                  <label class="form-label">{{ __('Region') }} *</label>
                  <select name="region_id" class="form-select" required>
                    <option value="">{{ __('Select Region') }}</option>
                    @foreach($regions as $region)
                      <option value="{{ $region->id }}">{{ $region->title }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                  <label class="form-label">{{ __('Address') }} *</label>
                  <input type="text" name="address" class="form-control" required value="{{ auth()->check() ? auth()->user()->address : old('address') }}">
                </div>
              </div>

              <h5 class="card-title mt-5 mb-4">{{ __('Payment Type') }}</h5>
              <div class="mb-4">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_type" id="payment_cash" value="1" checked>
                  <label class="form-check-label" for="payment_cash">
                    {{ __('Cash on Delivery') }}
                  </label>
                </div>
                <div class="form-check mt-2">
                  <input class="form-check-input" type="radio" name="payment_type" id="payment_card" value="2">
                  <label class="form-check-label" for="payment_card">
                    {{ __('Card Online') }}
                  </label>
                </div>
              </div>

              <button type="submit" class="btn btn-primary btn-lg w-100">{{ __('Place Order') }}</button>
            </form>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card shadow-sm border-0 sticky-top" style="top: 100px;">
          <div class="card-body p-4">
            <h5 class="card-title mb-4">{{ __('Your Order') }}</h5>
            
            <ul class="list-group list-group-flush mb-3">
              <?php $total = 0; ?>
              @foreach($items as $item)
                <?php $total += $item['price'] * $item['count']; ?>
                <li class="list-group-item d-flex justify-content-between lh-sm px-0">
                  <div>
                    <h6 class="my-0">{{ $item['productLang']->title ?? $item['product']->title }}</h6>
                    <small class="text-muted">{{ $item['count'] }} x {{ $item['price'] }} ₸</small>
                  </div>
                  <span class="text-muted">{{ $item['price'] * $item['count'] }} ₸</span>
                </li>
              @endforeach
              <li class="list-group-item d-flex justify-content-between px-0">
                <span class="fw-bold">{{ __('Total sum') }}</span>
                <strong class="fs-5">{{ $total }} ₸</strong>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
