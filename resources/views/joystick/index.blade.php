@extends('joystick.layout')

@section('content')

  @include('components.alerts')

  <div class="row pt-4">
    <div class="col-md-4 mb-3">
      <div class="card text-center h-100">
        <div class="card-body">
          <h3 class="card-title">Количество<br> заявок</h3>
          <h2 class="card-text">{{ $countApps }}</h2>
        </div>
      </div> 
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center h-100">
        <div class="card-body">
          <h3 class="card-title">Количество<br> пользователей</h3>
          <h2 class="card-text">{{ $countUsers }}</h2>
        </div>
      </div> 
    </div>
    <div class="col-md-4 mb-3">
      <div class="card text-center h-100">
        <div class="card-body">
          <h3 class="card-title">Количество<br> новостей</h3>
          <h2 class="card-text">{{ $countPosts }}</h2>
        </div>
      </div> 
    </div>

    <div class="col-12 mt-4 text-center">
      <img src="/joystick/bg-joystick.png" class="img-fluid mx-auto d-block">
    </div>
  </div>

@endsection