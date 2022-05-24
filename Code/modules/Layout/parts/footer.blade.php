@if(!is_api() && empty($footer_null))
    <!-- Main Footer -->
    @php
        $footer_style = $row->footer_style ?? '';
        if(empty($footer_style)) $footer_style = setting_item_with_lang('footer_style');
    @endphp
    <footer class="main-footer {{ $footer_style }} @if($footer_style == 'style_1' && empty($is_home)) alternate5 @endif">
        <div class="auto-container">
            <!--Widgets Section-->
            <div class="widgets-section wow fadeInUp">
                <div class="row">
                    @if(!empty($info_contact = clean(setting_item_with_lang('footer_info_text'))))
                        <div class="big-column col-xl-4 col-lg-3 col-md-12">
                            <div class="footer-column about-widget">
                                @php
                                    $logo_id = setting_item("logo_id");
                                    if($footer_style == 'style-two' || $footer_style == 'style-six') $logo_id = setting_item("logo_white_id");;
                                    $logo = get_file_url($logo_id,'full');
                                @endphp
                                <div class="logo">
                                    <a href="{{ url(app_get_locale(false,'/')) }}">
                                        <img src="{{ $logo }}" alt="logo footer">
                                    </a>
                                </div>
                                {!! clean($info_contact) !!}
                            </div>
                        </div>
                    @endif
                    <div class="big-column col-xl-8 col-lg-9 col-md-12">
                        <div class="row">
                            @if($list_widget_footers = setting_item_with_lang("list_widget_footer"))
                                <?php $list_widget_footers = json_decode($list_widget_footers);?>
                                @foreach($list_widget_footers as $key=>$item)
                                    <div class="footer-column col-lg-{{$item->size ?? '3'}} col-md-6 col-sm-12">
                                        <div class="footer-widget links-widget">
                                            <h4 class="widget-title">{{$item->title}}</h4>
                                            <div class="widget-content">
                                                {!! clean($item->content) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Bottom-->
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="outer-box">
                    <div class="copyright-text">
                        {!! @clean(setting_item_with_lang('copyright')) !!}
                    </div>
                    <div class="social-links">
                        {!! @clean(setting_item_with_lang('footer_socials')) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll To Top -->
        <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
    </footer>
    <!-- End Main Footer -->
@endif

@include('Layout::parts.login-register-modal')
@include('Layout::parts.chat')
@if(Auth::id())
	@include('Media::browser')
@endif

@if(!is_candidate() || empty($candidate))
    <div class="bc-alert-popup">
        <div class="message-box warning"></div>
    </div>
@endif
<link rel="stylesheet" href="{{asset('libs/flags/css/flag-icon.min.css')}}">

{!! \App\Helpers\Assets::css(true) !!}

{{--Lazy Load--}}
<script src="{{asset('libs/lazy-load/intersection-observer.js')}}"></script>
<script async src="{{asset('libs/lazy-load/lazyload.min.js')}}"></script>
<script>
    // Set the options to make LazyLoad self-initialize
    window.lazyLoadOptions = {
        elements_selector: ".lazy",
        // ... more custom settings?
    };

    // Listen to the initialization event and get the instance of LazyLoad
    window.addEventListener('LazyLoad::Initialized', function (event) {
        window.lazyLoadInstance = event.detail.instance;
    }, false);
</script>
<script src="{{ asset('libs/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('libs/jquery-migrate/jquery-migrate.min.js') }}"></script>
<script src="{{ asset('libs/header.js') }}"></script>
<script>
    $(document).on('ready', function () {
        $.superioHeader.init($('#header'));
    });
</script>
<script src="{{ asset('libs/lodash.min.js') }}"></script>
<script src="{{ asset('libs/vue/vue'.(!env('APP_DEBUG') ? '.min':'').'.js') }}"></script>
<script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('libs/bootbox/bootbox.min.js') }}"></script>

@if(Auth::id())
	<script src="{{ asset('module/media/js/browser.js?_ver='.config('app.asset_version')) }}"></script>
@endif


<script src="{{ asset('js/functions.js?_ver='.config('app.asset_version')) }}"></script>

<script src="{{ asset('module/superio/js/popper.min.js') }}"></script>
<script src="{{ asset('module/superio/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('module/superio/js/chosen.min.js') }}"></script>
<script src="{{ asset('module/superio/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('module/superio/js/jquery.fancybox.js') }}"></script>
<script src="{{ asset('module/superio/js/jquery.modal.min.js') }}"></script>
<script src="{{ asset('module/superio/js/mmenu.polyfills.js') }}"></script>
<script src="{{ asset('module/superio/js/mmenu.js') }}"></script>
<script src="{{ asset('module/superio/js/appear.js') }}"></script>
<script src="{{ asset('module/superio/js/anm.min.js') }}"></script>
<script src="{{ asset('module/superio/js/owl.js') }}"></script>
<script src="{{ asset('module/superio/js/wow.js') }}"></script>
<script src="{{ asset('module/superio/js/script.js?_ver='.config('app.asset_version')) }}"></script>

<script src="{{ asset('libs/pusher.min.js') }}"></script>
<script src="{{ asset('js/home.js?_ver='.config('app.asset_version')) }}"></script>

@if(!empty($is_user_page))
	<script src="{{ asset('module/user/js/user.js?_ver='.config('app.asset_version')) }}"></script>
@endif
@if(setting_item('cookie_agreement_enable')==1 and request()->cookie('booking_cookie_agreement_enable') !=1 and !is_api()  and !isset($_COOKIE['booking_cookie_agreement_enable']))
	<div class="booking_cookie_agreement p-3 fixed-bottom">
		<div class="container d-flex ">
            <div class="content-cookie">{!! setting_item_with_lang('cookie_agreement_content') !!}</div>
            <button class="btn save-cookie">{!! setting_item_with_lang('cookie_agreement_button_text') !!}</button>
        </div>
	</div>
	<script>
        var save_cookie_url = '{{route('core.cookie.check')}}';
	</script>
	<script src="{{ asset('js/cookie.js?_ver='.config('app.asset_version')) }}"></script>
@endif

{!! \App\Helpers\Assets::js(true) !!}

@yield('footer')

@php \App\Helpers\ReCaptchaEngine::scripts() @endphp
