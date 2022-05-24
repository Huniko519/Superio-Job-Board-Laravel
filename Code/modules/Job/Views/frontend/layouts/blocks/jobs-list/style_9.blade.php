<section class="job-section-four alternate">
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>

        <div class="row wow fadeInUp">
            @foreach($rows as $row)
                @php
                    $translation = $row->translateOrOrigin(app()->getLocale());
                @endphp
                <div class="job-block-four col-xl-3 col-lg-4 col-md-6 col-sm-12">
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
                                    <img src="{{ $company_logo }}" alt="{{ $row->company ? $row->company->name : 'company' }}">
                                </span>
                        @endif
                        @if($row->company)
                            <span class="company-name">{{ $row->company ? $row->company->name : 'company' }}</span>
                        @endif
                        <h4><a href="{{ $row->getDetailUrl() }}">{{ $translation->title }}</a></h4>
                        @if($row->location)
                            @php $location_translation = $row->location->translateOrOrigin(app()->getLocale()) @endphp
                            <div class="location"><span class="icon flaticon-map-locator"></span> {{ $location_translation->name }}</div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        @if(!empty($load_more_url))
            <div class="btn-box">
                <a href="{{ $load_more_url }}" class="theme-btn btn-style-one">{{ __("Load More Listing") }}</a>
            </div>
        @endif
    </div>
</section>
