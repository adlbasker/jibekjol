@extends('joystick.layout')

@section('content')

  <h2 class="page-header">Заказы</h2>

  @include('components.alerts')

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <th>Дата</th>
          <th>Заказчик</th>
          <th>Телефон</th>
          <th>Email</th>
          <th>Город</th>
          <th>Количество</th>
          <th>Сумма</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($orders as $order)
          <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->name }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->email }}</td>
            <td>{{ (isset($order->region->title)) ? $order->region->title : '' }} {{ $order->address }}</td>
            <td>
              <?php $countAllProducts = unserialize($order->count); $i = 0; ?>
              @foreach ($countAllProducts as $id => $countInfo)
                @if (isset($order->products[$i]) AND $order->products[$i]->id == $id)
                  {{ $countInfo['quantity'] . ' шт. ' . $order->products[$i]->title  }}<br>
                @endif
                <?php $i++; ?>
              @endforeach
            </td>
            <td class="text-nowrap">{{ $order->amount }}〒</td>
            <td>{{ __('orders.statuses.'.$order->status) }}</td>
            <td class="text-end">
              <a class="btn btn-link btn-sm" href="{{ route('orders.edit', [$lang, $order->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('orders.destroy', [$lang, $order->id]) }}" accept-charset="UTF-8" class="btn-delete">
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
    {{ $orders->links() }}
  </div>

@endsection