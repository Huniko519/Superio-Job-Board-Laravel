@if(!empty($list_item))
    <section class="testimonial-section-two style-two">
        <div class="container-fluid">
            @if(!empty($banner_image))
                <div class="testimonial-left"><img src="{{ $banner_image_url }}" alt=""></div>
            @endif
            @if(!empty($banner_image_2))
                <div class="testimonial-right"><img src="{{ $banner_image_2_url }}" alt=""></div>
            @endif
            <!-- Sec Title -->
            <div class="sec-title text-center">
                <h2>{{ $title ?? '' }}</h2>
                <div class="text">{{ $sub_title ?? '' }}</div>
            </div>

            <div class="carousel-outer wow fadeInUp">
                <!-- Testimonial Carousel -->
                @foreach($list_item as $item)
                <div class="testimonial-carousel owl-carousel owl-theme">
                    <!--Testimonial Block -->
                    <div class="testimonial-block-two">
                        <div class="inner-box">
                            <div class="thumb"><img src="{{ get_file_url($item['avatar'],'full') }}" alt="{{ $item['info_name'] }}"></div>
                            <h4 class="title">{{ $item['title'] ?? '' }}</h4>
                            <div class="text">{{ $item['desc'] ?? '' }}</div>
                            <div class="info-box">
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
@endif
