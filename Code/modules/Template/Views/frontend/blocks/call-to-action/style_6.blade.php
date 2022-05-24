<!-- Call To Action Three -->
<section class="call-to-action-three style-two">
    <div class="auto-container">
        <div class="outer-box">
            <div class="sec-title light">
                <h2>{{ $title }}</h2>
                <div class="text">{!! @clean($sub_title) !!}
                    @if($link_search)
                        <br>
                        <a href="{{ $url_search }}">{{ $link_search }}</a>
                    @endif
                </div>
            </div>
            @if($link_apply)
                <div class="btn-box">
                    <a href="{{ $url_apply }}" class="theme-btn btn-style-three">
                        <span class="btn-title">{{ $link_apply ?? "Search Job" }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- End Call To Action -->
