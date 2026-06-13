@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-6">
      <ul class="nav nav-tabs">
        @foreach ($languages as $language)
          <li class="nav-item">
            <a class="nav-link" href="/{{ $lang }}/admin/products/{{ $product->id }}/{{ $language->slug }}">{{ $language->title }}</a>
          </li>
        @endforeach
        <li class="nav-item">
          <a class="nav-link" href="{{ route('products.edit', [$lang, $product->id]) }}">Инфо</a>
        </li>
        <li class="nav-item">
          <span class="nav-link active">Коментарии</span>
        </li>
      </ul>
    </div>
    <div class="col-md-6 text-end">
      <a href="/{{ $lang }}/admin/products" class="btn btn-primary btn-sm"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  @foreach($product->comments as $comment)
    <figure class="border-start border-4 ps-3 mb-4">
      <div class="float-end">
        <a href="/{{ $lang }}/admin/products/{{ $comment->id }}/destroy-comment" class="text-danger"><i class="material-icons md-24">clear</i></a>
      </div>
      <blockquote class="blockquote">
        <p>{{ $comment->comment }}</p>
      </blockquote>
      <figcaption class="blockquote-footer">
        {{ $comment->name }} оценил продукт на:
        @for($i = 1; $i <= $comment->stars; ++$i)
          <span class="text-warning"><i class="material-icons">grade</i></span>
        @endfor
      </figcaption>
    </figure>
  @endforeach
@endsection
