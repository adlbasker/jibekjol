@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Категории</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <div class="btn-group">
      <button type="button" id="submit" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Функции
      </button>
      <ul class="dropdown-menu dropdown-menu-end" id="actions">
        @foreach(trans('statuses.data') as $num => $status)
          <li><a class="dropdown-item" data-action="{{ $num }}" href="#">Статус {{ $status['title'] }}</a></li>
        @endforeach
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" data-action="destroy" href="#" onclick="return confirm('Удалить записи?')">Удалить</a></li>
      </ul>
    </div>
    <a href="/{{ $lang }}/admin/categories/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 40px;"><input type="checkbox" onclick="toggleCheckbox(this)" class="form-check-input checkbox-ids"></th>
          <th style="width: 50px;">№</th>
          <th>Название</th>
          <th>URI</th>
          <th>Номер</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        <?php $grouped = $categories->groupBy('lang'); ?>
        @foreach ($grouped as $langKey => $langCategories)
          <tr class="table-active text-uppercase">
            <th></th>
            <th colspan="7">{{ $langKey }}</th>
          </tr>
          <?php $traverse = function ($nodes, $parent = null, $prefix = null, $caret = null) use (&$traverse, &$i, $__env) { ?>
            <?php foreach ($nodes as $node) : ?>
              <tr <?php if ($parent != null): $classes = $node->ancestors->pluck('id')->flatten()->join(' '); ?> class="collapse {{ $classes }} show" <?php endif; ?>>
                <td><input type="checkbox" name="categories_id[]" value="{{ $node->id }}" class="form-check-input checkbox-ids"></td>
                <td>{{ $i++ }}</td>
                <td
                  <?php if ($node->descendants->count() > 0): $caret = '<i class="material-icons align-middle me-1">expand_more</i>'; ?>
                    class="node-title cursor-pointer" data-bs-toggle="collapse" data-bs-target=".{{ $node->id }}" aria-expanded="true" aria-controls="{{ $node->id }}"
                  <?php endif; ?>>
                  {{ PHP_EOL.$prefix.' '.$node->title }} <?php $caret = null; ?>
                </td>
                <td>{{ $node->slug }}</td>
                <td>{{ $node->sort_id }}</td>
                <td class="text-{{ __('statuses.data.'.$node->status.'.style') }}">{{ __('statuses.data.'.$node->status.'.title') }}</td>
                <td class="text-end">
                  <a class="btn btn-link btn-sm" href="{{ route('categories.edit', [app()->getLocale(), $node->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
                  <form method="POST" action="{{ route('categories.destroy', [app()->getLocale(), $node->id]) }}" accept-charset="UTF-8" class="btn-delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
                  </form>
                </td>
              </tr>
              <?php $traverse($node->children, $node, $prefix.'___'); ?>
            <?php endforeach; ?>
          <?php }; ?>
          <?php $traverse($langCategories); ?>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection

@section('scripts')
  <script>
    // Submit button click
    $("#actions .dropdown-item").click(function(e) {
      e.preventDefault();
      var action = $(this).data("action");
      var categoriesId = new Array();

      $('input[name="categories_id[]"]:checked').each(function() {
        categoriesId.push($(this).val());
      });

      if (categoriesId.length > 0) {
        $.ajax({
          type: "get",
          url: '/{{ $lang }}/admin/categories-actions',
          dataType: "json",
          data: {
            "action": action,
            "categories_id": categoriesId
          },
          success: function(data) {
            console.log(data);
            location.reload();
          }
        });
      }
    });

    // Toggle checkbox
    function toggleCheckbox(source) {
      var checkboxes = document.querySelectorAll('.checkbox-ids');
      for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
          checkboxes[i].checked = source.checked;
      }
    }
  </script>
@endsection