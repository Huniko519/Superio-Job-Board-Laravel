@php $translation = $row->translateOrOrigin(app()->getLocale()); @endphp
<div class="map-box">
    <div class="map-listing-item">
        <div class="inner-box">
            <div class="infoBox-close"><i class="fa fa-times"></i></div>
            @if($row->company && $company_logo = $row->getThumbnailUrl())
                <div class="image-box">
                    <a class="image" href="{{ $row->company->getDetailUrl() }}"><img src="{{ $company_logo }}" alt="{{ $row->company ? $row->company->name : 'company' }}"></a>
                </div>
            @endif
            <div class="content">
                <h3><a href="{{ $row->getDetailUrl() }}">{{ $translation->title }}</a></h3>
                <ul class="job-info">
                    @if($row->category)
                        @php $cat_translation = $row->category->translateOrOrigin(app()->getLocale()) @endphp
                        <li><span class="icon flaticon-briefcase"></span> {{ $cat_translation->name }}</li>
                    @endif
                    @if($row->location)
                        @php $location_translation = $row->location->translateOrOrigin(app()->getLocale()) @endphp
                        <li><span class="icon flaticon-map-locator"></span> {{ $location_translation->name }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
