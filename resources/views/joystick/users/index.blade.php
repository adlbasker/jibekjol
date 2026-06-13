@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Пользователи</h2>

  @include('components.alerts')

  <form action="/{{ $lang }}/admin/users/search/user" method="get" class="mb-3">
    <div class="row g-2">
      <div class="col-md-4">
        <div class="input-group">
          <input type="search" class="form-control" name="text" value="{{ $_GET['text'] ?? '' }}" placeholder="Поиск...">
          <button class="btn btn-outline-secondary" type="submit"><i class="material-icons">search</i></button>
        </div>
      </div>
      <div class="col-md-6">
        <div class="btn-group" role="group">
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <?php $roleTitle = 'Роли'; ?>
              {{ (isset($_GET['role_id'])) ? $roles->firstWhere('id', $_GET['role_id'])->description : $roleTitle }}
            </button>
            <ul class="dropdown-menu p-3" style="min-width: 200px;">
              @foreach ($roles as $role)
                <li>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="role_id" id="role{{ $role->id }}" value="{{ $role->id }}" @if(isset($_GET['role_id']) && $_GET['role_id'] == $role->id) checked @endif>
                    <label class="form-check-label" for="role{{ $role->id }}">
                      {{ $role->description }}
                    </label>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <?php $regionTitle = 'Регионы'; ?>
              {{ (isset($_GET['region_id'])) ? $regions->firstWhere('id', $_GET['region_id'])->title : $regionTitle }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-category p-3" style="min-width: 250px;">
              <?php $traverse = function ($nodes, $prefix = null) use (&$traverse) { ?>
                <?php foreach ($nodes as $node): ?>
                  <li>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="region_id" id="region{{ $node->id }}" value="{{ $node->id }}">
                      <label class="form-check-label" for="region{{ $node->id }}">
                        {{ $prefix.' '.$node->title }}
                      </label>
                    </div>
                  </li>
                  <?php $traverse($node->children, $prefix.'___'); ?>
                <?php endforeach; ?>
              <?php }; ?>
              <?php $traverse($regions); ?>
            </ul>
          </div>
          <a href="/{{ $lang }}/admin/users" class="btn btn-outline-secondary" title="Сбросить"><i class="material-icons">refresh</i></a>
        </div>
      </div>
    </div>
  </form>

  <div class="table-responsive">
    <table class="table table-striped table-hover table-sm">
      <thead>
        <tr class="table-active">
          <th width="30px">№</th>
          <th>Имя</th>
          <th>Email</th>
          <th>Номер телефона</th>
          <th>Регион</th>
          <th>Роль</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach($users as $user)
          <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $user->name.' '.$user->lastname }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->tel }}</td>
            <td>{{ $user->region->title ?? '' }}</td>
            <td>
              @foreach($user->roles as $role)
                <span class="badge bg-secondary">{{ $role->name }}</span><br>
              @endforeach
            </td>
            <td class="text-end text-nowrap">
              <a class="btn btn-link btn-sm mb-0" href="{{ route('users.edit', [$lang, $user->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('users.destroy', [$lang, $user->id]) }}" accept-charset="UTF-8" class="btn-delete d-inline">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-link btn-sm mb-0" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-3">
    {{ $users->links() }}
  </div>
@endsection
