@php $translation = $row->translateOrOrigin(app()->getLocale()); @endphp
<div class="map-box">
    <div class="map-listing-item">
        <div class="inner-box">
            <div class="infoBox-close"><i class="fa fa-times"></i></div>
            <div class="image-box">
                <a class="image" href="{{ $row->getDetailUrl() }}"><img src="{{ get_file_url($row->avatar_id) ?? asset('images/avatar.png') }}" alt="{{ $translation->name }}"></a>
            </div>
            <div class="content">
                <h3><a href="{{ $row->getDetailUrl() }}">{{ $translation->name }}</a></h3>
                <ul class="job-info">
                    @if($row->location)
                        @php $location_translation = $row->location->translateOrOrigin(app()->getLocale()); @endphp
                        <li><span class="icon flaticon-map-locator"></span> {{ $location_translation->name }}</li>
                    @endif
                    @php $category = $row->category; @endphp
                    @if(!empty($category))
                        @php $t = $category->translateOrOrigin(app()->getLocale()); @endphp
                        <li><span class="icon flaticon-briefcase"></span> {{$t->name ?? ''}}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
