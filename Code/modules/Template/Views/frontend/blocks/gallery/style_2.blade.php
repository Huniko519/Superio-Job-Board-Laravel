<section class="features-section">
    <div class="auto-container">
        <div class="sec-title-outer">
            <div class="sec-title">
                <h2>{{ $title }}</h2>
                <div class="text">{{ $sub_title }}</div>
            </div>
            @if(!empty($load_more_url))
            <a href="{{ $load_more_url }}" class="link">{{ $load_more_name }}<span class="fa fa-angle-right"></span></a>
            @endif
        </div>

        <div class="row wow fadeInUp">
            @if(!empty($list_item2))
            @foreach($list_item2 as $item)
                <div class="column col-lg-4 col-md-6 col-sm-12">
                    <!-- Feature Block -->
                    @foreach($item as $item_v2)
                        <div class="feature-block">
                            <div class="inner-box">
                                <figure class="image"><img src="{{ get_file_url($item_v2['image_id'],'full') }}" alt=""></figure>
                                <div class="overlay-box">
                                    <div class="content">
                                        <h5>{{ $item_v2['title'] }}</h5>
                                        <span class="total-jobs">{{ $item_v2['sub_title'] }}</span>
                                        <a href="{{ $item_v2['url_item'] }}" class="overlay-link"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
