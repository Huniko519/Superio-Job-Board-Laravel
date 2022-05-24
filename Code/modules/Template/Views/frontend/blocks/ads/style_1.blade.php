<section class="ads-section">
    <div class="auto-container">
        <div class="row wow fadeInUp">
            @if(!empty($list_item))
                @foreach($list_item as $item)
                    <div class="advrtise-block col-lg-4 col-md-6 col-sm-12">
                        <div class="inner-box" style="background-image: url({{ get_file_url($item['image_id'],'full') }});">
                            <h4><span>{{ $item['title'] }} </span>{{ $item['sub_title'] }}</h4>
                            @if($item['ads_link'])<a href="{{ $item['ads_link'] }}" class="theme-btn btn-style-one">{{ $item['button_name'] }}</a>@endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
