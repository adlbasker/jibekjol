@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Режимы</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/modes/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <th>URI</th>
          <th>Название</th>
          <th>Номер</th>
          <th>Данные</th>
          <th>Язык</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($modes as $mode)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $mode->slug }}</td>
            <td>
              <?php $titles = unserialize($mode->title); ?>
              <?php $languages = unserialize($mode->lang); ?>
              @foreach ($languages as $language)
                {{ $titles[$language]['title'] }}<br>
              @endforeach
            </td>
            <td>{{ $mode->sort_id }}</td>
            <td>{{ $mode->data }}</td>
            <td>
              @foreach ($languages as $language)
                {{ $language }}<br>
              @endforeach
            </td>
            <td class="text-end">
              <a class="btn btn-link btn-sm" href="{{ route('modes.edit', [$lang, $mode->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('modes.destroy', [$lang, $mode->id]) }}" accept-charset="UTF-8" class="btn-delete">
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

  <div class="mt-3">
    {{ $modes->links() }}
  </div>

@endsection