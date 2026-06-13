@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Добавление</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/roles" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  <div class="row">
    <div class="col-md-9">
      <div class="card mb-3">
        <div class="card-body">
          <form action="{{ route('roles.store', $lang) }}" method="post">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Название</label>
              <input type="text" class="form-control" id="name" name="name" maxlength="80" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
              <label for="display_name" class="form-label">Метка</label>
              <input type="text" class="form-control" id="display_name" name="display_name" maxlength="80" value="{{ old('display_name') }}">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Описание</label>
              <input type="text" class="form-control" id="description" name="description" maxlength="80" value="{{ old('description') }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Права доступа:</label>
              <div class="row">
                <?php $grouped = $permissions->groupBy('display_name'); ?>
                @foreach($grouped as $name => $group)
                  <div class="col-md-4 mb-3">
                    <h5 class="border-bottom pb-1"><strong>{{ $name }}</strong></h5>
                    @foreach($group as $permission)
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions_id[]" id="permission{{ $permission->id }}" value="{{ $permission->id }}">
                        <label class="form-check-label" for="permission{{ $permission->id }}">
                          {{ $permission->description }}
                        </label>
                      </div>
                    @endforeach
                  </div>
                @endforeach
              </div>
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
