@if($row->video)
    <!-- Video Box -->
    <div class="video-outer">
        <h4>{{__('Job Video')}}</h4>
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
