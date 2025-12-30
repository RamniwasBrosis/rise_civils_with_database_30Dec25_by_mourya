@extends('layouts.main')

@push('styles')
<style>
    .whatsico {
        position: fixed;
        right: 0;
        top: 20%;
        background: #25D366;
        z-index: 100;
        color: #fff;
        padding: 10px 10px 10px 12px;
        border-radius: 10px 0 0 10px;
    }
    .whatsico svg {
        fill: #fff;
        width: 30px;
        height: 30px;
    }
</style>
@endpush

@section('content')
<main class="fix"> 

    <div class="container pt-3"><x-breadcrumbs :main="$parentCategory" :sub="$childCategory" /></div>
    <!-- blog-area -->
    <section class="blog__area">
        <div class="container">
            <div class="blog__inner-wrap">
                <div class="row">
                    <div class="col-70">
                        <div class="blog-post-wrap">
                            
                            <h2 class="text-danger">
                                {{$childCategory->name}}
                            </h2>
                            <small style="color:#000;">{!! $childCategory->description !!}</small>
                            
                            <div class="row gutter-24">
                                @forelse ($categories as $category)
                                    <div>
                                        <div class="blog__post-two shine-animate-item">
                                            <div class="blog__post-content-two">
                                        
                                                {{-- Accordion Header --}}
                                                <h2 class="title">
                                                    <a href="javascript:void(0);" 
                                                       class="toggle-topics" 
                                                       data-target="topics-{{ $category->id }}">
                                                        {{ $category->name }}
                                                        <span style="font-size:12px;">&#9662;</span>
                                                    </a>
                                                </h2>
                                        
                                                {{-- Hidden Accordion Content --}}
                                                <ul id="topics-{{ $category->id }}" 
                                                    class="topics-list" 
                                                    style="display:none; list-style:none; margin-left:20px;">
                                                    @forelse ($category->posts->where('showOnFront', 1) as $topic)
                                                        <li>
                                                            <a href="{{ $topic->slug 
                                                                ? route('category.posts', [
                                                                    'categorySlug' => $category->parent->slug ?? $category->slug,
                                                                    'parentSlug' => $category->slug,
                                                                    'slug' => $topic->slug
                                                                  ]) 
                                                                : '#' }}">
                                                                {{ $topic->name }}
                                                            </a>

                                                        </li>
                                                    @empty
                                                        <li>No Topics Available</li>
                                                    @endforelse
                                                </ul>
                                        
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-center">No Subcategories Available</p>
                                @endforelse
                            </div>

                            {{-- Laravel Dynamic Pagination --}}
                            <div class="pagination-wrap mt-40">
                                {{ $categories->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>

                    <div class="col-30">
                        <aside class="blog__sidebar">
                            <div class="sidebar__widget">
                                <h4 class="sidebar__widget-title">Related Categories</h4>
                                <div class="sidebar__cat-list">
                                    <ul class="list-wrap">
                                        @foreach ($categoriesForSidebar as $category)
                                            @if ($category->slug)
                                                <li>
                                                    <a href="{{ route('category.innerSubCategory', [
                                                        'parentSlug' => $parentCategory->slug, 
                                                        'slug' => $category->slug
                                                    ]) }}">
                                                        <i class="flaticon-arrow-button"></i> {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </aside>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- blog-area-end --> 
</main>

{{-- WhatsApp floating icon --}}
<a href="https://wa.me/919785606061" target="_blank" class="whatsico">
    <svg fill="#000000" width="800px" height="800px" viewBox="-1.66 0 740.824 740.824" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M630.056 107.658C560.727 38.271 468.525.039 370.294 0 167.891 0 3.16 164.668 3.079 367.072c-.027 64.699 16.883 127.855 49.016 183.523L0 740.824l194.666-51.047c53.634 29.244 114.022 44.656 175.481 44.682h.151c202.382 0 367.128-164.689 367.21-367.094.039-98.088-38.121-190.32-107.452-259.707m-259.758 564.8h-.125c-54.766-.021-108.483-14.729-155.343-42.529l-11.146-6.613-115.516 30.293 30.834-112.592-7.258-11.543c-30.552-48.58-46.689-104.729-46.665-162.379C65.146 198.865 202.065 62 370.419 62c81.521.031 158.154 31.81 215.779 89.482s89.342 134.332 89.311 215.859c-.07 168.242-136.987 305.117-305.211 305.117m167.415-228.514c-9.176-4.591-54.286-26.782-62.697-29.843-8.41-3.061-14.526-4.591-20.644 4.592-6.116 9.182-23.7 29.843-29.054 35.964-5.351 6.122-10.703 6.888-19.879 2.296-9.175-4.591-38.739-14.276-73.786-45.526-27.275-24.32-45.691-54.36-51.043-63.542-5.352-9.183-.569-14.148 4.024-18.72 4.127-4.11 9.175-10.713 13.763-16.07 4.587-5.356 6.116-9.182 9.174-15.303 3.059-6.122 1.53-11.479-.764-16.07-2.294-4.591-20.643-49.739-28.29-68.104-7.447-17.886-15.012-15.466-20.644-15.746-5.346-.266-11.469-.323-17.585-.323-6.117 0-16.057 2.296-24.468 11.478-8.41 9.183-32.112 31.374-32.112 76.521s32.877 88.763 37.465 94.885c4.587 6.122 64.699 98.771 156.741 138.502 21.891 9.45 38.982 15.093 52.307 19.323 21.981 6.979 41.983 5.994 57.793 3.633 17.628-2.633 54.285-22.19 61.932-43.616 7.646-21.426 7.646-39.791 5.352-43.617-2.293-3.826-8.41-6.122-17.585-10.714"/>
    </svg>
</a>
@endsection
@push('scripts')
<script>
    jQuery(function($) {
        console.log("Accordion script running in inner-category-blog");
    
        $('.toggle-topics').on('click', function(e) {
            e.preventDefault();
    
            let target = $(this).data('target');
            let $targetEl = $('#' + target);
    
            // Close other accordions
            $('.topics-list').not($targetEl).slideUp();
    
            // Toggle selected
            $targetEl.slideToggle();
        });
    });
</script>
@endpush
