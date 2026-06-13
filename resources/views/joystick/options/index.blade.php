@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Опции</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/options/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <th>URI</th>
          <th>Название</th>
          <th>Номер</th>
          <th>Язык</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php $grouped = $options->groupBy('data'); ?>
        @foreach ($grouped as $data => $group)
          <tr class="table-active">
            <th colspan="6">
              <?php $data = json_decode($data, true); ?>
              @foreach ($data as $key => $value)
                {{ $data[$key]['data'] }} |
              @endforeach
            </th>
          </tr>
          @foreach ($group as $option)
            <?php $titles = json_decode($option->title, true); ?>
            <?php $languages = json_decode($option->lang, true); ?>
            <tr>
              <td>{{ $i++ }}</td>
              <td>{{ $option->slug }}</td>
              <td>
                @foreach ($languages as $language)
                  {{ $titles[$language]['title'] }}<br>
                @endforeach
              </td>
              <td>{{ $option->sort_id }}</td>
              <td>
                @foreach ($languages as $language)
                  {{ $language }}<br>
                @endforeach
              </td>
              <td class="text-end text-nowrap">
                <a class="btn btn-link btn-sm" href="{{ route('options.edit', [$lang, $option->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
                <form method="POST" action="{{ route('options.destroy', [$lang, $option->id]) }}" accept-charset="UTF-8" class="btn-delete">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
                </form>
              </td>
            </tr>
          @endforeach
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $options->links() }}
  </div>

@endsection