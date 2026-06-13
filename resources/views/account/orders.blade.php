@extends('market.layout')

@section('meta_title', 'My orders')
@section('meta_description', 'My orders')

@section('content')

  <div class="container py-5">
    <div class="row">
      <div class="col-lg-10 col-md-10 col-sm-12 mx-auto">

        @include('components.alerts')

        <div class="p-4 p-md-5 bg-light border rounded-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold mb-0">{{ __('app.my_orders') ?? 'Мои заказы' }}</h2>
          <a href="/{{ app()->getLocale() }}/profile" class="btn btn-outline-secondary btn-sm">{{ __('app.back') ?? 'Назад' }}</a>
        </div>

        @if($orders->count() > 0)
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th># ID</th>
                  <th>{{ __('app.date') ?? 'Дата' }}</th>
                  <th>{{ __('app.price') ?? 'Сумма' }}</th>
                  <th>{{ __('app.status') ?? 'Статус' }}</th>
                  <th>{{ __('app.actions') ?? 'Действия' }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($orders as $order)
                  <tr>
                    <td><strong>{{ $order->id }}</strong></td>
                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                    <td>{{ number_format($order->price, 0, '', ' ') }} ₸</td>
                    <td>
                      @if($order->status == 1)
                        <span class="badge bg-warning text-dark">В ожидании</span>
                      @elseif($order->status == 2)
                        <span class="badge bg-info text-dark">В обработке</span>
                      @elseif($order->status == 3)
                        <span class="badge bg-primary">Отправлен</span>
                      @elseif($order->status == 4)
                        <span class="badge bg-success">Доставлен</span>
                      @elseif($order->status == 0)
                        <span class="badge bg-danger">Отменен</span>
                      @else
                        <span class="badge bg-secondary">Статус {{ $order->status }}</span>
                      @endif
                    </td>
                    <td>
                      <!-- Here can be a link to view order details if needed -->
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          
          <div class="mt-4">
            {{ $orders->links() }}
          </div>
        @else
          <div class="alert alert-info">
            {{ __('app.no_orders') ?? 'У вас пока нет заказов.' }}
          </div>
        @endif

        </div>

      </div>
    </div>
  </div>

@endsection