<form class="form bravo-form-register" method="post">
    @csrf
    <form method="post" action="#">
        <div class="form-group">
            <div class="btn-box row">
                <div class="col-lg-6 col-md-12">
                    <input class="checked" type="radio" name="type" id="checkbox1" value="candidate" checked/>
                    <label for="checkbox1" class="theme-btn btn-style-four"><i class="la la-user"></i> {{ __("Candidate") }}</label>
                </div>
                <div class="col-lg-6 col-md-12">
                    <input class="checked" type="radio" name="type" id="checkbox2" value="employer"/>
                    <label for="checkbox2" class="theme-btn btn-style-four"><i class="la la-briefcase"></i> {{ __("Employer") }}</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>{{__('Email address')}}</label>
            <input type="email" name="email" placeholder="{{__('Email address')}}" required>
            <span class="invalid-feedback error error-email"></span>
        </div>

        <div class="form-group">
            <label>{{ __("Password") }}</label>
            <input id="password-field" type="password" name="password" value="" placeholder="{{ __("Password") }}">
            <span class="invalid-feedback error error-password"></span>
        </div>

        @if(setting_item("recaptcha_enable"))
            <div class="form-group">
                {{recaptcha_field($captcha_action ?? 'register')}}
                <span class="invalid-feedback error error-recaptcha"></span>
            </div>
        @endif

        <div class="form-group">
            <button class="theme-btn btn-style-one " type="submit" name="Register">{{ __('Sign Up') }}
                <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true"></span>
            </button>
        </div>
    </form>
    @if(setting_item('facebook_enable') or setting_item('google_enable') or setting_item('twitter_enable'))
        <div class="bottom-box">
            <div class="divider"><span>or</span></div>
            <div class="btn-box row">
                @if(setting_item('facebook_enable'))
                    <div class="col-lg-6 col-md-12">
                        <a href="{{url('/social-login/facebook')}}" class="theme-btn social-btn-two facebook-btn btn_login_fb_link"><i class="fab fa-facebook-f"></i>{{__('Facebook')}}</a>
                    </div>
                @endif
                @if(setting_item('google_enable'))
                    <div class="col-lg-6 col-md-12">
                        <a href="{{url('social-login/google')}}" class="theme-btn social-btn-two google-btn btn_login_gg_link"><i class="fab fa-google"></i>{{__('Google')}}</a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</form>
