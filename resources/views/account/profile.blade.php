@extends('market.layout')

@section('meta_title', 'Jibekjol Profile')
@section('meta_description', 'Jibekjol Profile')

@section('content')

  <div class="container py-5">
    <div class="row">
      <div class="col-lg-5 col-md-7 col-sm-9 mx-auto">

        @include('components.alerts')

        <div class="p-4 p-md-5 mb-4 bg-light border rounded-3">
          <div class="row mb-2" id="copy-paste-text">
            <h5 class="mb-2">{{ __('app.copy_delivery_address') }}</h5>
            <div class="col-3">
              <div>ID:</div>
              <div>Number:</div>
              <div>China address:</div>
            </div>
            <div class="col-9 cargo-data">
              <div>{{ Auth()->user()->id_client }}</div>
              <div>18149991335</div>
              <div>广东省 佛山市 南海区 里水镇 里水镇洲村大管家仓储园E113号(7788仓库)</div>
            </div>
          </div>
          <button id="copy-data" class="btn btn-sm btn-outline-dark" type="button">
            <i class="bi bi-clipboard"></i> {{ __('app.copy') }}
          </button>
        </div>

        <div class="p-4 p-md-5 bg-light border rounded-3">
          <h2 class="fw-bold mb-0">{{ __('app.my_profile') }}</h2>
          <br>

          <h5 class="mb-2">{{ $user->name.' '.$user->lastname }}</h5>

          <table class="table">
            <tbody>
              <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
              </tr>
              <tr>
                <th>Tel</th>
                <td>{{ $user->tel }}</td>
              </tr>
              <tr>
                <th scope="col">{{ __('app.region') }}</th>
                <td scope="col">{{ $user->region->title }}</td>
              </tr>
              <tr>
                <th>{{ __('app.address') }}</th>
                <td>{{ $user->address }}</td>
              </tr>
              <tr>
                <th>ID client</th>
                <td>{{ $user->id_client }}</td>
              </tr>
              <tr>
                <th>{{ __('app.language') }}</th>
                <td>{{ $language->title }}</td>
              </tr>
              <tr>
                <th colspan="2">{{ __('app.webpush_notification') }}
                  <?php $statusPush = \App\Models\PushSubscription::where('subscribable_id', auth()->user()->id)->first(); ?>
                  <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary @if(!$statusPush) {{ '-d-none' }} @endif " id="btn-push-unsubscribe" onclick="return confirm('{{ __('app.confirm_action') }}') || event.stopImmediatePropagation()" @if(!$statusPush) {{ 'disabled' }} @endif><i class="bi bi-bell-slash"></i> {{ __('app.unsubscribe_webpush') }}</button>
                    <button type="button" class="btn btn-outline-primary @if($statusPush) {{ '-d-none' }} @endif " id="btn-push-subscribe" onclick="return confirm('{{ __('app.confirm_action') }}') || event.stopImmediatePropagation()" @if($statusPush) {{ 'disabled' }} @endif><i class="bi bi-bell"></i> {{ __('app.subscribe_webpush') }}</button>
                  </div>
                </th>
              </tr>
              <tr>
                <th>{{ __('app.mail_notification') }}</th>
                <td>{{ __('app.notification_status.'.$user->status) }}</td>
              </tr>
            </tbody>
          </table>

          <div class="mt-4">
            <a href="/{{ $lang }}/profile/edit" class="btn btn-primary btn-lg">{{ __('app.edit') }}</a>
          </div>

        </div>

      </div>
    </div>
  </div>

@endsection

@section('head')
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
  <script src="/webpush.js"></script>
  <script type="text/javascript">
    const btnSub = document.getElementById('btn-push-subscribe');
    const btnUnsub = document.getElementById('btn-push-unsubscribe');

    btnSub.addEventListener('click', function(res) {
      subscribeUserToPush();
      btnSub.disabled = true;
      btnUnsub.disabled = false;
    });

    btnUnsub.addEventListener('click', function(res) {
      unsubscribeUserFromPush();
      btnSub.disabled = false;
      btnUnsub.disabled = true;
    });
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const copyBtn = document.getElementById('copy-data');
      const textElement = document.querySelector('.cargo-data');

      if (copyBtn && textElement) {
        copyBtn.addEventListener('click', function() {
          // Использование innerText сохраняет переносы строк, что идеально для умного распознавания адресов (Pinduoduo, Taobao и т.д.)
          const textToCopy = textElement.innerText;

          navigator.clipboard.writeText(textToCopy).then(() => {
            // Сохраняем изначальный вид кнопки
            const originalHtml = copyBtn.innerHTML;

            // Меняем вид кнопки на успешный
            copyBtn.innerHTML = '<i class="bi bi-check2"></i>  <?= __('app.copied'); ?>';
            copyBtn.classList.remove('btn-outline-dark');
            copyBtn.classList.add('btn-success');

            // Возвращаем вид кнопки обратно через 2 секунды
            setTimeout(() => {
              copyBtn.innerHTML = originalHtml;
              copyBtn.classList.remove('btn-success');
              copyBtn.classList.add('btn-outline-dark');
            }, 2000);
          }).catch(err => {
            console.error('Failed to copy text: ', err);
          });
        });
      }
    });
  </script>
@endsection