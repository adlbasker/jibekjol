@extends('joystick.layout')

@section('content')
  <h2 class="page-header">Статьи</h2>

  @include('components.alerts')

  <div class="text-end mb-3">
    <a href="/{{ $lang }}/admin/posts/create" class="btn btn-success"><i class="material-icons">add</i></a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-sm table-hover">
      <thead>
        <tr class="table-active">
          <th style="width: 50px;">№</th>
          <th>Картинка</th>
          <th>Название</th>
          <th>URI</th>
          <th>Заголовок</th>
          <th style="width: 80px;">Номер</th>
          <th>Язык</th>
          <th>Статус</th>
          <th class="text-end">Функции</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @foreach ($posts as $post)
          <tr>
            <td>{{ $i++ }}</td>
            <td><img src="/img/posts/{{ ($post->image == 'no-image-middle.png') ? 'no-image-mini.png' : 'present-'.$post->image }}" class="img-fluid" style="width:80px; height:auto;"></td>
            <td>{{ $post->title }}</td>
            <td>{{ $post->slug }}</td>
            <td>{{ $post->headline }}</td>
            <td>{{ $post->sort_id }}</td>
            <td>{{ $post->lang }}</td>
            <td class="text-{{ __('statuses.data.'.$post->status.'.style') }}">{{ __('statuses.data.'.$post->status.'.title') }}</td>
            <td class="text-end text-nowrap">
              <a class="btn btn-link btn-sm" href="/{{ $lang }}/admin/posts/{{ $post->id }}/copy" title="Копия контента" onclick="return confirm('Копировать запись?')"><i class="material-icons md-18">content_copy</i></a>
              <a class="btn btn-link btn-sm" href="{{ route('posts.edit', [$lang, $post->id]) }}" title="Редактировать"><i class="material-icons">mode_edit</i></a>
              <form method="POST" action="{{ route('posts.destroy', [$lang, $post->id]) }}" accept-charset="UTF-8" class="btn-delete">
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
    {{ $posts->links() }}
  </div>

@endsection