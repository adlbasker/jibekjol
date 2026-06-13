@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Разделы</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/sections/create" class="btn btn-success"><i class="material-icons">add</i></a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr class="table-active">
          <th width="30px">№</th>
          <th>Название</th>
          <th>Slug</th>
          <th>Номер</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php $grouped = $sections->groupBy('lang'); ?>
        @foreach ($grouped as $langKey => $langSections)
          <tr class="table-active text-uppercase">
            <th></th>
            <th colspan="6">{{ $langKey }}</th>
          </tr>
          <?php foreach ($langSections as $section) : ?>
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ PHP_EOL.'__'.$section->title }}</td>
              <td>{{ $section->slug }}</td>
              <td>{{ $section->sort_id }}</td>
              <td><span class="text-{{ __('statuses.data.'.$section->status.'.style') }}">{{ __('statuses.data.'.$section->status.'.title') }}</span></td>
              <td class="text-end text-nowrap">
                <a class="btn btn-link btn-sm p-0" href="{{ route('sections.edit', [app()->getLocale(), $section->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
                <form class="btn-delete d-inline" method="POST" action="{{ route('sections.destroy', [app()->getLocale(), $section->id]) }}" accept-charset="UTF-8">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection