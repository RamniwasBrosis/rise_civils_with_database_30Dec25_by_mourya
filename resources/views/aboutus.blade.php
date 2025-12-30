@extends('layouts.main')

@push('styles')
<style>
    
</style>
@endpush

@section('content')
    <main class="fix"> 
        <!-- about-area -->
        <section class="about__area-five">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="about__content-five">
                            <div class="section-title mb-30">
                                <h2 class="title">
                                    {{$about->title}}
                                </h2>
                            </div>
                            <div class="about__img-wrap-five">
                                <img src="{{ asset($about->image) }}" alt="" style="width: 100%;"/>
                                <div class="experience-year">
                                    <div class="icon">
                                        <i class="flaticon-trophy"></i>
                                    </div>
                                    <!--<div class="content">-->
                                    <!--    <h6 class="circle rotateme">Years Of - Experience 25 -</h6>-->
                                    <!--</div>-->
                                </div>
                            </div>
                            {!! $about->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-area-end -->
        <!-- counter-area -->
        <!-- <section class="counter-area">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-trophy"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="45"></span>+</h2>
                                <p>
                                    Successfully <br />
                                    Completed Projects
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-happy"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="92"></span>K</h2>
                                <p>
                                    Satisfied <br />
                                    100% Our Clients
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-china"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="19"></span>+</h2>
                                <p>
                                    All Over The World <br />
                                    We Are Available
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="counter-item">
                            <div class="icon">
                                <i class="flaticon-time"></i>
                            </div>
                            <div class="content">
                                <h2 class="count"><span class="odometer" data-count="25"></span>+</h2>
                                <p>
                                    Years of Experiences <br />
                                    To Run This Company
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="counter-shape-wrap">
                <img class="dark-opacity" src="assets/img/images/counter_shape01.png" alt="Apexa" data-aos="fade-right" data-aos-delay="400" />
                <img src="assets/img/images/counter_shape02.png" alt="Apexa" data-parallax='{"x" : 100 , "y" : -100 }' />
                <img class="dark-opacity" src="assets/img/images/counter_shape03.png" alt="Apexa" data-aos="fade-left" data-aos-delay="400" />
            </div>
        </section> -->
        <!-- counter-area-end -->
        <!-- request-area -->
        <!-- <section class="request-area request-bg" data-background="assets/img/bg/request_bg.jpg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="request-content text-center tg-heading-subheading animation-style3">
                            <h2 class="title tg-element-title text-white">Offering The Best Experience Of Business Consulting Services</h2>
                            <div class="content-bottom">
                                <a href="tel:0123456789" class="btn text-white">Request a Free Call</a>
                                <div class="content-right">
                                    <div class="icon">
                                        <i class="flaticon-phone-call"></i>
                                    </div>
                                    <div class="content">
                                        <span class="text-white">Toll Free Call</span>
                                        <a class="text-white" href="tel:0123456789">+ 88 ( 9600 ) 6002</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="request-shape">
                <img src="assets/img/images/request_shape01.png" alt="Apexa" data-aos="fade-right" data-aos-delay="400" />
                <img src="assets/img/images/request_shape02.png" alt="Apexa" data-aos="fade-left" data-aos-delay="400" />
            </div>
        </section> -->
        <!-- request-area-end -->
        <!-- team-area -->
        <!-- <section class="team__area-three">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-7 col-lg-6">
                        <div class="section-title mb-50">
                            <span class="sub-title">MEET OUR TEAM</span>
                            <h2 class="title">
                                Financial Expertise You <br />
                                Can Trust
                            </h2>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6">
                        <div class="section-content">
                            <p>Our power of choice is untrammelled and when nothing preven tsbeing able to do what we like best every pleasure.</p>
                        </div>
                    </div>
                </div>
                <div class="row gutter-24 justify-content-center">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team__item-three shine-animate-item">
                            <div class="team__thumb-three shine-animate">
                                <img src="assets/img/team/h3_team_img01.jpg" alt="Apexa" />
                            </div>
                            <div class="team__content-three">
                                <h4 class="title"><a href="team-details.html">Brooklyn Simmons</a></h4>
                                <span>Finance Advisor</span>
                            </div>
                            <div class="team-social team__social-three">
                                <ul class="list-wrap">
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a>
                                    </li>
                                </ul>
                                <div class="social-toggle-icon">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team__item-three shine-animate-item">
                            <div class="team__thumb-three shine-animate">
                                <img src="assets/img/team/h3_team_img02.jpg" alt="Apexa" />
                            </div>
                            <div class="team__content-three">
                                <h4 class="title"><a href="team-details.html">Eleanor Pena</a></h4>
                                <span>Finance Advisor</span>
                            </div>
                            <div class="team-social team__social-three">
                                <ul class="list-wrap">
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a>
                                    </li>
                                </ul>
                                <div class="social-toggle-icon">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team__item-three shine-animate-item">
                            <div class="team__thumb-three shine-animate">
                                <img src="assets/img/team/h3_team_img03.jpg" alt="Apexa" />
                            </div>
                            <div class="team__content-three">
                                <h4 class="title"><a href="team-details.html">Floyd Miles</a></h4>
                                <span>Finance Advisor</span>
                            </div>
                            <div class="team-social team__social-three">
                                <ul class="list-wrap">
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a>
                                    </li>
                                </ul>
                                <div class="social-toggle-icon">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team__item-three shine-animate-item">
                            <div class="team__thumb-three shine-animate">
                                <img src="assets/img/team/h3_team_img04.jpg" alt="Apexa" />
                            </div>
                            <div class="team__content-three">
                                <h4 class="title"><a href="team-details.html">Ralph Edwards</a></h4>
                                <span>Finance Advisor</span>
                            </div>
                            <div class="team-social team__social-three">
                                <ul class="list-wrap">
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-instagram"></i></a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)"><i class="fab fa-pinterest-p"></i></a>
                                    </li>
                                </ul>
                                <div class="social-toggle-icon">
                                    <i class="fas fa-share-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!-- team-area-three -->   
    </main>
        
@endsection

@push('scripts')
<script>
    console.log("Dashboard page loaded!");
</script>
@endpush