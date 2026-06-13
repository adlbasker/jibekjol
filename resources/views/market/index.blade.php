@extends('market.layout')

@section('meta_title', 'Jibekjol Market')

@section('meta_description', 'Jibekjol Market')

@section('content')

  <div class="py-3 border-bottom mb-3">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
      <h4 class="col-12 col-sm-6 col-lg-4 mb-md-2 mb-lg-0">{{ __('Market') }}</h4>

      @include('components.form-search')
    </div>
  </div>

  <div class="container">
    <div class="row g-3">
      <div class="col-12 col-sm-12 col-md-12 col-lg-3">
        <div class="list-group d-none d-md-none d-lg-block">
          <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $lang) { ?>
            <?php foreach ($nodes as $node) : ?>
              <a href="/{{ $lang }}/market/{{ $node->slug.'/'.$node->id }}" class="list-group-item list-group-item-action">{{ $node->title }}</a>
              <?php $traverse($node->children, $prefix.'___'); ?>
            <?php endforeach; ?>
          <?php }; ?>
          <?php $traverse($categories); ?>
        </div>

        <div class="dropdown d-block d-md-block d-lg-none">
          <div class="d-grid/gap-2 text-end">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('Categories') }}</button>
            <ul class="dropdown-menu dropdown-menu-end" style="display: static;">
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
          @foreach($products as $product)
            <?php 
              $productLang = $product->productsLang->firstWhere('lang', app()->getLocale()) ?? $product->productsLang->first();
            ?>
            <div class="col">
            <div class="card shadow-sm">
              <a href="/{{ $lang }}/market/{{ $product->id.'-'.$productLang->slug }}">
                <img src="/img/products/{{ $product->path.'/'.$product->image }}" class="card-img-top" alt="{{ $productLang->title }}">
              </a>
              <div class="card-body">
                <p class="card-text"><a href="/{{ $lang }}/market/{{ $product->id.'-'.$productLang->slug }}">{{ $productLang->title }}</a></p>
                <div class="d-flex justify-content-between align-items-center">
                  <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-outline-secondary">{{ __('To cart') }}</button>
                  </div>
                  <small class="text-body-secondary">{{ $product->price }}〒</small>
                </div>
              </div>
            </div>
            </div>
          @endforeach
        </div>

        {{ $products->links() }}
      </div>
    </div>
  </div>

@endsection