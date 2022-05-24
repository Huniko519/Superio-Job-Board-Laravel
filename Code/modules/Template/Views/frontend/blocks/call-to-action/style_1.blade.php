<section class="call-to-action-two" @if(!empty($bg_image_url)) style="background-image: url({{ $bg_image_url ?? "" }}) !important;" @endif>
    <div class="auto-container">
        <div class="sec-title light text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{$sub_title}}</div>
        </div>

        <div class="btn-box">
            @if(!empty($link_search))
                <a href="{{$url_search}}" class="theme-btn btn-style-three">{{$link_search}}</a>
            @endif
            @if(!empty($link_apply))
                <a href="{{$url_apply}}" class="theme-btn btn-style-two">{{$link_apply}}</a>
            @endif
        </div>
    </div>
</section>
