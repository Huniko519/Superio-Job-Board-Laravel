<!-- Call To Action -->
<section class="call-to-action">
    <div class="auto-container">
        <div class="outer-box wow fadeInUp">
            <div class="content-column">
                <div class="sec-title">
                    <h2>{{ $title }}</h2>
                    <div class="text">{!! @clean($sub_title) !!}</div>
                    @if($url_search)
                        <a href="{{ $url_search }}" class="theme-btn btn-style-one bg-blue">
                            <span class="btn-title">{{ $link_search ?? __("Start Recruiting Now") }}</span>
                        </a>
                    @endif
                </div>
            </div>
            <div class="image-column" @if(!empty($bg_image_url)) style="background-image: url({{ $bg_image_url ?? "" }}) !important;" @endif>
            </div>
        </div>
    </div>
</section>
<!-- End Call To Action -->
