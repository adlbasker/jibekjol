@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Языки</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/languages/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <th>URI</th>
          <th>Название</th>
          <th>Номер</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($languages as $language)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $language->slug }}</td>
            <td>{{ $language->title }}</td>
            <td>{{ $language->sort_id }}</td>
            <td class="text-end">
              <a class="btn btn-link btn-sm" href="{{ route('languages.edit', [$lang, $language->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('languages.destroy', [$lang, $language->id]) }}" accept-charset="UTF-8" class="btn-delete">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection