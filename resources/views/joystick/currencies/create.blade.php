@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/currencies" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('currencies.store', $lang) }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="sort_id" class="form-label">Номер</label>
              <input type="text" class="form-control" id="sort_id" name="sort_id" value="{{ old('sort_id') }}">
            </div>
            <div class="mb-3">
              <label for="currency" class="form-label">Валюта</label>
              <input type="text" class="form-control" id="currency" name="currency" minlength="2" maxlength="80" value="{{ old('currency') }}" required>
            </div>
            <div class="mb-3">
              <label for="country" class="form-label">Страна</label>
              <input type="text" class="form-control" id="country" name="country" minlength="2" maxlength="80" value="{{ old('country') }}">
            </div>
            <div class="mb-3">
              <label for="code" class="form-label">Код</label>
              <input type="text" class="form-control" id="code" name="code" maxlength="10" value="{{ old('code') }}">
            </div>
            <div class="mb-3">
              <label for="symbol" class="form-label">Символ</label>
              <input type="text" class="form-control" id="symbol" name="symbol" maxlength="10" value="{{ old('symbol') }}">
            </div>
            <div class="mb-3">
              <label for="lang" class="form-label">Язык</label>
              <input type="text" class="form-control" id="lang" name="lang" maxlength="10" value="{{ old('lang') }}">
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-success"><i class="material-icons">save</i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('head')

@endsection

@section('scripts')

@endsection