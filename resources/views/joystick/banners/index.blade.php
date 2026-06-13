@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Баннеры</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/banners/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr class="table-active">
          <th>№</th>
          <th>Позиция текста</th>
          <th>Название</th>
          <th>URI</th>
          <th>Заголовок</th>
          <th>Позиция фона (%)</th>
          <th>Язык</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($banners as $banner)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $banner->direction }}</td>
            <td>{{ $banner->title }}</td>
            <td>{{ $banner->slug }}</td>
            <td>{{ $banner->marketing }}</td>
            <td>{{ $banner->sort_id }}</td>
            <td>{{ $banner->lang }}</td>
            <td><span class="text-{{ __('statuses.data.'.$banner->status.'.style') }}">{{ __('statuses.data.'.$banner->status.'.title') }}</span></td>
            <td class="text-end text-nowrap">
              <a class="btn btn-link btn-sm" href="{{ route('banners.edit', [$lang, $banner->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('banners.destroy', [$lang, $banner->id]) }}" accept-charset="UTF-8" class="btn-delete">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
          <tr>
            <td colspan="9">
              <img src="/img/banners/{{ $banner->image }}" class="img-fluid"><br>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $banners->links() }}

@endsection
