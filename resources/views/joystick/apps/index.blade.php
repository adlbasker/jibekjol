@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Заявки</h2>

  @include('components.alerts')

  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr class="table-active">
          <th class="text-center"><i class="material-icons">mode_edit</i></th>
          <th>Дата</th>
          <th>Имя</th>
          <th>Email</th>
          <th>Номер</th>
          <th>Текст</th>
          <th>Статус</th>
          <th class="text-center"><i class="material-icons">clear</i></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($apps as $app)
          <tr>
            <td class="text-center"><a class="btn btn-link btn-sm" href="{{ route('apps.edit', [$lang, $app->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a></td>
            <td>{{ $app->created_at }}</td>
            <td>{{ $app->name }}</td>
            <td>{{ $app->email }}</td>
            <td>{{ $app->phone }}</td>
            <td>{{ $app->message }}</td>
            <td class="text-info">{{ __('statuses.customer_apps.'.$app->status) }}</td>
            <td class="text-center">
              <form method="POST" action="/{{ $lang }}/admin/apps/{{ $app->id }}" accept-charset="UTF-8" class="btn-delete">
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
  {{ $apps->links() }}

@endsection