<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="ismoon">
  <title>@yield('meta_title', 'JibekJol')</title>
  <meta name="description" content="@yield('meta_description', 'JibekJol')">

  <!-- Bootstrap core CSS -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->

  <link rel="manifest" href="/manifest.json">

  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="application-name" content="Jibekjol">
  <meta name="apple-mobile-web-app-title" content="Jibekjol">
  <meta name="theme-color" content="#6610f2">
  <meta name="msapplication-navbutton-color" content="#6610f2">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="msapplication-starturl" content="/">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="msapplication-TileColor" content="#6610f2">
  <meta name="msapplication-TileImage" content="/icons/ms-icon-144x144.png">

  <!-- Favicons -->
  <link rel="apple-touch-icon" sizes="57x57" href="/icons/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/icons/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/icons/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/icons/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/icons/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/icons/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/icons/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/icons/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-icon-180x180.png">
  <link rel="apple-touch-icon" sizes="192x192" type="image/png" href="/icons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="192x192" href="/icons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/icons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">

  <!-- Custom styles for this template -->
  <link href="/node_modules/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="/css/offcanvas-1.css" rel="stylesheet">
  <link href="/css/custom-16.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Ysabeau:ital,wght@1,1000&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/htmx.org@1.9.6"></script>

  @yield('head')

  @if($sections->firstWhere('slug', 'header-code'))
    {{ $sections->firstWhere('slug', 'header-code')->content }}
  @endif
</head>
<body class="bg-light pt-58 pt-lg-75">
  <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-brand-bg-brand-border bg-indigo bg-indigo-border" aria-label="Main navigation">
    <div class="container-xl">
      <a href="/{{ $lang }}/" class="navbar-brand p-0"><!-- JibekJol -->
        <img src="/img/jj-logo-white.png">
      </a>
      <div class="dropdown me-sm-3 me-auto">
        <button class="btn btn-outline-light dropdown-toggle text-uppercase" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          {{ $lang }}
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="/kz">Kazakh</a></li>
          <li><a class="dropdown-item" href="/ru">Russian</a></li>
          <li><a class="dropdown-item" href="/en">English</a></li>
        </ul>
      </div>

      <button class="navbar-toggler p-0 border-0" type="button" id="navbarSideCollapse" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav py-2">
          <li class="nav-item">
            <a class="nav-link px-3" aria-current="page" href="/{{ $lang }}/"><i class="bi bi-house-fill text-white"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" aria-current="page" href="/{{ $lang }}/market"><i class="bi bi-shop-window text-white"></i> Market</a>
          </li>
          @auth
            <li class="nav-item">
              <a class="nav-link px-3" aria-current="page" href="/{{ $lang }}/client"><i class="bi bi-upc"></i> {{ __('Tracking') }}</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link px-3 dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person"></i> {{ __('app.my_account') }}
              </a>
              <ul class="dropdown-menu">
                <!-- <li><hr class="dropdown-divider"></li> -->
                <li><a class="dropdown-item py-2" href="/{{ $lang }}/profile"><i class="bi bi-person"></i> {{ __('app.my_profile') }}</a></li>
                <li><a class="dropdown-item py-2" href="/{{ $lang }}/profile/orders"><i class="bi bi-bag-check"></i> {{ __('app.my_orders') }}</a></li>
                <li><a class="dropdown-item py-2" href="/{{ $lang }}/client/archive"><i class="bi bi-archive"></i> {{ __('app.my_archive') }}</a></li>
              </ul>
            </li>
          @endauth
          @foreach($pages as $page)
            <li class="nav-item">
              <a class="nav-link px-3" aria-current="page" href="/{{ $lang }}/i/{{ $page->slug }}">{{ $page->title }}</a>
            </li>
          @endforeach
        </ul>

        <!-- Cart & Sign out -->
        @include('components.auth-dropdown')
      </div>
    </div>
  </nav>

  <!-- Content -->
  <main>
    @yield('content')
  </main>

  <?php
    $contactsSection = $sections->firstWhere('slug', 'contacts');
    $contacts = unserialize($contactsSection->data);
  ?>

  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <div class="container">
      <div class="row">
        
        <div class="col-md-4 d-flex align-items-center">
          <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
            <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
          </a>
          <span class="mb-3 mb-md-0 text-muted">© {{ date('Y') }} JibekJol</span>
        </div>
      </div>

      @if($sections->firstWhere('slug', 'soc-networks'))
        {!! $sections->firstWhere('slug', 'soc-networks')->content !!}
      @endif
    </div>
  </footer>

  <script src="/app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
  <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="/js/offcanvas.js"></script>

  @yield('scripts')

  @if($sections->firstWhere('slug', 'footer-code'))
    {{ $sections->firstWhere('slug', 'footer-code')->content }}
  @endif
</body>
</html>