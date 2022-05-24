<!-- About Section -->
<section class="about-section style-two">
    <div class="auto-container">
        <div class="row">
            <!-- Content Column -->
            <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                <div class="inner-column wow fadeInLeft">
                    <div class="sec-title">
                        <h2>{{ $title }}</h2>
                        <div class="text">{{ $sub_title }}</div>
                    </div>
                    <ul class="list-style-two">
                        {!! $content !!}
                    </ul>
                    <a href="{{ $button_url }}" class="theme-btn btn-style-one lightbox-image">{{ $button_name }}</a>
                </div>
            </div>

            <!-- Image Column -->
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column wow fadeInRight">
                    @if($featured_image)
                        <figure class="image">
                            <img src="{{ $featured_image_url }}" alt="about">
                            <a href="{{ $button_url }}" class="play-btn lightbox-image" data-fancybox="images"><span class="flaticon-play-button-2 icon"></span></a>
                        </figure>
                    @endif
                </div>
            </div>
        </div>
        <!-- Fun Fact Section -->
    </div>
</section>
<!-- End About Section -->
