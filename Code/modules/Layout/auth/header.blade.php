<!-- Preloader -->
<div class="preloader"></div>
<!-- Main Header-->
<header class="main-header">
    <div class="container-fluid">
        <!-- Main box -->

    </div>

    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="logo">
            <a href="{{ home_url() }}">
                @if($logo_id = setting_item("logo_id"))
                    @php $logo = get_file_url($logo_id,'full') @endphp
                    <img src="{{ $logo }}" alt="{{setting_item("site_title")}}">
                @else
                    <img src="{{ asset('/images/logo.svg') }}" alt="logo">
                @endif
            </a>
        </div>
    </div>

    <!-- Mobile Nav -->
    <div id="nav-mobile"></div>
</header>
<!--End Main Header -->
