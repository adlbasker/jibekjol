@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Единицы измерения</h2>

  @include('components.alerts')

  <div class="text-end">
    <a href="/{{ $lang }}/admin/units/create" class="btn btn-success"><i class="material-icons md-18">add</i></a>
  </div><br>
  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Название</td>
          <td>Язык</td>
          <td class="text-end">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($units as $unit)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $unit->title }}</td>
            <td>{{ $unit->lang }}</td>
            <td class="text-end">
              <a class="btn btn-link btn-sm" href="{{ route('units.edit', [$lang, $unit->id]) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('units.destroy', [$lang, $unit->id]) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $units->links() }}

@endsection
