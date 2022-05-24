<!-- About Section -->
<section class="about-section-two">
    <div class="auto-container">
        <div class="row">
            <!-- Content Column -->
            <div class="content-column col-lg-6 col-md-12 col-sm-12 order-2">
                <div class="inner-column wow fadeInRight">
                    <h2 class="about-title">{{ $title }}</h2>
                    <div class="sec-content">
                        {!! @clean($content) !!}
                    </div>
                    @if($button_url)
                        <a href="{{ $button_url }}" target="{{ $button_target ? '_blank' : 'self' }}" class="theme-btn btn-style-one bg-blue"><span class="btn-title">{{ $button_name }}</span></a>
                    @endif
                </div>
            </div>

            <!-- Image Column -->
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                @if($featured_image)
                    <figure class="image-box wow fadeInLeft">
                        <img src="{{ $featured_image_url }}" alt="about">
                    </figure>
                @endif
                @if($image_2)
                    <!-- Count Employers -->
                    <div class="applicants-list app-list-2 wow fadeInUp">
                        <img src="{{ $image_2_url }}" class="img-option" alt="img">
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- End About Section -->
