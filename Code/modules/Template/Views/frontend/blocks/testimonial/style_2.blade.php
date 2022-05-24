@if(!empty($list_item))
<!-- Testimonial Section -->
<section class="testimonial-section">
    <div class="container-fluid">
        <!-- Sec Title -->
        <div class="sec-title text-center">
            <h2>{{ $title ?? '' }}</h2>
            <div class="text">{{ $sub_title ?? '' }}</div>
        </div>

        <div class="carousel-outer wow fadeInUp">

            <!-- Testimonial Carousel -->
            <div class="testimonial-carousel owl-carousel owl-theme">

                @foreach($list_item as $item)
                <!--Testimonial Block -->
                <div class="testimonial-block">
                    <div class="inner-box">
                        <h4 class="title">{{ $item['title'] ?? '' }}</h4>
                        <div class="text">{{ $item['desc'] ?? '' }}</div>
                        <div class="info-box">
                            <div class="thumb"><img src="{{ get_file_url($item['avatar']) }}" alt="{{ $item['info_name'] }}"></div>
                            <h4 class="name">{{ $item['info_name'] ?? '' }}</h4>
                            <span class="designation">{{ $item['position'] ?? '' }}</span>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
<!-- End Testimonial Section -->
@endif
