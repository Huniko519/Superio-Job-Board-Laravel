<!-- Call To Action Three -->
<section class="call-to-action-three">
    <div class="auto-container">
        <div class="outer-box">
            <div class="sec-title">
                <h2>{{ $title }}</h2>
                <div class="text">{!! @clean($sub_title) !!}</div>
            </div>
            @if($url_search)
                <div class="btn-box">
                    <a href="{{ $url_search }}" class="theme-btn btn-style-one bg-blue">
                        <span class="btn-title">{{ $link_search ?? "Search Job" }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- End Call To Action -->
