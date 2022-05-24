@if(!empty($list_item))
    <section class="testimonial-section style-two alternate" @if(!empty($banner_image)) style="background-image: url({{ $banner_image_url }});" @endif>
        <div class="auto-container">
            <div class="sec-title text-center light">
                <h2>{{ $title ?? '' }}</h2>
                <div class="text">{{ $sub_title ?? '' }}</div>
            </div>
            <div class="carousel-outer wow fadeInUp">
                <div class="testimonial-carousel-three owl-carousel owl-theme default-dots light">
                    @foreach($list_item as $item)
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
@endif
