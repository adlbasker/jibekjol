@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Права доступа</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/permissions/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <th>Название</th>
          <th>Метка</th>
          <th>Описание</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($permissions as $permission)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $permission->name }}</td>
            <td>{{ $permission->display_name }}</td>
            <td>{{ $permission->description }}</td>
            <td class="text-end">
              <a class="btn btn-link btn-sm" href="{{ route('permissions.edit', [$lang, $permission->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('permissions.destroy', [$lang, $permission->id]) }}" accept-charset="UTF-8" class="btn-delete">
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