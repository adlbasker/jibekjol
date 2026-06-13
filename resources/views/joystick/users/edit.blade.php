@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="row mb-3">
    <div class="col-md-12 text-end">
      <a href="/{{ $lang }}/admin/users/password/{{ $user->id }}/edit" class="btn btn-outline-dark">Изменить пароль</a>
      <a href="/{{ $lang }}/admin/users" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
    </div>
  </div>

  <form action="{{ route('users.update', [$lang, $user->id]) }}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf

    <div class="row">
      <div class="col-md-7">
        <div class="card mb-3">
          <div class="card-header">Основная информация</div>
          <div class="card-body">
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" minlength="2" maxlength="40" name="name" placeholder="Имя*" value="{{ old('name', $user->name) }}" required>
              </div>
              <div class="col-md-6">
                <label for="lastname" class="form-label">Отчество</label>
                <input type="text" class="form-control" id="lastname" minlength="2" maxlength="60" name="lastname" placeholder="Отчество*" value="{{ old('lastname', $user->lastname) }}">
              </div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="60" value="{{ $user->email }}">
            </div>
            <div class="mb-3">
              <label for="tel" class="form-label">Номер телефона</label>
              <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control" id="tel" name="tel" placeholder="Номер телефона*" value="{{ old('tel', $user->tel) }}">
            </div>
            <div class="mb-3">
              <label for="id_client" class="form-label">ID client</label>
              <input type="text" class="form-control" id="id_client" name="id_client" maxlength="30" placeholder="ID client*" value="{{ old('id_client', $user->id_client) }}">
            </div>
            <div class="mb-3">
              <label for="id_name" class="form-label">ID name</label>
              <input type="text" class="form-control" id="id_name" name="id_name" maxlength="30" placeholder="ID name*" value="{{ old('id_name', $user->id_name) }}">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Адрес</label>
              <input type="text" class="form-control" id="address" name="address" maxlength="30" placeholder="Адрес" value="{{ old('address', $user->address) }}">
            </div>
            <div class="mb-3">
              <label for="role_id" class="form-label">Роли</label>
              <select class="form-select" name="role_id" id="role_id">
                <option value=""></option>
                @foreach($roles as $role)
                  <option value="{{ $role->id }}" @if ($user->roles->contains($role->id)) selected @endif>{{ $role->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_customer" name="is_customer" @if ($user->is_customer) checked @endif>
                <label class="form-check-label" for="is_customer">Клиент</label>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_worker" name="is_worker" @if ($user->is_worker) checked @endif>
                <label class="form-check-label" for="is_worker">Сотрудник</label>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="status" name="status" @if ($user->status == 1) checked @endif>
                <label class="form-check-label" for="status">Активен</label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-5">
        <div class="card mb-3">
          <div class="card-header">Профиль</div>
          <div class="card-body">
            <div class="mb-3">
              <label for="region_id" class="form-label">Регион</label>
              <select id="region_id" name="region_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $user, $__env) { ?>
                  @foreach ($nodes as $node)
                    <option value="{{ $node->id }}" @if ($node->id == $user->region_id) selected @endif>{{ $prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  @endforeach
                <?php }; ?>
                <?php $traverse($regions); ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="company_id" class="form-label">Компании</label>
              <select id="company_id" name="company_id" class="form-select">
                <option value=""></option>
                @foreach ($companies as $company)
                  <option value="{{ $company->id }}" @if ($user->profile->company_id == $company->id) selected @endif>{{ $company->title }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">Дата рождения</label>
              <input type="date" class="form-control" id="birthday" name="birthday" value="{{ old('birthday', $user->profile->birthday) }}">
            </div>
            <div class="mb-3">
              <label class="form-label d-block">Пол</label>
              @foreach(trans('data.gender') as $key => $value)
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="gender" id="gender{{ $key }}" value="{{ $key }}" @if($user->profile->gender == $key) checked @endif>
                  <label class="form-check-label" for="gender{{ $key }}">{{ $value }}</label>
                </div>
              @endforeach
            </div>
            <div class="mb-3">
              <label for="about" class="form-label">О себе</label>
              <textarea class="form-control" id="about" name="about" rows="5">{{ old('about', $user->profile->about) }}</textarea>
            </div>
            <div class="mb-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="is_debtor" name="is_debtor" @if ($user->profile->is_debtor == 1) checked @endif disabled>
                <label class="form-check-label" for="is_debtor">Должник</label>
              </div>
            </div>
            <div class="mb-3">
              <label for="debt_sum" class="form-label">Сумма долга</label>
              <input type="number" class="form-control" id="debt_sum" name="debt_sum" value="{{ old('debt_sum', $user->profile->debt_sum ?? 0) }}">
            </div>
            <div class="mb-3">
              <label for="bonus" class="form-label">Бонус</label>
              <input type="number" class="form-control" id="bonus" name="bonus" value="{{ old('bonus', $user->profile->bonus ?? 0) }}">
            </div>
            <div class="mb-3">
              <label for="discount" class="form-label">Скидка</label>
              <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount', $user->profile->discount ?? 0) }}">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mb-3">
      <button type="submit" class="btn btn-success"><i class="material-icons">save</i></button>
    </div>
  </form>
@endsection
