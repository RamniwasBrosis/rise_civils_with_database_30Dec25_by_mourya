@extends('layouts.main')

@push('styles')
<style>

.page_content p, h1, h2, h3, h4{
    color: #000; !important
}
    
</style>
@endpush
 
 
@section('content')  
        <!-- main-area -->
        <main class="fix"> 
        
            <div class="container pt-3"> <x-breadcrumbs /> </div>
            <!-- blog-area -->
            <section class="blog__area">
                <div class="container">
                    <div class="blog__inner-wrap">
                        <div class="row mb-5">
                            <small class="page_content">{!! $type->page_content !!} </small>
                        </div>
                        <div class="row">
                            <div class="col-100">
                                <div class="blog-post-wrap">
                                    <div class="row gutter-24">
                                        @foreach ($categories as $category)
                                            <div class="col-md-3">
                                                <div class="blog__post-two shine-animate-item">
                                                    <div class="blog__post-thumb-two">
                                                        <a href="{{ route('category.blog', $category->slug) }}" class="shine-animate">
                                                            <img src="{{ asset($category->cat_image ?? 'assets_rise/img/logo/rise_logo.jpg') }}" alt="{{ $category->name }}" style="min-height: 300px;"/>
                                                        </a>
                                                    </div>
                                                    <div class="blog__post-content-two">
                                                        <h2 class="title">
                                                            <a href="{{ route('category.blog', $category->slug) }}">
                                                                {{ $category->name }}
                                                            </a>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="pagination-wrap mt-40">
                                        {{ $categories->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- blog-area-end --> 
        </main>
        <!-- main-area-end -->
@endsection




@push('scripts')
<script>
    console.log("Dashboard page loaded!");
</script>
@endpush