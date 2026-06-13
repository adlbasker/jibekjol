@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/permissions" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('permissions.update', [$lang, $permission->id]) }}" method="post">
            @method('PUT')
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Название</label>
              <input type="text" class="form-control" id="name" name="name" maxlength="80" value="{{ old('name', $permission->name) }}" required>
            </div>
            <div class="mb-3">
              <label for="display_name" class="form-label">Метка</label>
              <input type="text" class="form-control" id="display_name" name="display_name" maxlength="80" value="{{ old('display_name', $permission->display_name) }}">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Описание</label>
              <input type="text" class="form-control" id="description" name="description" maxlength="80" value="{{ old('description', $permission->description) }}">
            </div>
            <div class="mb-3">
              <button type="submit" class="btn btn-success"><i class="material-icons">save</i></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
