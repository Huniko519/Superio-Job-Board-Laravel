<div class="job-detail">
    <h4>{{__('Candidates About')}}</h4>
{!! clean($row->user->bio) !!}
<!-- Resume / Education -->

    @if(!empty($row->education))
        <div class="resume-outer">
            <div class="upper-title">
                <h4>{{__('Education')}}</h4>
            </div>
            <div class="my_resume_eduarea">
                @foreach($row->education as $oneData)
                    <div class="resume-block">
                        <div class="inner">
                            <span class="name">{{@$oneData['location'][0]}}</span>
                            <div class="title-box">
                                <div class="info-box">
                                    <h3>{{@$oneData['reward']}}</h3>
                                    <span>{{@$oneData['location']}}</span>
                                </div>
                                <div class="edit-box">
                                    <span class="year">{{@$oneData['from']}} - {{@$oneData['to']}}</span>
                                </div>
                            </div>
                            <div class="text">{!! nl2br(strip_tags(@$oneData['information'])) !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(!empty($row->experience))
    <!-- Resume / Work & Experience -->
        <div class="resume-outer theme-blue">
            <div class="upper-title">
                <h4>{{__('Work & Experience')}}</h4>
            </div>
            @foreach($row->experience as $oneData)
                <div class="resume-block">
                    <div class="inner">
                        <span class="name">{{@$oneData['location'][0]}}</span>
                        <div class="title-box">
                            <div class="info-box">
                                <h3>{{@$oneData['position']}}</h3>
                                <span>{{@$oneData['location']}}</span>
                            </div>
                            <div class="edit-box">
                                <span class="year">{{@$oneData['from']}} - {{@$oneData['to']}}</span>
                            </div>
                        </div>
                        <div class="text">{!! nl2br(strip_tags(@$oneData['information'])) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($row->getGallery())
    <!-- Portfolio -->
        <div class="portfolio-outer">
            <div class="row">
                @foreach($row->getGallery() as $key=>$item)
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                        <figure class="image">
                            <a href="{{$item['large']}}" class="lightbox-image"><img src="{{$item['thumb']}}" alt=""></a>
                            <span class="icon flaticon-plus"></span>
                        </figure>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if(!empty($row->award))
    <!-- Resume / Awards -->
        <div class="resume-outer theme-yellow">
            <div class="upper-title">
                <h4>{{__('Awards')}}</h4>
            </div>
            @foreach($row->award as $oneData)
                <div class="resume-block">
                    <div class="inner">
                        <span class="name"></span>
                        <div class="title-box">
                            <div class="info-box">
                                <h3>{{@$oneData['reward']}}</h3>
                                <span></span>
                            </div>
                            <div class="edit-box">
                                <span class="year">{{@$oneData['from']}} - {{@$oneData['to']}}</span>
                            </div>
                        </div>
                        <div class="text">{!! nl2br(strip_tags(@$oneData['information'])) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($row->video)
    <!-- Video Box -->
        <div class="video-outer">
            <h4>{{__('Candidates About')}}</h4>
            <div class="video-box">
                <figure class="image">
                    <a href="{{$row->video}}" class="play-now" data-fancybox="gallery" data-caption="">
                        @if($row->video_cover_id)
                            <img src="{{ get_file_url($row->video_cover_id, 'full') }}" alt="">
                        @else
                            <img src="{{ asset('images/resource/video-img.jpg') }}" alt="">
                        @endif
                        <i class="icon flaticon-play-button-3" aria-hidden="true"></i>
                    </a>
                </figure>
            </div>
        </div>
    @endif
</div>



