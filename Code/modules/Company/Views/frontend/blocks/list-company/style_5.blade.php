<section class="top-companies">
    <div class="auto-container">
        <div class="sec-title-outer">
            <div class="sec-title">
                <h2>{{ $title }}</h2>
                <div class="text">{{ $sub_title }}</div>
            </div>
            @if(!empty($load_more_url))
                <a href="{{ $load_more_url }}" class="link">{{ __('Browse All') }}<span class="icon fa fa-angle-right"></span></a>
            @endif
        </div>

        <div class="row wow fadeInUp">
            @foreach($rows as $row)
                @php
                    $translation = $row->translateOrOrigin(app()->getLocale());
                @endphp
            <div class="company-block-two col-lg-6 col-md-12 col-sm-12">
                <div class="inner-box">
                    <div class="content">
                        <figure class="image">
                            @if($image_tag = get_image_tag($row->avatar_id,'full',['alt'=>$translation->title]))
                                {!! $image_tag !!}
                            @endif
                        </figure>
                        <h4 class="name">{{ $translation->name }}</h4>
                        @if($row->location)
                            <div class="location"><i class="flaticon-map-locator"></i> {{ $row->location->name }}</div>
                        @endif
                    </div>
                    <a href="{{$row->getDetailUrl()}}" class="theme-btn btn-style-three">{{ __(":count Open Position",["count"=> number_format($row->job_count)]) }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
