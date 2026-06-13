@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Страницы</h2>

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/pages/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  @include('components.alerts')

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <!-- <th>Язык</th> -->
          <th>Название</th>
          <th>URI</th>
          <th>Номер</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php $grouped = $pages->groupBy('lang'); ?>
        @foreach ($grouped as $langKey => $langPages)
          <tr class="table-active text-uppercase">
            <th></th>
            <th colspan="5">{{ $langKey }}</th>
          </tr>
          <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, &$i, $__env) { ?>
            <?php foreach ($nodes as $page) : ?>
              <tr>
                <td>{{ $i++ }}</td>
                <!-- <td>{{ $page->lang }}</td> -->
                <td>{{ PHP_EOL.$prefix.' '.$page->title }}</td>
                <td>{{ $page->slug }}</td>
                <td>{{ $page->sort_id }}</td>
                <td class="text-{{ __('statuses.data.'.$page->status.'.style') }}">{{ __('statuses.data.'.$page->status.'.title') }}</td>
                <td class="text-end text-nowrap">
                  <a class="btn btn-link btn-sm" href="/{{ app()->getLocale() }}/admin/pages/{{ $page->id }}/copy" title="Копия контента" onclick="return confirm('Копировать запись?')"><i class="material-icons md-18">content_copy</i></a>
                  <a class="btn btn-link btn-sm" href="/{{ app()->getLocale() }}/admin/pages/{{ $page->id }}/edit" title="Редактировать"><i class="material-icons">mode_edit</i></a>
                  <form class="btn-delete" method="POST" action="/{{ app()->getLocale() }}/admin/pages/{{ $page->id }}" accept-charset="UTF-8">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
                  </form>
                </td>
              </tr>
              <?php $traverse($page->children, $prefix.'__'); ?>
            <?php endforeach; ?>
          <?php }; ?>
          <?php $traverse($langPages); ?>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection