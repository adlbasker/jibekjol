<x-app-layout>
  <div class="row">
    <div class="col-lg-5 col-md-7 col-sm-9 mx-auto">

      <!-- Validation Errors -->
      <x-auth-validation-errors class="mb-4" :errors="$errors" />

      <form method="POST" action="{{ route('register', $lang) }}" class="p-4 p-md-5 bg-light border rounded-3 bg-light">
        @csrf

        <h2 class="fw-bold mb-0">{{ __('app.registration_form') }}</h2>
        <br>

        <div class="row">
          <div class="col">
            <div class="form-floating mb-3">
              <input type="text" name="name" class="form-control rounded-3" id="name" placeholder="{{ __('app.name') }}" value="{{ old('name') }}" required autofocus>
              <label for="name">{{ __('app.name') }}</label>
            </div>
          </div>
          <div class="col">
            <div class="form-floating mb-3">
              <input type="text" name="lastname" class="form-control rounded-3" id="lastname" placeholder="{{ __('app.lastname') }}" value="{{ old('lastname') }}" required>
              <label for="lastname">{{ __('app.surname') }}</label>
            </div>
          </div>
        </div>
        <div class="form-floating mb-3">
          <input type="tel" class="form-control rounded-3" name="tel" id="tel" placeholder="{{ __('app.phone') }}" value="{{ old('tel') }}" required>
          <label for="tel">{{ __('app.phone') }}</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control rounded-3" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}" required>
          <label for="email">{{ __('app.email') }}</label>
        </div>
        <div class="form-floating mb-3">
          <select class="form-control" name="region_id" id="region_id" required>
            <option value="">{{ __('app.select_a_city') }}</option>
            <?php $traverse = function ($nodes, $prefix = null) use (&$traverse) { ?>
              <?php foreach ($nodes as $node) : ?>
                <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
                <?php $traverse($node->children, $prefix.'___'); ?>
              <?php endforeach; ?>
            <?php }; ?>
            <?php $regions = \App\Models\Region::orderBy('sort_id')->get()->toTree(); ?>
            <?php $traverse($regions); ?>
          </select>
          <label for="region_id">{{ __('app.region') }}</label>
        </div>

        <div class="mb-3">
          <label class="form-label d-block">{{ __('app.id_client_creation_mode') }}:</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="id_client_mode" id="id_client_mode_auto" value="auto" {{ old('id_client_mode', 'auto') === 'auto' ? 'checked' : '' }}>
            <label class="form-check-label" for="id_client_mode_auto">{{ __('app.id_client_auto') }}</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="id_client_mode" id="id_client_mode_manual" value="manual" {{ old('id_client_mode') === 'manual' ? 'checked' : '' }}>
            <label class="form-check-label" for="id_client_mode_manual">{{ __('app.id_client_manual') }}</label>
          </div>
        </div>

        <div class="form-floating mb-3" id="id_client_wrapper">
          <input type="text" class="form-control rounded-3" name="id_client" id="id_client" value="{{ old('id_client') }}" placeholder="ID account: J7788...">
          <label for="id_client">{{ __('app.id_client') }}</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control rounded-3" name="password" id="password" placeholder="{{ __('app.enter_password') }}" required>
          <label for="password">{{ __('app.enter_password') }}</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control rounded-3" name="password_confirmation" id="password_confirmation" placeholder="{{ __('app.re-enter_password') }}" required>
          <label for="password_confirmation">{{ __('app.re-enter_password') }}</label>
        </div>

        <button type="submit" class="w-100 mb-4 btn btn-lg rounded-3 btn-primary">{{ __('app.register_btn') }}</button>
        <a href="{{ route('google.redirect', $lang) }}" class="w-100 mb-2 btn btn-lg rounded-3 btn-outline-primary"><i class="bi bi-google"></i> {{ __('app.google_register') }}</a>
        <!-- <hr class="my-4"> -->
        <!-- <small class="text-muted">By clicking Sign up, you agree to the terms of use.</small> -->
      </form>
    </div>
  </div>

  <script>
    (() => {
      const idClientField = document.getElementById('id_client');
      const idClientWrapper = document.getElementById('id_client_wrapper');
      const modeAuto = document.getElementById('id_client_mode_auto');
      const modeManual = document.getElementById('id_client_mode_manual');

      if (!idClientField || !idClientWrapper || !modeAuto || !modeManual) {
        return;
      }

      const toggleIdClientField = () => {
        const isManual = modeManual.checked;
        idClientWrapper.classList.toggle('d-none', !isManual);
        idClientField.disabled = !isManual;
        idClientField.required = isManual;

        if (!isManual) {
          idClientField.value = '';
        }
      };

      modeAuto.addEventListener('change', toggleIdClientField);
      modeManual.addEventListener('change', toggleIdClientField);
      toggleIdClientField();
    })();
  </script>
</x-app-layout>
