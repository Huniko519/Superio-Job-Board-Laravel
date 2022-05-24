<section class="job-section">
    <div class="auto-container wow fadeInUp">
        <div class="sec-title text-center">
            <h2>{{ $title }}</h2>
            <div class="text">{{ $sub_title }}</div>
        </div>

        <div class="job-carousel owl-carousel owl-theme default-dots">
            @foreach($rows as $row)
                @php
                    $translation = $row->translateOrOrigin(app()->getLocale());
                @endphp
                <div class="job-block-three">
                    <div class="inner-box">
                        <div class="content">
                            @if($row->company && $company_logo = $row->getThumbnailUrl())
                                <span class="company-logo">
                                    <img src="{{ $company_logo }}" alt="{{ $row->company ? $row->company->name : 'company' }}">
                                </span>
                            @endif
                            <h4><a href="{{ $row->getDetailUrl() }}">{{ $translation->title }}</a></h4>
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
                        <ul class="job-other-info">
                            @if($row->jobType)
                                @php $jobType_translation = $row->jobType->translateOrOrigin(app()->getLocale()) @endphp
                                <li class="time">{{ $jobType_translation->name }}</li>
                            @endif
                            @if($row->is_urgent)
                                <li class="required">{{ __("Urgent") }}</li>
                            @endif
                        </ul>
                        <button class="bookmark-btn @if($row->wishlist) active @endif service-wishlist" data-id="{{$row->id}}" data-type="{{$row->type}}">
                            <img src="{{ asset('images/loading.gif') }}" class="loading-icon" alt="loading" />
                            <span class="flaticon-bookmark"></span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
