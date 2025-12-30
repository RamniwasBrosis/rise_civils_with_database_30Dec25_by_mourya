@extends('layouts.main')

@push('styles')
<style>
    
</style>
@endpush

@section('content')
    <main class="fix"> 
        <div class="container">
            <div class="ck-content"><p> </p>
                <div
                style="margin-bottom: 20px;"
                >
                    <iframe
                        src="https://maps.google.com/maps?q=Under Triveni Puliya, 7A, Gangotri Nagar, Arjun Nagar, Jaipur, Rajasthan 302018&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        style="height: 500px; width: 100%;"
                        title="Google Maps for Under Triveni Puliya, 7A, Gangotri Nagar, Arjun Nagar, Jaipur, Rajasthan 302018"
                        frameborder="0"
                        scrolling="no"
                        marginheight="0"
                        marginwidth="0"
                ></iframe>
                </div>
                <section class="contact__area shortcode-contact-form">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-5">
                                <div class="contact__content">
                                    <div class="section-title mb-35">
                                        <h2 class="title">{{$contact->title}}</h2>
                                        <p>{!! $contact->description !!}</p>
                                    </div>
                                    <div class="contact__info">
                                        <ul class="list-wrap">
                                            <li>
                                                <div class="icon">
                                                    <svg class="icon  svg-icon-ti-ti-map-pin"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    >
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                    </svg>                                                                                    
                                                </div>
                                                <div class="content">
                                                    <h4 class="title">Address</h4>
                                                    <p>{{$contact->address}}</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <svg class="icon  svg-icon-ti-ti-phone-call"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    >
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                                    <path d="M15 7a2 2 0 0 1 2 2" />
                                                    <path d="M15 3a6 6 0 0 1 6 6" />
                                                    </svg>              
                                                </div>
                                                <div class="content">
                                                    <h4 class="title">Phone</h4>
                                                    <p>{{$contact->phone}}</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="icon">
                                                    <svg class="icon  svg-icon-ti-ti-mail"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="24"
                                                    height="24"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    >
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                    <path d="M3 7l9 6l9 -6" />
                                                    </svg>
                                                </div>
                                                <div class="content">
                                                    <h4 class="title">E-mail</h4>
                                                    <p>{{$contact->email}}</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="contact__form-wrap">
                                    <h2 class="title">Give Us a Message</h2>
                                    <p class="truncate-2-custom">Your email address will not be published. Required fields are marked *</p>
                                    <form method="POST" action="{{ route('user.ContactUsadd') }}" accept-charset="UTF-8" id="botble-contact-forms-fronts-contact-form" class="contact-form dirty-check">
                                        @csrf
                                        <div class="contact-form-row row">
                                            <div class="contact-column-6 col-md-6 contact-field-name_wrapper">
                                                <div class="form-grp" >
                                                    <label class="form-label form-label required" for="name">
                                                        Name
                                                    </label><br>
                                                    <input class="contact-form-input" placeholder="Your Name" required="required" name="name" type="text" id="name">
                                                </div>
                                            </div>
                                            <div class="contact-column-6 col-md-6 contact-field-email_wrapper">
                                                <div class="form-grp" >
                                                    <label class="form-label form-label required" for="email">
                                                        Email
                                                    </label><br>
                                                    <input class="contact-form-input" placeholder="Your Email" required="required" name="email" type="email" id="email">
                                                </div>
                                            </div>
                                            <div class="contact-column-6 col-md-6 contact-field-address_wrapper">
                                                <div class="form-grp" >
                                                    <label class="form-label" for="address">
                                                        Address
                                                    </label><br>
                                                    <input class="contact-form-input" placeholder="Your Address" name="address" type="text" id="address">
                                                </div>
                                            </div>
                                            <div class="contact-column-6 col-md-6 contact-field-phone_wrapper">
                                                <div class="form-grp" >
                                                    <label class="form-label" for="phone">
                                                        Phone
                                                    </label><br>
                                                    <input class="contact-form-input" placeholder="Your Phone" name="phone" type="text" id="phone">
                                                </div>
                                            </div>
                                            <div class="contact-column-12 col-md-12 contact-field-subject_wrapper">
                                                <div class="form-grp" >
                                                    <label class="form-label" for="subject">
                                                    Subject
                                                    </label><br>
                                                    <input class="contact-form-input" placeholder="Subject" name="subject" type="text" id="subject">
                                               </div>
                                            </div>
                                        </div>
                                        <div class="form-grp" >
                                            <label class="form-label form-label required" for="content">
                                                Message
                                            </label><br>
                                           <textarea class="contact-form-input" rows="3" placeholder="Your Message" required="required" id="content" name="content" cols="50"></textarea>
                                        </div>
                                        <div class="form-grp d-flex align-items-center">
                                            <input type="hidden" name="agree_terms_and_policy" value="0">
                                        
                                            <label class="form-check d-flex align-items-center gap-2 mb-0">
                                                <input type="checkbox"
                                                       name="agree_terms_and_policy"
                                                       value="1"
                                                       required>
                                                <span>I agree to the Terms and Privacy Policy</span>
                                            </label>
                                        </div>
                                        <div class="contact-form-group">
                                            <button class="btn" type="submit">Submit Post</button>
                                        </div>
                                        <div class="contact-form-group">
                                            <div class="contact-message contact-success-message" style="display: none"></div>
                                            <div class="contact-message contact-error-message" style="display: none"></div>
                                        </div>
                                    </form>
                                    <p class="ajax-response mb-0"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

    </main>
        
@endsection

@push('scripts')
<script>
    console.log("Dashboard page loaded!");
</script>
@endpush
