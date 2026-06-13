@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Регионы</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/regions/create" class="btn btn-success"><i class="material-icons">add</i></a>
    </div>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th width="30px">№</th>
          <th>Название</th>
          <th>Slug</th>
          <th>Номер</th>
          <th>Язык</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php $traverse = function ($nodes, $parent = null, $prefix = null, $caret = null) use (&$traverse, $lang, &$i) { ?>
          <?php foreach ($nodes as $node) : ?>
            <tr <?php if ($parent != null): $classes = $node->ancestors->pluck('id')->flatten()->join(' '); ?> class="collapse {{ $classes }} show" <?php endif; ?>>
              <td>{{ $i++ }}</td>
              <td
                <?php if ($node->descendants->count() > 0): $caret = '<i class="material-icons align-middle">expand_more</i>'; ?>
                  class="node-title cursor-pointer" data-bs-toggle="collapse" data-bs-target=".{{ $node->id }}" aria-expanded="true" aria-controls="{{ $node->id }}"
                <?php endif; ?>>
                {!! $caret !!} {{ $prefix.' '.$node->title }} <?php $caret = null; ?>
              </td>
              <td>{{ $node->slug }}</td>
              <td>{{ $node->sort_id }}</td>
              <td>{{ $node->lang }}</td>
              <td><span class="text-{{ __('statuses.data.'.$node->status.'.style') }}">{{ __('statuses.data.'.$node->status.'.title') }}</span></td>
              <td class="text-end">
                <a class="btn btn-link btn-sm" href="{{ route('regions.edit', [$lang, $node->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
                <form class="btn-delete d-inline" method="POST" action="{{ route('regions.destroy', [$lang, $node->id]) }}" accept-charset="UTF-8">
                  @method('DELETE')
                  @csrf
                  <button type="submit" class="btn btn-link btn-sm p-0" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
                </form>
              </td>
            </tr>
            <?php $traverse($node->children, $node, $prefix.'____'); ?>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($regions); ?>
      </tbody>
    </table>
  </div>

@endsection