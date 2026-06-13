@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Компании</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <div class="btn-group">
      <button type="button" id="submit" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Функции
      </button>
      <ul class="dropdown-menu dropdown-menu-end" id="actions">
        @foreach(__('statuses.data') as $num => $status)
          <li><a class="dropdown-item" data-action="{{ $num }}" href="#">Статус {{ $status['title'] }}</a></li>
        @endforeach
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" data-action="destroy" href="#" onclick="return confirm('Удалить записи?')">Удалить</a></li>
      </ul>
    </div>
    <a href="/{{ $lang }}/admin/companies/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 40px;"><input type="checkbox" onclick="toggleCheckbox(this)" class="form-check-input checkbox-ids"></th>
          <th style="width: 50px;">№</th>
          <th style="width: 100px;">Картинка</th>
          <th>Название</th>
          <th>Номер</th>
          <th>Поставщик</th>
          <th>Заказчик</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($companies as $company)
          <tr>
            <td><input type="checkbox" name="companies_id[]" value="{{ $company->id }}" class="form-check-input checkbox-ids"></td>
            <td>{{ $i++ }}</td>
            <td><img src="/img/companies/{{ $company->image }}" class="img-fluid rounded" style="width:80px;"></td>
            <td>{{ $company->title }}</td>
            <td>{{ $company->sort_id }}</td>
            <td class="text-{{ __('statuses.data.'.$company->status.'.style') }}">{{ __('statuses.data.'.$company->is_supplier.'.title') }}</td>
            <td class="text-{{ __('statuses.data.'.$company->status.'.style') }}">{{ __('statuses.data.'.$company->is_customer.'.title') }}</td>
            <td class="text-{{ __('statuses.data.'.$company->status.'.style') }}">{{ __('statuses.data.'.$company->status.'.title') }}</td>
            <td class="text-end">
              <a class="btn btn-link btn-sm" href="{{ route('companies.edit', [$lang, $company->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('companies.destroy', [$lang, $company->id]) }}" accept-charset="UTF-8" class="btn-delete">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-link btn-sm" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-3">
    {{ $companies->links() }}
  </div>

@endsection

@section('scripts')
  <script>
    // Submit button click
    $("#actions .dropdown-item").click(function(e) {
      e.preventDefault();
      var action = $(this).data("action");
      var companiesId = new Array();

      $('input[name="companies_id[]"]:checked').each(function() {
        companiesId.push($(this).val());
      });

      if (companiesId.length > 0) {
        $.ajax({
          type: "get",
          url: '/{{ $lang }}/admin/companies-actions',
          dataType: "json",
          data: {
            "action": action,
            "companies_id": companiesId
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