<div class="content">
    @if(empty($hide_avatar) && $company_logo = $row->getThumbnailUrl())
        <span class="company-logo">
            <img src="{{ $company_logo }}" alt="{{ $row->company ? $row->company->name : 'company' }}">
        </span>
    @endif
    <h4>{{ $translation->title }}</h4>
    <ul class="job-info">
        @if($row->category)
            @php $cat_translation = $row->category->translateOrOrigin(app()->getLocale()) @endphp
            <li><span class="icon flaticon-briefcase"></span> {{ $cat_translation->name }}</li>
        @endif
        @if($row->location)
            @php $location_translation = $row->location->translateOrOrigin(app()->getLocale()) @endphp
            <li><span class="icon flaticon-map-locator"></span> {{ $location_translation->name }}</li>
        @endif
        @if($row->created_at)
            <li><span class="icon flaticon-clock-3"></span> {{ $row->timeAgo() }}</li>
        @endif
        @if($row->salary_min)
            <li><span class="icon flaticon-money"></span> {{ $row->getSalary() }}</li>
        @endif
    </ul>
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
</div>


