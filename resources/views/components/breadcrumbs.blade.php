<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item border-bottom border-dark"><a href="{{ url('/') }}">Home</a></li>

    @isset($main)
      <li class="breadcrumb-item border-bottom border-dark">
        <a href="{{ route('category.blog', $main->slug) }}">{{ $main->name }}</a>
      </li>
    @endisset

    @isset($sub)
      <li class="breadcrumb-item border-bottom border-dark">
        <a href="{{ route('category.innerSubCategory', ['parentSlug' => $main->slug, 'slug' => $sub->slug]) }}">
            {{ $sub->name }}
        </a>
      </li>
    @endisset
    
    @isset($page)
      <li class="breadcrumb-item active border-bottom border-dark" aria-current="page">
          {{ $page->name }}
      </li>
    @endisset
  </ol>
</nav>
