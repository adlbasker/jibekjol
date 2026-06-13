@if($productsLang->count() > 0)
  <div class="dropdown-menu d-block pt-0 w-100 shadow overflow-hidden" style="position: absolute;">
    <ul class="list-unstyled mb-0">
      @foreach($productsLang as $productLang)
        <li>
          <a href="/{{ $lang }}/market/{{ $productLang->product_id.'-'.$productLang->slug }}" class="dropdown-item d-flex align-items-center gap-2 py-2"><i class="bi bi-search"></i> {{ $productLang->title }}</a>
        </li>
      @endforeach
    </ul>
  </div>
@endif