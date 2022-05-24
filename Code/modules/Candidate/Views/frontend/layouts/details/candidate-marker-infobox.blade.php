@php $translation = $row->translateOrOrigin(app()->getLocale()); @endphp
<div class="map-box">
    <div class="map-listing-item">
        <div class="inner-box">
            <div class="infoBox-close"><i class="fa fa-times"></i></div>
            <div class="image-box">
                <figure class="image"><img src="{{ get_file_url($row->user->avatar_id) ?? asset('images/avatar.png') }}" alt="avatar"></figure>
            </div>
            <div class="content">
                <h3><a href="{{ $row->getDetailUrl() }}">{{ $row->user->getDisplayName() }}</a></h3>
                <ul class="job-info">
                    <li><span class="icon flaticon-briefcase"></span> {{ $translation->title }}</li>
                    @if($row->city)
                        <li><span class="icon flaticon-map-locator"></span> {{$row->city}}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
