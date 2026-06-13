@props(['attribute', 'content'])

<div class="card">
  <ul id="toolbar" class="list-group list-group-flush">
    <li class="list-group-item">
    <div class="btn-toolbar">
      <select id="headingSelect" class="form-select me-2 my-1" style="width:auto;">
        <option value="">Paragraph</option>
        <option value="h1">Heading 1</option>
        <option value="h2">Heading 2</option>
        <option value="h3">Heading 3</option>
        <option value="h4">Heading 4</option>
        <option value="h5">Heading 5</option>
        <option value="h6">Heading 6</option>
      </select>
      <select id="fontFamilySelect" class="form-select me-2 my-1" style="width:auto;">
        <option value="" disabled>Font Family</option>
      </select>
      <select id="fontSizeSelect" class="form-select me-2 my-1" style="width:auto;">
        <option value="" disabled>Font Size</option>
      </select>
      <div class="btn-group me-2 my-1">
        <button class="btn btn-outline-secondary" data-command="bold" title="Bold"><i class="bi bi-type-bold"></i></button>
        <button class="btn btn-outline-secondary" data-command="italic" title="Italic"><i class="bi bi-type-italic"></i></button>
        <button class="btn btn-outline-secondary" data-command="underline" title="Underline"><i class="bi bi-type-underline"></i></button>
      </div>
    </div>
    </li>
    <li class="list-group-item">
    <div class="btn-toolbar">
      <div class="btn-group me-2 my-1">
        <button class="btn btn-outline-secondary" data-command="justifyLeft" title="Align Left"><i class="bi bi-text-left"></i></button>
        <button class="btn btn-outline-secondary" data-command="justifyCenter" title="Align Center"><i class="bi bi-text-center"></i></button>
        <button class="btn btn-outline-secondary" data-command="justifyRight" title="Align Right"><i class="bi bi-text-right"></i></button>
      </div>
      <div class="btn-group me-2 my-1">
        <button class="btn btn-outline-secondary" data-command="insertUnorderedList" title="Bullet List"><i class="bi bi-list-ul"></i></button>
        <button class="btn btn-outline-secondary" data-command="insertOrderedList" title="Numbered List"><i class="bi bi-list-ol"></i></button>
        <button class="btn btn-outline-secondary" data-command="insertCircleList" title="Circle List"><i class="bi bi-record-circle"></i></button>
        <button class="btn btn-outline-secondary" data-command="insertSquareList" title="Square List"><i class="bi bi-square"></i></button>
      </div>
      <div class="btn-group me-2 my-1">
        <button class="btn btn-outline-secondary" data-command="createLink" title="Insert Link"><i class="bi bi-link"></i></button>
        <button class="btn btn-outline-secondary" data-command="insertImage" title="Insert Image"><i class="bi bi-image"></i></button>
        <button class="btn btn-outline-secondary" data-command="insertTable" title="Insert Table"><i class="bi bi-table"></i></button>
      </div>
      <div class="dropdown me-2 my-1">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Functions
        </button>
        <div class="dropdown-menu"> 
          <div class="btn-group m-2">
            <button class="btn btn-outline-secondary bi bi-emoji-smile" data-command="insertEmoji" title="Insert Emoji"></button>
            <button class="btn btn-outline-secondary bi bi-hash" data-command="insertSymbol" title="Insert Symbol"></button>
            <button class="btn btn-outline-secondary bi bi-palette" data-command="insertColor" title="Text Color"></button>
          </div>
          <div class="btn-group m-2">
            <button class="btn btn-outline-secondary" data-command="undo" title="Undo"><i class="bi bi-arrow-counterclockwise"></i></button>
            <button class="btn btn-outline-secondary" data-command="redo" title="Redo"><i class="bi bi-arrow-clockwise"></i></button>
          </div>
          <div class="btn-group m-2">
            <button class="btn btn-outline-secondary" data-command="cut" title="Cut"><i class="bi bi-scissors"></i></button>
            <button class="btn btn-outline-secondary" data-command="copy" title="Copy"><i class="bi bi-files"></i></button>
            <button class="btn btn-outline-secondary" data-command="paste" title="Paste"><i class="bi bi-clipboard"></i></button>
          </div>
        </div>
      </div>
      <div class="btn-group me-2 my-1">
        <button class="btn btn-outline-secondary" data-command="toggleSource" title="Toggle Source"><i class="bi bi-code-slash"></i></button>
      </div>

    </div>
    </li>
  </ul>
  <div>
    <div id="editor" class="form-control" contenteditable="true" style="min-height: 300px; max-height:700px; overflow-y: auto;">{!! $content !!}</div>
    <textarea id="content" name="{{ $attribute }}" class="d-none"></textarea>
    <textarea id="sourceView" class="form-control d-none" style="height: 300px; font-family: monospace;">{!! $content !!}</textarea>
  </div>
</div>
