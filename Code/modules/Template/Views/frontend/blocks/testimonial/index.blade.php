@if(!empty($list_item))
    <section class="testimonial-section-two">
        <div class="container-fluid">
            <div class="testimonial-left"><img src="{{ asset('module/superio/images/testimonial-left.png') }}" alt=""></div>
            <div class="testimonial-right"><img src="{{ asset('module/superio/images/testimonial-right.png') }}" alt=""></div>
            <!-- Sec Title -->
            <div class="sec-title text-center">
                <h2>{{ $title ?? '' }}</h2>
                <div class="text">{{ $sub_title ?? '' }}</div>
            </div>

            <div class="carousel-outer">
                <div class="testimonial-carousel owl-carousel owl-theme">
                    @foreach($list_item as $item)
                        <div class="testimonial-block-two">
                            <div class="inner-box">
                                <div class="thumb"><img src="{{ get_file_url($item['avatar']) }}" alt="{{ $item['info_name'] }}"></div>
                                <h4 class="title">{{ $item['title'] ?? '' }}</h4>
                                <div class="text">{{ $item['desc'] ?? '' }}</div>
                                <div class="info-box">
                                    <h4 class="name">{{ $item['info_name'] ?? '' }}</h4>
                                    <span class="designation">{{ $item['info_desc'] ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
