<section class="banner-section-four" @if(!empty($banner_image)) style="background-image: url({{ $banner_image_url }});" @endif>
    <div class="auto-container">
        <div class="cotnent-box">
            <div class="title-box wow fadeInUp" data-wow-delay="500ms">
                <h3>{!! @clean($title) !!}</h3>
            </div>

            <div class="job-search-form wow fadeInUp" data-wow-delay="1000ms">
                <form method="get" action="{{ route('job.search') }}">
                    <div class="row">
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                            <span class="icon flaticon-search-1"></span>
                            <input type="text" name="s" placeholder="{{ __('Job title, keywords, or company') }}">
                        </div>

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
                            <div class="form-group col-lg-3 col-md-12 col-sm-12 location smart-search">
                                <input type="text" class="smart-search-location parent_text form-control" placeholder="{{__("All City")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                                       data-default="{{ json_encode($list_json) }}">
                                <input type="hidden" class="child_id" name="location" value="{{ $location_id }}">
                                <span class="icon flaticon-map-locator"></span>
                            </div>
                        @else
                            <div class="form-group col-lg-3 col-md-12 col-sm-12 location bc-select-has-delete">
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

                        <div class="form-group col-lg-3 col-md-12 col-sm-12 category">
                            <span class="icon flaticon-briefcase"></span>
                            <select class="chosen-select" name="category">
                                <option value="">{{ __('All Categories')}}</option>
                                @foreach($list_categories as $cat)
                                    @php
                                        $translate = $cat->translateOrOrigin(app()->getLocale());
                                    @endphp
                                    <option value="{{ $cat->id }}" @if($cat->id == request()->get('category')) selected @endif  >{{ $translate->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                            <button type="submit" class="theme-btn btn-style-two">{{ __('Find Jobs') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            @if(!empty($popular_searches))
                <div class="popular-searches wow fadeInUp" data-wow-delay="1000ms">
                    <span class="title">{{ __("Popular Searches") }} : </span>
                    @foreach($popular_searches as $key => $val)
                        @if($key != 0), @endif
                        <a href="{{ route('job.search').'?s='.$val }}">{{ $val }}</a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
