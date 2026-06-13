@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/apps" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('apps.update', [$lang, $app->id]) }}" method="post">
            <input type="hidden" name="_method" value="PUT">
            @csrf

            <div class="mb-3">
              <label for="date" class="form-label">Дата</label>
              <input type="text" class="form-control" id="date" name="date" value="{{ $app->created_at }}" readonly>
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Имя</label>
              <input type="text" class="form-control" id="name" name="name" maxlength="80" value="{{ $app->name }}" disabled>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="60" value="{{ $app->email }}" disabled>
            </div>
            <div class="mb-3">
              <label class="form-label">Номер телефона</label>
              <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control" name="phone" placeholder="Номер телефона*" value="{{ $app->phone }}" disabled>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Сообщение</label>
              <textarea class="form-control" id="message" name="message" rows="5" disabled>{{ $app->message }}</textarea>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Статус</label>
              <select id="status" name="status" class="form-select" required>
                <option value="1" {{ $app->status == 1 ? 'selected' : '' }}>{{ __('statuses.customer_apps.1') }}</option>
                <option value="2" {{ $app->status == 2 ? 'selected' : '' }}>{{ __('statuses.customer_apps.2') }}</option>
              </select>
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
