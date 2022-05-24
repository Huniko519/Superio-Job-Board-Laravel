<!-- Banner Section-->
<section class="banner-section-two">
    <div class="auto-container">
        <div class="row">
            <div class="content-column col-lg-7 col-md-12 col-sm-12">
                <div class="inner-column wow fadeInUp">
                    <div class="title-box">
                        <h3>{!! @clean($title) !!}</h3>
                        <div class="text">{{ $sub_title }}</div>
                    </div>

                    <!-- Job Search Form -->
                    <div class="job-search-form">
                        <form method="GET" action="{{ route('job.search') }}">
                            <div class="row">
                                <div class="form-group col-lg-5 col-md-12 col-sm-12">
                                    <span class="icon flaticon-search-1"></span>
                                    <input type="text" name="s" placeholder="{{ __("Job title...") }}">
                                </div>
                                <!-- Form Group -->
                                @if($location_style == 'autocomplete')
                                    @php
                                        $location_name = "";
                                        $list_json = [];
                                        $location_id = request()->get('location');
                                        $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json, &$location_name, $location_id) {
                                            foreach ($locations as $location) {
                                                $translate = $location->translateOrOrigin(app()->getLocale());
                                                if ($location_id == $location->id) {
                                                    $location_name = $translate->name;
                                                }
                                                $list_json[] = [
                                                    'id'    => $location->id,
                                                    'title' => $prefix.' '.$translate->name,
                                                ];
                                                $traverse($location->children, $prefix.'-');
                                            }
                                        };
                                        $traverse($list_locations);
                                    @endphp
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12 location smart-search">
                                        <input type="text" class="smart-search-location parent_text form-control" placeholder="{{__("All City")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                                               data-default="{{ json_encode($list_json) }}">
                                        <input type="hidden" class="child_id" name="location" value="{{ $location_id }}">
                                        <span class="icon flaticon-map-locator"></span>
                                    </div>
                                @else
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12 location bc-select-has-delete">
                                        <span class="icon flaticon-map-locator"></span>
                                        <select class="chosen-select" name="location">
                                            <option value="">{{ __("All City") }}</option>
                                            @php
                                            $traverse = function ($locations, $prefix = '') use (&$traverse) {
                                                foreach ($locations as $location) {
                                                    $translate = $location->translateOrOrigin(app()->getLocale());
                                                    printf("<option value='%s'>%s</option>", $location->id, $prefix . ' ' . $translate->name);
                                                    $traverse($location->children, $prefix . '-');
                                                }
                                            };
                                            $traverse($list_locations);
                                            @endphp
                                        </select>
                                    </div>
                                @endif
                                <!-- Form Group -->
                                <div class="form-group col-lg-3 col-md-12 col-sm-12 text-right">
                                    <button type="submit" class="theme-btn btn-style-one"><span class="btn-title">{{ __("Find Jobs") }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Job Search Form -->
                    @if(!empty($popular_searches))
                        <!-- Popular Search -->
                        <div class="popular-searches">
                            <span class="title">{{ __("Popular Searches") }} : </span>
                            @foreach($popular_searches as $key => $val)
                                @if($key != 0), @endif
                                <a href="{{ route('job.search').'?s='.$val }}">{{ $val }}</a>
                            @endforeach
                        </div>
                        <!-- End Popular Search -->
                    @endif

                    <div class="bottom-box">
                        <div class="count-employers">
                            @if($banner_image_2)
                                <img src="{{ \Modules\Media\Helpers\FileHelper::url($banner_image_2, 'full') }}" alt="img">
                            @endif
                        </div>
                        @if(!empty($upload_cv_url))
                            <a href="{{ $upload_cv_url }}" class="upload-cv"><span class="icon flaticon-file"></span> {{ __("Upload your CV") }}</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="image-column col-lg-5 col-md-12">
                <div class="image-box">
                    @if(!empty($banner_image))
                        <figure class="main-image anm"  data-wow-delay="1000ms" data-speed-x="2" data-speed-y="2">
                            <img src="{{ $banner_image_url }}" alt="banner image">
                        </figure>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Section-->
