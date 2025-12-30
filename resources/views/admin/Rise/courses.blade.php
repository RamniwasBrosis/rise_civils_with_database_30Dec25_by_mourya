@extends('layouts.main')
@section('content')  
<main class="fix">

    <section class="blog__area pt-40 pb-40">
        <div class="container">
            <div class="row gutter-24">

                @forelse ($courses as $course)
                    <div class="col-lg-3 col-md-6 mt-5">
                        <div class="blog__post-two shine-animate-item"
                             style="min-height: 515px;">

                            {{-- Thumbnail --}}
                            <div class="blog__post-thumb-two">
                                <a href="{{ $course->link }}" 
                                   target="_blank"
                                   class="shine-animate">
                                    <img
                                        src="{{ $course->thumbnail 
                                                ? asset($course->thumbnail) 
                                                : asset('assets_rise/img/logo/rise_logo.jpg') }}"
                                        alt="{{ $course->title }}"
                                        style="
                                            width:100%;
                                            height:260px;
                                            object-fit:cover;
                                            object-position:center;
                                        ">
                                </a>
                            </div>

                            {{-- Content --}}
                            <div class="blog__post-content-two">

                                <h2 class="title">
                                    <a href="{{ $course->link }}" target="_blank">
                                        {{ $course->title }}
                                    </a>
                                </h2>

                                @if($course->description)
                                    <p class="page_content">
                                        {{ Str::limit(strip_tags($course->description), 120) }}
                                    </p>
                                @endif

                                {{-- Price --}}
                                @if($course->price)
                                    <div class="mt-2">
                                        <strong>₹ {{ number_format($course->price) }}</strong>
                                    </div>
                                @endif

                                {{-- CTA --}}
                                <div class="mt-3">
                                    <a href="{{ $course->link }}" 
                                       target="_blank"
                                       class="btn btn-sm btn-info">
                                        View Course
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No courses available</p>
                    </div>
                @endforelse

            </div>
        </div>
    </section>

</main>
@endsection
