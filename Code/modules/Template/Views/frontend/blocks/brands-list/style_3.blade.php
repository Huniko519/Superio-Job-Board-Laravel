<section class="clients-section-two alternate">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>
        <div class="sponsors-outer wow fadeInUp">
            <!--Sponsors Carousel-->
            <ul class="sponsors-carousel owl-carousel owl-theme">
                @if(!empty($list_item))
                    @foreach($list_item as $item)
                        <li class="slide-item">
                            <figure class="image-box">
                                @if($item['brand_link'])<a href="{{ $item['brand_link'] }}">@endif
                                    <img src="{{ get_file_url($item['image_id'],'full') }}" alt="{{ $item['title'] }}">
                                    @if($item['brand_link'])</a>@endif
                            </figure>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</section>
