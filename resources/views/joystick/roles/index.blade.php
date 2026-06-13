@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Роли</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/roles/create" class="btn btn-success"><i class="material-icons">add</i></a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr class="table-active">
          <th width="30px">№</th>
          <th>Название</th>
          <th>Метка</th>
          <th>Описание</th>
          <th>Права</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($roles as $role)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->display_name }}</td>
            <td>{{ $role->description }}</td>
            <td>
              <?php $grouped = $role->permissions->groupBy('display_name'); ?>
              @foreach($grouped as $name => $group)
                <div class="small text-muted">
                  <strong>{{ $name }}:</strong>
                  @foreach($group as $permission)
                    {{ $permission->description }}@if (!$loop->last), @endif
                  @endforeach
                </div>
              @endforeach
            </td>
            <td class="text-end">
              <a class="btn btn-link btn-sm p-0" href="{{ route('roles.edit', [$lang, $role->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('roles.destroy', [$lang, $role->id]) }}" accept-charset="UTF-8" class="btn-delete d-inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection