@if(isset($sliders) && $sliders->count() > 0)
<section class="slider__area shortcode-banner-slider main-home-slider">
    <div class="banner-col-2">
        <div class="swiper-container slider_baner__active slider_baner_home6">
            <div class="swiper-wrapper">
                @foreach($sliders->chunk(3) as $sliderChunk)
                    <div class="swiper-slide slide__home7">
                        <div class="row">
                            @foreach($sliderChunk as $slider)
                                <div class="col-md-4">
                                    @if(!empty($slider->image_url))
                                        <a href="{{ $slider->image_url }}" target="_blank">
                                            <img src="{{ asset($slider->image) }}" 
                                                 alt="Slider Image" 
                                                 style="width:100%; height:auto;">
                                        </a>
                                    @else
                                        <img src="{{ asset($slider->image) }}" 
                                             alt="Slider Image" 
                                             style="width:100%; height:auto;">
                                    @endif
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="box-button-slider-bottom">
            <div class="testimonial__nav-four">
                <div class="testimonial-two-button-prev button-swiper-prev">
                    <i class="flaticon-right-arrow"></i>
                </div>
                <div class="testimonial-two-button-next button-swiper-next">
                    <i class="flaticon-right-arrow"></i>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
