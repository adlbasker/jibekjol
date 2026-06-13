@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Валюты</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/currencies/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <th>Символ</th>
          <th>Название валюты</th>
          <th>Номер</th>
          <th>Страна</th>
          <th>Код</th>
          <th>Язык</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($currencies as $currency)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $currency->symbol }}</td>
            <td>{{ $currency->currency }}</td>
            <td>{{ $currency->sort_id }}</td>
            <td>{{ $currency->country }}</td>
            <td>{{ $currency->code }}</td>
            <td>{{ $currency->lang }}</td>
            <td class="text-end text-nowrap">
              <a class="btn btn-link btn-sm" href="{{ route('currencies.edit', [$lang, $currency->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form class="btn-delete" method="POST" action="{{ route('currencies.destroy', [$lang, $currency->id]) }}" accept-charset="UTF-8">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link btn-sm p-0" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection