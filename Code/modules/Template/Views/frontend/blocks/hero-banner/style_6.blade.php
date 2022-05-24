<section class="banner-section-six">
    <div class="auto-container">
        <div class="row">
            <div class="content-column col-lg-7 col-md-12 col-sm-12">
                <div class="inner-column wow fadeInUp animated" data-wow-delay="1000ms">
                    <div class="title-box">
                        <h3>{!! @clean($title) !!}</h3>
                        <div class="text">{{ $sub_title }}</div>
                    </div>

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

                    @if(!empty($popular_searches))
                        <div class="popular-searches">
                            <span class="title">{{ __("Popular Searches") }} : </span>
                            @foreach($popular_searches as $key => $val)
                                @if($key != 0), @endif
                                <a href="{{ route('job.search').'?s='.$val }}">{{ $val }}</a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="image-column col-lg-5 col-md-12">
                <div class="image-box">
                    @if(!empty($banner_image))
                        <figure class="main-image wow fadeIn" data-wow-delay="500ms">
                            <img src="{{ $banner_image_url }}" alt="banner image">
                        </figure>
                    @endif

                    @if(!empty($style_6_list_images))
                        @foreach($style_6_list_images as $key => $val)
                            @if($key == 0 && !empty($val['image_id']))
                                <!-- Info BLock One -->
                                    <div class="info_block anm wow fadeIn" data-wow-delay="1000ms" data-speed-x="2" data-speed-y="2">
                                        @if(!empty($val['url'])) <a href="{{ $val['url'] }}"> @endif
                                            <img src="{{ \Modules\Media\Helpers\FileHelper::url($val['image_id'], 'full') }}" alt="">
                                            @if(!empty($val['url'])) </a> @endif
                                    </div>
                            @endif
                            @if($key == 1 && !empty($val['image_id']))
                                <!-- Info BLock Two -->
                                    <div class="info_block_two anm wow fadeIn" data-wow-delay="2000ms" data-speed-x="1" data-speed-y="1">
                                        @if(!empty($val['url'])) <a href="{{ $val['url'] }}"> @endif
                                            <img src="{{ \Modules\Media\Helpers\FileHelper::url($val['image_id'], 'full') }}" alt="">
                                            @if(!empty($val['url'])) </a> @endif
                                    </div>
                            @endif
                            @if($key == 2 && !empty($val['image_id']))
                                <!-- Info BLock Three -->
                                    <div class="info_block_three anm wow fadeIn" data-wow-delay="1500ms" data-speed-x="4" data-speed-y="4">
                                        @if(!empty($val['url'])) <a href="{{ $val['url'] }}"> @endif
                                            <img src="{{ \Modules\Media\Helpers\FileHelper::url($val['image_id'], 'full') }}" alt="">
                                            @if(!empty($val['url'])) </a> @endif
                                    </div>
                            @endif
                            @if($key == 3 && !empty($val['image_id']))
                                <!-- Info BLock Four -->
                                    <div class="info_block_four anm wow fadeIn" data-wow-delay="2500ms" data-speed-x="3" data-speed-y="3">
                                        @if(!empty($val['url'])) <a href="{{ $val['url'] }}"> @endif
                                            <img src="{{ \Modules\Media\Helpers\FileHelper::url($val['image_id'], 'full') }}" alt="">
                                            @if(!empty($val['url'])) </a> @endif
                                    </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
