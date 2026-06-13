<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Joystick Admin</title>
    <meta name="description" content="Joystick Admin">
    <meta name="author" content="issa.adilet@gmail.com">
    <link rel="icon" href="/joystick/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="/joystick/favicon.png" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/node_modules/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/joystick/css/admin.css" rel="stylesheet">
    <script src="https://unpkg.com/htmx.org@1.9.6"></script>
    @yield('head')

  </head>
  <body class="bg-light">
    <nav class="navbar navbar-dark bg-dark fixed-top navbar-expand-lg">
      <div class="container-fluid">
        <a class="navbar-brand text-uppercase d-flex align-items-center" href="/{{ $lang }}/admin">
          <i class="material-icons text-primary me-1">sports_esports</i> <b>Joystick</b>
        </a>

        <ul class="navbar-nav">
          <li class="nav-item- dropdown">
            <a class="nav-link dropdown-toggle text-uppercase" data-bs-toggle="dropdown" href="#" aria-expanded="false">{{ app()->getLocale() }}</a>
            <ul class="dropdown-menu dropdown-menu-end position-absolute">
              <li><a class="dropdown-item" href="/en/admin">English</a></li>
              <li><a class="dropdown-item" href="/kz/admin">Қазақша</a></li>
              <li><a class="dropdown-item" href="/ru/admin">Русский</a></li>
            </ul>
          </li>
        </ul>

        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="joystickNavbar">
          <ul class="navbar-nav ms-auto">
            <li class="dropdown">
              <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                <i class="material-icons md-20">person_outline</i> {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end" role="menu">
                <li>
                  <a class="dropdown-item" href="{{ route('logout', $lang) }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Exit') }} </a>
                  <form id="logout-form" action="{{ route('logout', $lang) }}" method="POST" class="d-none">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="sidebar col-lg-2 col-md-9">
          <div class="offcanvas-md offcanvas-end" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="sidebarMenuLabel"></h5>
              <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
            </div>
          

            <div class="offcanvas-body d-md-flex flex-column">
              <div class="btn-sidebar d-flex justify-content-between align-items-center" role="button" data-bs-toggle="collapse" data-bs-target="#sidebarCargo" aria-expanded="true" aria-controls="sidebarCargo">{{ __('Cargo') }} <i class="material-icons">expand_more</i></div>
              <ul class="nav flex-column nav-pills collapse show" id="sidebarCargo">
                <li class="nav-item"><a href="/{{ $lang }}/admin/tracks" class="nav-link"><i class="material-icons md-20">local_shipping</i> {{ __('Tracking') }}</a></li>
                <li class="nav-item"><a href="/{{ $lang }}/admin/statuses" class="nav-link"><i class="material-icons md-20">done_all</i> {{ __('Statuses') }}</a></li>
                @can('viewAny', App\Models\Branch::class)<li class="nav-item"><a href="/{{ $lang }}/admin/branches" class="nav-link"><i class="material-icons md-20">home_work</i> {{ __('Branches') }}</a></li>@endcan
              </ul>

              <div class="btn-sidebar d-flex justify-content-between align-items-center" role="button" data-bs-toggle="collapse" data-bs-target="#sidebarContent" aria-expanded="true" aria-controls="sidebarContent">{{ __('Content') }} <i class="material-icons">expand_more</i></div>
              <ul class="nav flex-column nav-pills collapse show" id="sidebarContent">
                @can('viewAny', App\Models\Page::class)<li class="nav-item"><a href="/{{ $lang }}/admin/pages" class="nav-link"><i class="material-icons md-20">content_copy</i> {{ __('Pages') }}</a></li>@endcan
                @can('viewAny', App\Models\Post::class)<li class="nav-item"><a href="/{{ $lang }}/admin/posts" class="nav-link"><i class="material-icons md-20">create</i> {{ __('Posts') }}</a></li>@endcan
                @can('viewAny', App\Models\Section::class)<li class="nav-item"> <a href="/{{ $lang }}/admin/sections" class="nav-link"><i class="material-icons md-20">dashboard</i> {{ __('Sections') }}</a></li>@endcan
                @can('viewAny', App\Models\Category::class)<li class="nav-item"><a href="/{{ $lang }}/admin/categories" class="nav-link"><i class="material-icons md-20">category</i> {{ __('Categories') }}</a></li>@endcan
                @can('viewAny', App\Models\Product::class)<li class="nav-item"><a href="/{{ $lang }}/admin/products" class="nav-link"><i class="material-icons md-20">store</i> {{ __('Products') }}</a></li>@endcan
                @can('allow-filemanager', Auth::user())<li class="nav-item"><a href="/{{ $lang }}/admin/filemanager" class="nav-link"><i class="material-icons md-20">folder</i> {{ __('File manager') }}</a></li>@endcan
                @can('viewAny', App\Models\Banner::class)<li class="nav-item"><a href="/{{ $lang }}/admin/banners" class="nav-link"><i class="material-icons md-20">collections</i> {{ __('Banners') }}</a></li>@endcan
                @can('viewAny', App\Models\Mode::class)<li class="nav-item"><a href="/{{ $lang }}/admin/modes" class="nav-link"><i class="material-icons md-20">style</i> {{ __('Modes') }}</a></li>@endcan
                @can('viewAny', App\Models\Option::class)<li class="nav-item"><a href="/{{ $lang }}/admin/options" class="nav-link"><i class="material-icons md-20">label_outline</i> {{ __('Options') }}</a></li>@endcan
                <?php $ordersCount = App\Models\Order::where('status', '!=', 3)->count(); ?>
                @can('viewAny', App\Models\Order::class)<li class="nav-item"><a href="/{{ $lang }}/admin/orders" class="nav-link"><i class="material-icons md-20">shopping_cart</i> {{ __('Orders') }} <span class="badge text-bg-primary rounded-pill">{{ $ordersCount }}</span></a></li>@endcan
                @can('viewAny', App\Models\App::class)<li class="nav-item"><a href="/{{ $lang }}/admin/apps" class="nav-link"><i class="material-icons md-20">send</i> {{ __('Applications') }} <span class="badge text-bg-primary rounded-pill">{{ App\Models\App::where('status', '!=', 2)->count() }}</span></a></li>@endcan
              </ul>

              <div class="btn-sidebar d-flex justify-content-between align-items-center" role="button" data-bs-toggle="collapse" data-bs-target="#sidebarResources" aria-expanded="true" aria-controls="sidebarResources">{{ __('Resources') }} <i class="material-icons">expand_more</i></div>
              <ul class="nav flex-column nav-pills collapse show" id="sidebarResources">
                @can('viewAny', App\Models\Region::class)<li class="nav-item"><a href="/{{ $lang }}/admin/regions" class="nav-link"><i class="material-icons md-20">map</i> {{ __('Regions') }}</a></li>@endcan
                @can('viewAny', App\Models\Company::class)<li class="nav-item"><a href="/{{ $lang }}/admin/companies" class="nav-link"><i class="material-icons md-20">business</i> {{ __('Companies') }}</a></li>@endcan
                @can('viewAny', App\Models\User::class)<li class="nav-item"><a href="/{{ $lang }}/admin/users" class="nav-link"><i class="material-icons md-20">people_outline</i> {{ __('Users') }}</a></li>@endcan
                @can('viewAny', App\Models\Role::class)<li class="nav-item"><a href="/{{ $lang }}/admin/roles" class="nav-link"><i class="material-icons md-20">accessibility</i> {{ __('Roles') }}</a></li>@endcan
                @can('viewAny', App\Models\Permission::class)<li class="nav-item"><a href="/{{ $lang }}/admin/permissions" class="nav-link"><i class="material-icons md-20">lock_open</i> {{ __('Permissions') }}</a></li>@endcan
                @can('viewAny', App\Models\Currency::class)<li class="nav-item"><a href="/{{ $lang }}/admin/currencies" class="nav-link"><i class="material-icons md-20">attach_money</i> {{ __('Currencies') }}</a></li>@endcan
                @can('viewAny', App\Models\Unit::class)<li class="nav-item"><a href="/{{ $lang }}/admin/units" class="nav-link"><i class="material-icons md-20">balance</i> {{ __('Units') }}</a></li>@endcan
                @can('viewAny', App\Models\Language::class)<li class="nav-item"><a href="/{{ $lang }}/admin/languages" class="nav-link"><i class="material-icons md-20">language</i> {{ __('Languages') }}</a></li>@endcan
              </ul>

              <ul class="nav flex-column nav-pills mt-3">
                <li class="nav-item"><a href="{{ route('logout', $lang) }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons md-20">exit_to_app</i> {{ __('Exit') }}</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="main col-lg-10 col-md-9 mb-3">
          @yield('content')
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @yield('scripts')
  </body>
</html>
