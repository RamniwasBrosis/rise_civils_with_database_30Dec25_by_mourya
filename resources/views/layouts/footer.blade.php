<!-- footer-area -->
        <footer>
            <div class="footer-area">
                <div class="footer-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6">
                                <div class="footer-widget">
                                    <div class="fw-logo mb-25">
                                        <a href="index.html"><img src="{{url($pageData->logo_image ?? '#')}}" alt="Apexa" /></a>
                                    </div>
                                    <div class="footer-content">
                                        <p>{{ $pageData->aboutus_content ?? ' ' }}</p>
                                        <div class="footer-social">
                                            <ul class="list-wrap">
                                                @if(!empty($pageData->facebook_url))
                                                <li>
                                                    <a href="{{url($pageData->facebook_url ?? ' ')}}"><i class="fab fa-facebook-f"></i></a>
                                                </li>
                                                @endif
                                               @if(!empty($pageData->twitter_url))
                                                <li>
                                                    <a href="{{url($pageData->twitter_url ?? ' ')}}"><i class="fab fa-twitter"></i></a>
                                                </li>
                                                @endif
                                                @if(!empty($pageData->instagram_url))
                                                <li>
                                                    <a href="{{url($pageData->instagram_url ?? ' ')}}"><i class="fab fa-instagram"></i></a>
                                                </li>
                                                @endif
                                                @if(!empty($pageData->pinsert_url))
                                                <li>
                                                    <a href="{{url($pageData->pinsert_url ?? ' ')}}"><i class="fab fa-pinterest-p"></i></a>
                                                </li>
                                                @endif
                                                @if(!empty($pageData->youtube_url))
                                                <li>
                                                    <a href="{{url($pageData->youtube_url ?? ' ')}}"><i class="fab fa-youtube"></i></a>
                                                </li>
                                                @endif
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div class="footer-widget">
                                    <h4 class="fw-title">Information</h4>
                                    <div class="footer-info-list">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-phone-call"></i>
                                                </div>
                                                <div class="content">
                                                    <a href="tel:09785606061">{{ $pageData->phone ?? ' ' }}</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-envelope"></i>
                                                </div>
                                                <div class="content">
                                                    <a href="mailto:info@risecivils.com">{{ $pageData->email ?? ' ' }}</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <i class="flaticon-pin"></i>
                                                </div>
                                                <div class="content">
                                                    <p>{{ $pageData->address ?? ' ' }}</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                <div class="footer-widget">
                                    <h4 class="fw-title">Top Links</h4>
                                    <div class="footer-link-list">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="content">
                                                    <a href="/courses"> Courses
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content">
                                                    <a href="/current-affairs">Current Affairs
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content">
                                                    <a href="{{route('user.aboutus')}}">About Us
                                                    </a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="content">
                                                    <a href="{{route('user.contactUs')}}">Contact Us
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row align-items-center"> 
                            <div class="col-lg-12">
                                <div class="copyright-text text-center">
                                    <p>©2025 Brosis Technologies Team. All Rights Reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-shape">
                    <img class="dark-opacity" src="{{ asset('assets_rise/img/images/footer_shape01.png') }}" alt="Apexa" data-aos="fade-right" data-aos-delay="400" />
                    <img class="dark-opacity" src="{{ asset('assets_rise/img/images/footer_shape02.png') }}" alt="Apexa" data-aos="fade-left" data-aos-delay="400" />
                    <img src="{{ asset('assets_rise/img/images/footer_shape03.png') }}" alt="Apexa" data-parallax='{"x" : 100 , "y" : -100 }' />
                </div>
            </div>
        </footer>
<!-- footer-area-end -->
     