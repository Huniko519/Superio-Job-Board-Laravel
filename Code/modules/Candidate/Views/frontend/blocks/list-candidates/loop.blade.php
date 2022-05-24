
<div class="candidate-block">
    <div class="inner-box">
        <figure class="image">
            @if($row->user)
                <img src="{{ $row->user->getAvatarUrl() }}" alt="{{$row->title ?? ''}}">
            @endif
        </figure>
        <h4 class="name">{{$row->user->getDisplayName()}}</h4>
        <span class="designation">{{$row->title}}</span>
        <div class="location"><i class="flaticon-map-locator"></i> {{$row->city}}, {{$row->country}}</div>
        <a href="{{ $row->getDetailUrl() }}" class="theme-btn btn-style-one"><span class="btn-title">{{__('View Profile')}}</span></a>
    </div>
</div>
