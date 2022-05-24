<!-- App Section -->
<section class="app-section app-download-block">
    <div class="auto-container">
        <div class="row">
            <!-- Image Column -->
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                @if($featured_image)
                    <figure class="image wow fadeInLeft">
                        <img src="{{ $featured_image_url }}" alt="app">
                    </figure>
                @endif
            </div>

            <div class="content-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column wow fadeInRight">
                    <div class="sec-title">
                        <span class="sub-title">{{ $sub_title }}</span>
                        <h2>{!! @clean($title) !!}</h2>
                        <div class="text">{!! @clean($desc) !!}</div>
                    </div>
                    <div class="download-btn">
                        @if($button_image_1 && $button_url_1)
                            <a href="{{ $button_url_1 }}" target="_blank"><img src="{{ $button_image_1_url }}" alt="button 1"></a>
                        @endif
                        @if($button_image_2 && $button_url_2)
                            <a href="{{ $button_url_2 }}" target="_blank"><img src="{{ $button_image_2_url }}" alt="button 1"></a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End App Section -->
