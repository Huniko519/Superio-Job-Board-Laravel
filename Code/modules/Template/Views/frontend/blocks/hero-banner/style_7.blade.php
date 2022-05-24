<!-- Banner Section-->
<section class="banner-section-seven">
    <div class="image-outer">
        @if(!empty($banner_image))
            <figure class="image"><img src="{{ $banner_image_url }}" alt="image"></figure>
        @endif
    </div>
    <div class="auto-container">
        <div class="row">
            <div class="content-column col-lg-7 col-md-12 col-sm-12">
                <div class="inner-column">
                    <div class="title-box wow fadeInUp" data-wow-delay="500ms">
                        <h3>{!! @clean($title) !!}</h3>
                        <div class="text">{{ $sub_title }}</div>
                    </div>

                    <!-- Job Search Form -->
                    <div class="job-search-form">
                        <form method="get" action="{{ route('job.search') }}">
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
                                <div class="form-group col-lg-3 col-md-12 col-sm-12 btn-box">
                                    <button type="submit" class="theme-btn btn-style-one"><span class="btn-title">{{ __("Find Jobs") }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Job Search Form -->

                    <!-- Popular Search -->
                    @if(!empty($popular_searches))
                        <div class="popular-searches wow fadeInUp" data-wow-delay="1500ms">
                            <span class="title">{{ __("Popular Searches") }} : </span>
                            @foreach($popular_searches as $key => $val)
                                @if($key != 0), @endif
                                <a href="{{ route('job.search').'?s='.$val }}">{{ $val }}</a>
                            @endforeach
                        </div>
                    @endif
                    <!-- End Popular Search -->

                    <!--Clients Section-->
                    @if(!empty($style_7_list_images))
                    <section class="clients-section-two wow fadeInUp" data-wow-delay="2000ms">
                        <!--Sponsors Carousel-->
                        <ul class="sponsors-carousel-two owl-carousel owl-theme">
                            @foreach($style_7_list_images as $key => $val)
                            <li class="slide-item">
                                <figure class="image-box">
                                    @if(!empty($val['url'])) <a href="{{ $val['url'] }}"> @endif
                                        <img src="{{ \Modules\Media\Helpers\FileHelper::url($val['image_id'], 'full') }}" alt="">
                                    @if(!empty($val['url'])) </a> @endif
                                </figure>
                            </li>
                            @endforeach
                        </ul>
                    </section>
                    @endif
                    <!-- End Clients Section-->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Section-->
