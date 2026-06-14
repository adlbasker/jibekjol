@extends('market.layout')

@section('meta_title', __('Search'))

@section('meta_description', __('Search'))

@section('content')

  <div class="py-3 border-bottom mb-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <h4 class="col-12 col-sm-6 col-lg-4 mb-md-2 mb-lg-0">{{ __('Market') }}</h4>

      @include('components.form-search')
    </div>
  </div>

  <div class="container">
    <h1 class="fs-3">Результаты по запросу <b>"{{ $text }}"</b></h1>
  </div>

  <div class="container">
    <div class="row g-3">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 g-1 gy-2 g-md-3">
          @foreach($productsLang as $productLang)
            <?php $product = $productLang->product; ?>
            <div class="col">
              <div class="card shadow-sm">
                <a href="/{{ $lang }}/market/{{ $product->id.'-'.$productLang->slug }}">
                  <img src="/img/products/{{ $product->path.'/'.$product->image }}" class="card-img-top" alt="{{ $productLang->title }}">
                </a>
                <div class="card-body">
                  <p class="card-text"><a href="/{{ $lang }}/market/{{ $product->id.'-'.$productLang->slug }}">{{ $productLang->title }}</a></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <!-- <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary">{{ __('To cart') }}</button>
                    </div> -->
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