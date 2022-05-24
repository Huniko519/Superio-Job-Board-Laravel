@extends('Layout::auth.app')

@section('content')
    <div class="login-section">
        <div class="image-layer" style="background-image: url({{ asset('module/superio/images/background/12.jpg') }});"></div>
        <div class="outer-box">
            <!-- Login Form -->
            <div class="login-form default-form bravo-login-form-page bravo-login-page">
                <div class="form-inner">
                    @if($site_title = setting_item("site_title"))
                        <h3>{{ __("Login to :site_title", ['site_title' => $site_title]) }}</h3>
                    @else
                        <h3>{{ __("Login") }}</h3>
                    @endif
                </div>
                @include('Layout::auth.login-form',['captcha_action'=>'login_normal','popup'=>false])
            </div>
        </div>
    </div>
@endsection
