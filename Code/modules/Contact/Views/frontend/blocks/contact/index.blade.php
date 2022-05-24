<div class="bravo-contact-block">
    <div class="iframe_map map-section">
        {!! ( setting_item("page_contact_iframe_google_map")) !!}
    </div>
    <div class="contact-section">
        <div class="auto-container">
            <div class="upper-box">
                <div class="row">
                    @if(!empty($contact_lists = setting_item("page_contact_lists")))
                        @php  $contact_lists = json_decode($contact_lists,true) @endphp
                        @foreach( $contact_lists as $item)
                            <div class="contact-block col-lg-4 col-md-6 col-sm-12">
                                <div class="inner-box">
                                    <span class="icon"><img src="{{ get_file_url($item['icon']) }}" alt="{{ $item['title'] }}"></span>
                                    <h4>{{ $item['title'] }}</h4>
                                    <p>{!! clean($item['desc']) !!}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="contact-form default-form">
                <h3>{{ __('Leave A Message') }}</h3>
                <form method="post" action="{{ route("contact.store") }}"  class="bravo-contact-block-form">
                    {{csrf_field()}}
                    <div style="display: none;">
                        <input type="hidden" name="g-recaptcha-response" value="">
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <div class="response"></div>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                            <label>{{ __('Your Name') }}</label>
                            <input type="text" name="name" class="username" placeholder="{{ __('Your Name') }}*" required>
                        </div>

                        <div class="col-lg-6 col-md-12 col-sm-12 form-group">
                            <label>{{ __('Your Email') }}</label>
                            <input type="email" name="email" class="email" placeholder="{{ __('Your Email') }}*" required>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <label>{{ __('Subject') }}</label>
                            <input type="text" name="subject" class="subject" placeholder="{{ __('Subject') }} *" required>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                            <label>{{ __('Your Message') }}</label>
                            <div class="js-form-message">
                                <div class="input-group">
                                    <textarea name="message" placeholder="{{ __('Write your message...') }}" required=""></textarea>
                                </div>
                            </div>
                        </div>
                        @if(setting_item("recaptcha_enable"))
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                {{recaptcha_field('contact')}}
                                <span class="invalid-feedback error error-recaptcha"></span>
                            </div>
                        @endif
                        <div class="col-lg-12 col-md-12 col-sm-12 form-group m-0">
                            <button type="submit" class="theme-btn btn-style-one">
                                {{ __("Send Message") }}
                                <i class="fa fa-spinner fa-pulse fa-fw"></i>
                            </button>
                        </div>
                        <div class="col-sm-12 mt-3">
                            <div class="form-mess"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="call-to-action style-two">
        <div class="auto-container">
            <div class="outer-box">
                <div class="content-column">
                    <div class="sec-title">
                        <h2>{{ setting_item('contact_call_to_action_title') }}</h2>
                        <div class="text">{!! clean(setting_item('contact_call_to_action_sub_title')) !!}</div>
                        <a href="{{ setting_item('contact_call_to_action_button_link') }}" class="theme-btn btn-style-one bg-blue"><span class="btn-title">{{ setting_item('contact_call_to_action_button_text') }}</span></a>
                    </div>
                </div>

                <div class="image-column" style="background-image: url({{ get_file_url(setting_item('contact_call_to_action_image'),'full') }});"></div>
            </div>
        </div>
    </div>
</div>
