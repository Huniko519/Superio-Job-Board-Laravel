<section class="jobseeker-section">
    <div class="outer-box">
        <div class="image-column">
            @if(!empty($bg_image_url))
                <figure class="image"><img src="{{ $bg_image_url }}" alt=""></figure>
            @endif
        </div>
        <div class="content-column">
            <div class="inner-column wow fadeInUp">
                <div class="sec-title">
                    <h2>{{ $title }}</h2>
                    <div class="text">{{ $sub_title }}</div>
                    <a href="{{ $url_search }}" class="theme-btn btn-style-one">{{ $link_search }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
