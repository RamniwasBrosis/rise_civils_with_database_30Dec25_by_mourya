
        <!--Preloader-->
        <div id="preloader">
            <div id="loader" class="loader">
                <div class="loader-container">
                    <div class="loader-icon"><img src="{{ asset('assets_rise/img/logo/preloader.png') }}" alt="Preloader" /></div>
                </div>
            </div>
        </div>
        <!--Preloader-end -->
        <!-- Scroll-top -->
        <button class="scroll__top scroll-to-target" data-target="html">
            <i class="fas fa-angle-up"></i>
        </button>
        <!-- Scroll-top-end-->
        <!-- header-area -->
        <header class="tg-header__style-five">
            <div id="sticky-header" class="tg-header__area tg-header__area-five">
                <div class="container1 mx-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="tgmenu__wrap">
                                <nav class="tgmenu__nav">
                                    <div class="logo">
                                        @php
                                            $logoPath = public_path($pageData->logo_image);
                                            $logoUrl = ( !empty($pageData->logo_image) && file_exists($logoPath) )
                                                ? url($pageData->logo_image)
                                                : url('assets_rise/img/logo/logo.png');
                                        @endphp
                                        
                                        <a href="{{ url('/') }}">
                                            <img src="{{ $logoUrl }}" alt="Logo" />
                                        </a>

                                    </div>
                                    <div class="tgmenu__navbar-wrap tgmenu__main-menu d-none d-lg-flex">
                                        <ul class="navigation">
                                            <li class="active">
                                                <a href="{{ url('/') }}">Home</a> 
                                            </li>
                                            
                                            @foreach($types as $type)
                                                @php
                                                    $hideDropdownTypes = ['course', 'courses'];
                                                    $isCourseType = in_array(strtolower($type->type), $hideDropdownTypes);
                                                @endphp
                                            
                                                <li class="{{ !$isCourseType ? 'menu-item-has-children' : '' }}">
                                                    <a href="{{ 
                                                        $isCourseType 
                                                            ? route('users.courses') 
                                                            : route('admin.viewBlog', ['slug' => $type->slug]) 
                                                    }}">
                                                        {{ $type->type }}
                                                    </a>
                                            
                                                    {{-- SHOW DROPDOWN ONLY IF NOT COURSE --}}
                                                    @if(!$isCourseType && isset($mainCategories[$type->id]))
                                                        <ul class="sub-menu">
                                                            @foreach($mainCategories[$type->id] as $main)
                                                                <li class="menu-item-has-children-n">
                                                                    <a href="{{ route('category.blog', $main->slug ?? '#') }}">
                                                                        {{ $main->name }}
                                                                    </a>
                                            
                                                                    @if($main->children->count())
                                                                        <ul class="sub-menu">
                                                                            @foreach($main->children as $sub)
                                                                                <li>
                                                                                    <a href="{{ $sub->slug
                                                                                        ? route('category.innerSubCategory', [
                                                                                            'parentSlug' => $main->slug,
                                                                                            'slug' => $sub->slug
                                                                                        ])
                                                                                        : '#' }}">
                                                                                        {{ $sub->name }}
                                                                                    </a>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    
                                    <div class="tgmenu__action tgmenu__action-four d-none d-md-block">
                                        <ul class="list-wrap" style="list-style:none;">
                                            
                                                @if(Auth::check())
                                                    <li class="header-btn">
                                                        <form action="{{ route('front.logout') }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn-login" style="background:none; border:none; color:inherit; cursor:pointer;">
                                                                Logout
                                                            </button>
                                                        </form>
                                                    </li>
                                                @else
                                                    <li class="header-btn">
                                                        <a href="{{ route('front.login') }}" class="btn">Login</a>
                                                    </li>
                                                @endif
                                            
                                        </ul>
                                        
                                    </div>
                                    
                                    
                                    <div class="mobile-nav-toggler mobile-nav-toggler-two">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 18" fill="none">
                                            <path d="M0 2C0 0.895431 0.895431 0 2 0C3.10457 0 4 0.895431 4 2C4 3.10457 3.10457 4 2 4C0.895431 4 0 3.10457 0 2Z" fill="currentcolor" />
                                            <path d="M0 9C0 7.89543 0.895431 7 2 7C3.10457 7 4 7.89543 4 9C4 10.1046 3.10457 11 2 11C0.895431 11 0 10.1046 0 9Z" fill="currentcolor" />
                                            <path d="M0 16C0 14.8954 0.895431 14 2 14C3.10457 14 4 14.8954 4 16C4 17.1046 3.10457 18 2 18C0.895431 18 0 17.1046 0 16Z" fill="currentcolor" />
                                            <path d="M7 2C7 0.895431 7.89543 0 9 0C10.1046 0 11 0.895431 11 2C11 3.10457 10.1046 4 9 4C7.89543 4 7 3.10457 7 2Z" fill="currentcolor" />
                                            <path d="M7 9C7 7.89543 7.89543 7 9 7C10.1046 7 11 7.89543 11 9C11 10.1046 10.1046 11 9 11C7.89543 11 7 10.1046 7 9Z" fill="currentcolor" />
                                            <path d="M7 16C7 14.8954 7.89543 14 9 14C10.1046 14 11 14.8954 11 16C11 17.1046 10.1046 18 9 18C7.89543 18 7 17.1046 7 16Z" fill="currentcolor" />
                                            <path d="M14 2C14 0.895431 14.8954 0 16 0C17.1046 0 18 0.895431 18 2C18 3.10457 17.1046 4 16 4C14.8954 4 14 3.10457 14 2Z" fill="currentcolor" />
                                            <path d="M14 9C14 7.89543 14.8954 7 16 7C17.1046 7 18 7.89543 18 9C18 10.1046 17.1046 11 16 11C14.8954 11 14 10.1046 14 9Z" fill="currentcolor" />
                                            <path d="M14 16C14 14.8954 14.8954 14 16 14C17.1046 14 18 14.8954 18 16C18 17.1046 17.1046 18 16 18C14.8954 18 14 17.1046 14 16Z" fill="currentcolor" />
                                        </svg>
                                    </div>
                                </nav>
                            </div>
                            <!-- Mobile Menu  -->
                            <div class="tgmobile__menu">
                                <nav class="tgmobile__menu-box">
                                    <div class="close-btn"><i class="fas fa-times"></i></div>
                                    <div class="nav-logo">
                                        <a href="index.html"><img src="assets_rise/img/logo/logo.png" alt="Logo" /></a>
                                    </div>
                                    <div class="tgmobile__search">
                                        <form action="#">
                                            <input type="text" placeholder="Search here..." />
                                            <button><i class="fas fa-search"></i></button>
                                        </form>
                                    </div>
                                    <div class="tgmobile__menu-outer">
                                        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
                                    </div> 
                                    <div class="tgmobile__menu-bottom">
                                        @if(Auth::check())
                                            <div> 
                                            </div>
                                        @else
                                            <div>
                                                <a href="{{ route('front.login') }}" class="btn">Login</a>
                                            </div>
                                        @endif
                                    </div>
                                </nav>
                            </div>
                            <div class="tgmobile__menu-backdrop"></div>
                            <!-- End Mobile Menu -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <a href="https://wa.me/{{ $pageData->whatapp_number }}" target="_blank" class="whatsico"><svg fill="#000000" width="800px" height="800px" viewBox="-1.66 0 740.824 740.824" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M630.056 107.658C560.727 38.271 468.525.039 370.294 0 167.891 0 3.16 164.668 3.079 367.072c-.027 64.699 16.883 127.855 49.016 183.523L0 740.824l194.666-51.047c53.634 29.244 114.022 44.656 175.481 44.682h.151c202.382 0 367.128-164.689 367.21-367.094.039-98.088-38.121-190.32-107.452-259.707m-259.758 564.8h-.125c-54.766-.021-108.483-14.729-155.343-42.529l-11.146-6.613-115.516 30.293 30.834-112.592-7.258-11.543c-30.552-48.58-46.689-104.729-46.665-162.379C65.146 198.865 202.065 62 370.419 62c81.521.031 158.154 31.81 215.779 89.482s89.342 134.332 89.311 215.859c-.07 168.242-136.987 305.117-305.211 305.117m167.415-228.514c-9.176-4.591-54.286-26.782-62.697-29.843-8.41-3.061-14.526-4.591-20.644 4.592-6.116 9.182-23.7 29.843-29.054 35.964-5.351 6.122-10.703 6.888-19.879 2.296-9.175-4.591-38.739-14.276-73.786-45.526-27.275-24.32-45.691-54.36-51.043-63.542-5.352-9.183-.569-14.148 4.024-18.72 4.127-4.11 9.175-10.713 13.763-16.07 4.587-5.356 6.116-9.182 9.174-15.303 3.059-6.122 1.53-11.479-.764-16.07-2.294-4.591-20.643-49.739-28.29-68.104-7.447-17.886-15.012-15.466-20.644-15.746-5.346-.266-11.469-.323-17.585-.323-6.117 0-16.057 2.296-24.468 11.478-8.41 9.183-32.112 31.374-32.112 76.521s32.877 88.763 37.465 94.885c4.587 6.122 64.699 98.771 156.741 138.502 21.891 9.45 38.982 15.093 52.307 19.323 21.981 6.979 41.983 5.994 57.793 3.633 17.628-2.633 54.285-22.19 61.932-43.616 7.646-21.426 7.646-39.791 5.352-43.617-2.293-3.826-8.41-6.122-17.585-10.714"/></svg></a>
