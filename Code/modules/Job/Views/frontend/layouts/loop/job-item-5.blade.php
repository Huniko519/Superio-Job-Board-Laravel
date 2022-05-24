@php
    $translation = $row->translateOrOrigin(app()->getLocale());
@endphp

<div class="inner-box">
    <ul class="job-other-info">
        @if($row->jobType)
            @php $jobType_translation = $row->jobType->translateOrOrigin(app()->getLocale()) @endphp
            <li class="time">{{ $jobType_translation->name }}</li>
        @endif
        @if($row->is_featured)
            <li class="privacy">{{ __("Featured") }}</li>
        @endif
        @if($row->is_urgent)
            <li class="required">{{ __("Urgent") }}</li>
        @endif
    </ul>
    @if($row->company && $company_logo = $row->getThumbnailUrl())
        <span class="company-logo">
            <a href="{{ $row->company->getDetailUrl() }}"><img src="{{ $company_logo }}" alt="{{ $row->company ? $row->company->name : 'company' }}" class="full-width object-cover"></a>
        </span>
    @endif
    <span class="company-name">{{ $row->company->name ?? '' }}</span>
    <h4><a href="{{ $row->getDetailUrl() }}">{{ $translation->title }}</a></h4>
    @if($row->location)
        @php $location_translation = $row->location->translateOrOrigin(app()->getLocale()) @endphp
        <div class="location"><span class="icon flaticon-map-locator"></span>{{ $location_translation->name }}</div>
    @endif
    <ul class="post-tags">
        @if(!empty($row->skills))
            @php $counter = count($row->skills) - 3; @endphp
            @foreach($row->skills as $k => $skill)
                @if($k > 2) @continue @endif
                @php $translation = $skill->translateOrOrigin(app()->getLocale()); @endphp
                <li><a href="{{ $skill->getDetailUrl() }}">{{ ucfirst($translation->name) }}</a></li>
            @endforeach
            @if($counter > 0)
                <li class="colored">+{{$counter}}</li>
            @endif
        @endif
    </ul>
</div>
