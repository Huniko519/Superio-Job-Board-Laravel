<section class="candidates-section-two">
    <div class="auto-container">
        <div class="sec-title">
            <h2>{{$title}}</h2>
            <div class="text">{{$desc}}</div>
        </div>

        <div class="carousel-outer wow fadeInUp">
            <div class="row">
                @foreach($rows as $row)
                    <div class="candidate-block-two col-lg-6 col-md-12 col-sm-12">
                        <div class="inner-box">
                            <div class="content-box">
                                <figure class="image"><img src="{{get_file_url($row->user->avatar_id,'medium')}}" alt="{{$row->title ?? ''}}"></figure>
                                <h4 class="name">{{$row->user->getDisplayName()}}</h4>
                                <span class="designation">{{$row->title}}</span>
                                <div class="location"><i class="flaticon-map-locator"></i> {{$row->city}}, {{$row->country}}</div>
                            </div>
                            <a href="{{ $row->getDetailUrl() }}" class="theme-btn btn-style-three">{{__('View Profile')}}</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
