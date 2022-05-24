<section class="steps-section pt-0">
    <div class="auto-container">
        <div class="row">
            <div class="image-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column">
                    @if($featured_image)
                        <figure class="image"><img src="{{ $featured_image_url }}" alt=""></figure>
                    @endif
                    <!-- Count Employers -->
                    <div class="count-employers wow fadeInUp">
                        @if(!empty($sub_image_2))
                            <span class="title">{{ $sub_image_2 }}</span>
                        @endif
                        @if($image_2)
                            <figure class="image"><img src="{{ $image_2_url }}" alt=""></figure>
                        @endif
                    </div>
                </div>
            </div>

            <div class="content-column col-lg-6 col-md-12 col-sm-12">
                <div class="inner-column wow fadeInUp">
                    <div class="sec-title">
                        <h2>{{ $title }}</h2>
                        <div class="text">{{ $sub_title }}</div>
                        <ul class="steps-list">
                            {!! $content !!}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
