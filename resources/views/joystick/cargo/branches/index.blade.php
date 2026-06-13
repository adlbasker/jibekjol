@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Филиалы</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/branches/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-sm table-striped table-hover">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Название</td>
          <td>Регион</td>
          <td>Менеджеры</td>
          <td>Адрес</td>
          <td>Телефон</td>
          <td>Статус</td>
          <td class="text-end">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($branches as $branch)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $branch->title }}</td>
            <td>{{ $branch->region->title }}</td>
            <td>{{ $branch->user->name.' '.$branch->user->lastname }}</td>
            <td>{{ $branch->address }}</td>
            <td>{{ $branch->phones }}</td>
            <td class="text-info">{{ trans('statuses.data.'.$branch->status.'.title') }}</td>
            <td class="text-end">
              <a class="btn btn-link btn-sm" href="{{ route('branches.edit', [$lang, $branch->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('branches.destroy', [$lang, $branch->id]) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $branches->links() }}

@endsection

@section('scripts')

@endsection