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
    padding: 10px 12px;
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
    <section class="blog__area">
        <div class="container">
            <div class="blog__inner-wrap">
                <div class="row">
                    <div class="col-70">
                        <div class="blog__details-wrap">
                            <h2 class="my-5 text-danger">{{ $category->name ?? '' }}</h2>
                            <div class="blog__details-content">
                                {!! $post->content !!}
                            </div>
                        </div>
                        @if (!empty($post->pdf))
                            <a href="{{ route('pdf.download', $post->slug) }}" 
                               class="btn mb-3 w-full justify-center">
                                Download PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- WhatsApp floating icon --}}
<a href="https://wa.me/919785606061" target="_blank" class="whatsico">
    {{-- SVG here --}}
</a>
@endsection

@push('scripts')
<script>
jQuery(window).on('load', function() {
    $('.toggle-topics').off('click').on('click', function(e) {
        e.preventDefault();
        let target = $(this).data('target');
        let $targetEl = $('#' + target);

        // Close other open accordions
        $('.topics-list').not($targetEl).slideUp();

        // Toggle this one
        $targetEl.stop(true, true).slideToggle();
    });
});
</script>
@endpush
