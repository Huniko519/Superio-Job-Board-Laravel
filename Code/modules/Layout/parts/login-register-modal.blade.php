<div class="model bc-model" id="login">
    <!-- Login modal -->
    <div id="login-modal">
        <!-- Login Form -->
        <div class="login-form default-form">
            <div class="form-inner">
                @if($site_title = setting_item("site_title"))
                    <h3>{{ __("Login to :site_title", ['site_title' => $site_title]) }}</h3>
                @else
                    <h3>{{ __("Login") }}</h3>
                @endif

                @include('Layout::auth/login-form',['popup'=>true])
            </div>
        </div>
        <!--End Login Form -->
    </div>
    <!-- End Login Module -->
</div>

<div class="modal fade login" id="register">
    <div id="login-modal">
        <div class="login-form default-form">
            <div class="form-inner">
                <div class="form-inner">
                    @if($site_title = setting_item("site_title"))
                        <h3>{{ __("Create a Free :site_title Account", ['site_title' => $site_title]) }}</h3>
                    @else
                        <h3>{{ __("Sign Up") }}</h3>
                    @endif
                        @include('Layout::auth/register-form')
                </div>
            </div>
        </div>
    </div>
</div>
