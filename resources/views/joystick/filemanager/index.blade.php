@extends('joystick.layout')

@section('head')
  <link href="/joystick/css/filemanager.css" rel="stylesheet">
@endsection

@section('content')
  <div class="py-4">

    <div class="row align-items-center mb-3">
      <div class="col-md-6 col-xs-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="/{{ app()->getLocale() }}/admin/filemanager"><i class="material-icons align-middle">home</i></a></li>
            @if ($path)
              @php $crumbs = explode('/', $path); $currentPath = ''; @endphp
              @foreach ($crumbs as $crumb)
                @php $currentPath .= ($currentPath == '' ? '' : '/') . $crumb; @endphp
                @if ($loop->last)
                  <li class="breadcrumb-item active" aria-current="page">{{ $crumb }}</li>
                @else
                  <li class="breadcrumb-item"><a href="/{{ app()->getLocale() }}/admin/filemanager?path={{ $currentPath }}">{{ $crumb }}</a></li>
                @endif
              @endforeach
            @endif
          </ol>
        </nav>
      </div>

      <div class="col-md-6 col-xs-12 text-end">
        <button type="button" class="btn btn-outline-secondary m-2" data-bs-toggle="modal" data-bs-target="#newFolderModal">
          <i class="material-icons align-middle">create_new_folder</i> Создать
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
          <i class="material-icons align-middle">file_upload</i> Загрузить
        </button>
      </div>
    </div>

    <!-- Errors if any -->
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="row g-3">
      @if ($path)
        @php $parentPath = dirname($path); $parentPath = $parentPath == '.' ? '' : $parentPath; @endphp
        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
          <a href="/{{ app()->getLocale() }}/admin/filemanager?path={{ $parentPath }}" class="fm-item fm-folder bg-white">
            <i class="material-icons fm-icon">reply</i>
            <div class="fm-name">...</div>
          </a>
        </div>
      @endif

      @foreach ($directories as $dir)
        @php $dirName = basename($dir); @endphp
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 position-relative">
          <a href="/{{ app()->getLocale() }}/admin/filemanager?path={{ $dir }}" class="fm-item fm-folder bg-white">
            <i class="material-icons fm-icon">folder</i>
            <div class="fm-name">{{ $dirName }}</div>
          </a>
          <form action="/{{ app()->getLocale() }}/admin/filemanager/delete" method="POST" class="position-absolute" style="top:5px; right:15px;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="path" value="{{ $path }}">
            <input type="hidden" name="item" value="{{ $dirName }}">
            <input type="hidden" name="type" value="dir">
            <button type="submit" class="btn btn-sm btn-link text-secondary p-0 m-0" onclick="return confirm('Удалить папку? Все содержимое будет удалено!');"><i class="material-icons" style="font-size: 1.1rem">close</i></button>
          </form>
        </div>
      @endforeach

      @foreach ($files as $file)
        @php
            $fileName = basename($file); 
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
        @endphp
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 position-relative">
          <div class="fm-item bg-white" onclick="prompt('Скопируйте ссылку', '/files/{{ $file }}')">
            @if ($isImage)
                <img src="/files/{{ $file }}" class="img-fluid fm-img-thumbnail" alt="{{ $fileName }}">
            @else
                <i class="material-icons fm-icon">insert_drive_file</i>
            @endif
            <div class="fm-name" title="{{ $fileName }}">{{ $fileName }}</div>
          </div>
          <form action="/{{ app()->getLocale() }}/admin/filemanager/delete" method="POST" class="position-absolute" style="top:5px; right:15px;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="path" value="{{ $path }}">
            <input type="hidden" name="item" value="{{ $fileName }}">
            <input type="hidden" name="type" value="file">
            <button type="submit" class="btn btn-sm btn-link text-secondary p-0 m-0" onclick="return confirm('Удалить файл?');"><i class="material-icons" style="font-size: 1.1rem">close</i></button>
          </form>
        </div>
      @endforeach

    </div>
  </div>

  <!-- New Folder Modal -->
  <div class="modal fade" id="newFolderModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="/{{ app()->getLocale() }}/admin/filemanager/mkdir" method="POST">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Создать папку</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="path" value="{{ $path }}">
            <div class="mb-3">
              <label class="form-label">Название папки</label>
              <input type="text" class="form-control" name="new_dir" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-primary">Создать</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Upload Modal -->
  <div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
      <form action="/{{ app()->getLocale() }}/admin/filemanager/upload" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Загрузить файл</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="path" value="{{ $path }}">
            <div class="mb-3">
              <label class="form-label">Выберите файл</label>
              <input class="form-control" type="file" name="file" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
            <button type="submit" class="btn btn-primary">Загрузить</button>
          </div>
        </div>
      </form>
    </div>
  </div>

@endsection

@section('scripts')

@endsection