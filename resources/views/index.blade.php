@extends('layouts.main')

@push('styles')
<style>
    
</style>
@endpush

@section('content')
    <!-- main-area -->
    <main class="fix">
        <!-- slider-area -->
        @include('layouts.common-slider', [
            'sliders' => \App\Models\rise\Sliders::where('status', 1)
                            ->where('forYoutube', 0)
                            ->get()
        ])
         
        <!-- slider-area-end --> 
         
        <!-- services-area -->

        
        @if(isset($parents) && $parents->isNotEmpty())

            @foreach($parents as $pIndex => $parent)
                @php
                    $children = $parent->children ?? collect();
                    $hasChildren = $children->isNotEmpty();
                    $isStyleOne = $pIndex % 2 === 0;
                @endphp
    
                <section class="{{ $isStyleOne ? 'services-area services-bg' : 'services__area-seven services__area-home7 services__bg-seven' }}">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="{{ $isStyleOne ? 'col-xl-6 col-lg-8' : 'col-lg-7' }}">
                                <div class="section-title text-center mb-40">
                                    @if($isStyleOne && $parent->title)
                                        <span class="sub-title">{{ $parent->title }}</span>
                                    @endif
                                    <h2 class="title {{ $isStyleOne ? 'tg-element-title' : '' }}">{{ $parent->name }}</h2>
                                </div>
                            </div>
                        </div>
    
                        @if($hasChildren)
                            <div class="services-item-wrap">
                                <div class="row justify-content-center mobile-item">
                                    @foreach($children as $child)
                                        @php
                                            $imageUrl = $child->image 
                                                ? asset('uploads/headings/' . $child->image) 
                                                : asset('assets_rise/img/services/services_img03.jpg');
                                        @endphp
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                                            <div class="services__item-five service-item-new" style="min-height: 300px;">
                                                <a href="{{ $child->link ?: '#' }}" class="service-ico">
                                                    <img src="{{ $imageUrl }}" alt="{{ $child->name ?? $child->title }}">
                                                </a>
                                                <div class="services__content-five">
                                                    <h2 class="title">
                                                        <a href="{{ $child->link ?: 'javascript:void(0);' }}">
                                                            {{ $child->name ?: $child->title }}
                                                        </a>
                                                    </h2>
                                                    <p>
                                                        @if($child->description)
                                                            {!! \Illuminate\Support\Str::limit(strip_tags($child->description), 120) !!}
                                                        @elseif($child->content)
                                                            {!! \Illuminate\Support\Str::limit(strip_tags($child->content), 120) !!}
                                                        @else
                                                            &nbsp;
                                                        @endif
                                                    </p>
                                                    <a href="{{ $child->link ?: 'javascript:void(0);' }}" class="btn">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            @endforeach
        @else
            <p class="text-center mt-4">No sections available at the moment.</p>
        @endif

        <!--youtube slider-->
        @include('layouts.common-slider', [
            'sliders' => \App\Models\rise\Sliders::where('status', 1)
                            ->where('forYoutube', 1)
                            ->get()
        ])
        
        
        <!--// footer-->
        <section class="consulting-area shortcode-consulting-block pb-50 pt-50" style="--background-color: rgb(204, 50, 40);">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="consulting-inner-wrap shine-animate-item">
                            <div class="consulting-content">
        
                                <div class="content-left">
                                    <h2 class="title">40+</h2>
                                    <span> Successful<br>RAS Selections </span>
                                </div>
        
                                <div class="content-right">
                                    <h2 class="title">Trusted by Thousands of Aspirants</h2>
        
                                    <p class="truncate-2-custom">When you choose RISE, you receive expert guidance, proven
                                        strategies, and personalized coaching that keeps you ahead in every stage of the exam.
                                    </p>
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>
        </section>    
    </main>
    <!-- main-area-end -->
        
@endsection

@push('scripts')
<script>
    console.log("Dashboard page loaded!");
</script>
@endpush