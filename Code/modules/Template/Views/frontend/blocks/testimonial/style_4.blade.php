@if(!empty($list_item))
    <section class="testimonial-section-three">
        <div class="auto-container">
            <!-- Sec Title -->
            <div class="sec-title text-center">
                <h2>{{ $title ?? '' }}</h2>
                <div class="text">{{ $sub_title ?? '' }}</div>
            </div>

            <div class="carousel-outer wow fadeInUp">
                <div class="testimonial-carousel-two owl-carousel owl-theme">
                    @foreach($list_item as $item)
                        <div class="slide-item">
                            <div class="image-column">
                                <figure class="image">
                                    <img src="{{ get_file_url($item['avatar'],'full') }}" alt="{{ $item['info_name'] }}">
                                </figure>
                            </div>
                            <div class="content-column">
                                <!--Testimonial Block -->
                                <div class="testimonial-block-three">
                                    <div class="inner-box">
                                        <h4 class="title">{{ $item['title'] ?? '' }}</h4>
                                        <div class="text">{{ $item['desc'] ?? '' }}</div>
                                        <div class="info-box">
                                            <h4 class="name">{{ $item['info_name'] ?? '' }}</h4>
                                            <span class="designation">{{ $item['position'] ?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
