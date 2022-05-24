@if(!empty($list_item))
    <section class="process-section pt-0">
        <div class="auto-container">
            <div class="sec-title text-center">
                <h2>{{ $title ?? '' }}</h2>
                <div class="text">{{ $sub_title ?? '' }}</div>
            </div>

            <div class="row wow fadeInUp">
                @foreach($list_item as $item)
                    <div class="process-block col-lg-4 col-md-6 col-sm-12">
                        <div class="icon-box"><img src="{{ get_file_url($item['icon_image']) }}" alt="{{ $item['title'] }}"></div>
                        <h4>{!! clean($item['title']) ?? '' !!}</h4>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
