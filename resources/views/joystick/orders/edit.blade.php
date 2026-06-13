@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/orders" class="btn btn-primary"><i class="material-icons">arrow_back</i></a>
  </div>

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('orders.update', [$lang, $order->id]) }}" method="post">
            @method('PUT')
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Имя:</label>
              <input type="text" class="form-control" name="name" id="name" minlength="2" maxlength="60" value="{{ $order->name }}" required>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Номера телефона</label>
              <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $order->phone) }}">
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email:</label>
              <input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="60" value="{{ $order->email }}">
            </div>
            <div class="mb-3">
              <label for="company_name" class="form-label">Название компаний</label>
              <textarea class="form-control" id="company_name" name="company_name" rows="5">{{ old('company_name', $order->company_name) }}</textarea>
            </div>
            <div class="mb-3">
              <label for="data_1" class="form-label">Данные 1</label>
              <input type="text" class="form-control" id="data_1" name="data_1" value="{{ old('data_1', $order->data_1) }}">
            </div>
            <div class="mb-3">
              <label for="data_2" class="form-label">Данные 2</label>
              <input type="text" class="form-control" id="data_2" name="data_2" value="{{ old('data_2', $order->data_2) }}">
            </div>
            <div class="mb-3">
              <label for="data_3" class="form-label">Данные 3</label>
              <input type="text" class="form-control" id="data_3" name="data_3" value="{{ old('data_3', $order->data_3) }}">
            </div>
            <div class="mb-3">
              <label for="region_id" class="form-label">Страны</label>
              <select id="region_id" name="region_id" class="form-select">
                <option value=""></option>
                <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $order, $__env) { ?>
                  <?php foreach ($nodes as $node) : ?>
                    <option value="{{ $node->id }}" @if($node->id == $order->region_id) selected @endif>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                    <?php $traverse($node->children, $prefix.'___'); ?>
                  <?php endforeach; ?>
                <?php }; ?>
                <?php $traverse($regions); ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="legal_address" class="form-label">Юридический адрес</label>
              <input type="text" class="form-control" id="legal_address" name="legal_address" value="{{ old('legal_address', $order->legal_address) }}">
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Адрес</label>
              <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $order->address) }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Количество товаров</label>
              <?php
                $countAllProducts = unserialize($order->count);
                $i = 0;
                $c = 0;
              ?>
              <div class="table-responsive">
                <table class="table table-sm">
                  <tbody>
                    @foreach ($countAllProducts as $id => $countInfo)
                      <tr>
                        <td>
                          @if($order->products[$i]->id == $id)
                            <img src="/img/products/{{ $order->products[$i]->path.'/'.$order->products[$i]->image }}" style="width:80px;height:80px;" class="img-fluid rounded me-2">
                            <div class="d-inline-block align-middle">
                              <span class="badge bg-secondary">{{ $countInfo['quantity'] }} шт.</span> 
                              <a href="/p/{{ $order->products[$i]->id.'-'.$order->products[$i]->slug }}" target="_blank" class="text-decoration-none">{{ $order->products[$i]->title }}</a>
                            </div>
                          @endif
                          <?php $c += $countInfo['quantity']; ?>
                        </td>
                        <td>
                          <?php $idCodes = json_decode($order->products[$i]->id_codes, true) ?? ['']; ?>
                          <label for="id_codes_{{ $i }}" class="form-label small">Артикулы</label>
                          <select id="id_codes_{{ $i }}" name="id_codes[]" class="form-select form-select-sm" required>
                            <option value="">Выберите артикул</option>
                            @foreach($idCodes as $idCode => $idCodeCount)
                              <option value="{{ $idCode }}" @if($countInfo['id_code'] == $idCode || count($idCodes) == 1) selected @endif>{{ $idCode.' '.$idCodeCount }}шт</option>
                            @endforeach
                          </select>
                        </td>
                        <?php $i++; ?>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <p class="fw-bold mt-2">Общее количество товаров: {{ $c }} шт.</p>
            </div>
            <div class="mb-3">
              <label for="price" class="form-label">Цена</label>
              <input type="text" class="form-control" id="price" name="price" value="{{ old('price', $order->price) }}〒">
            </div>
            <div class="mb-3">
              <label for="amount" class="form-label">Сумма</label>
              <input type="text" class="form-control" id="amount" name="amount" value="{{ old('amount', $order->amount) }}〒">
            </div>
            <div class="mb-3">
              <label for="delivery" class="form-label">Способ доставки:</label>
              <select id="delivery" name="delivery" class="form-select">
                <option value="0"></option>
                @foreach(trans('orders.get') as $key => $value)
                  <option value="{{ $key }}" @if ($key == $order->delivery) selected @endif>{{ $value['value'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="payment_type" class="form-label">Способ оплаты:</label>
              <select id="payment_type" name="payment_type" class="form-select">
                <option value="0"></option>
                @foreach(trans('orders.pay') as $key => $value)
                  <option value="{{ $key }}" @if ($key == $order->payment_type) selected @endif>{{ $value['value'] }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="status" class="form-label">Статус:</label>
              <select id="status" name="status" class="form-select" required>
                <option value="0"></option>
                @foreach(trans('orders.statuses') as $key => $title)
                  <option value="{{ $key }}" @if ($key == $order->status) selected @endif>{{ $title }}</option>
                @endforeach
              </select>
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
