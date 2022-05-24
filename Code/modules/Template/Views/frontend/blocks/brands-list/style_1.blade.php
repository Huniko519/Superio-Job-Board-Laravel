<div class="list-brands @if(!empty($style) && $style == 'style_2') clients-section-two @else clients-section @endif">
    <div class="sponsors-outer">
        <!--Sponsors Carousel-->
        <ul class="sponsors-carousel owl-carousel owl-theme">
            @if(!empty($list_item))
                @foreach($list_item as $item)
                    <li class="slide-item">
                        <figure class="image-box">
                            @if($item['brand_link'])<a href="{{ $item['brand_link'] }}">@endif
                                <img class="img-fluid d-inline-block w-auto" src="{{ get_file_url($item['image_id'],'full') }}" alt="{{ $item['title'] }}">
                            @if($item['brand_link'])</a>@endif
                        </figure>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>
