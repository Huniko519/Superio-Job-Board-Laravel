<!--Page Title-->
<section class="page-title style-two">
    <div class="auto-container">
        <!-- Job Search Form -->
        <div class="job-search-form">
            <form method="get" action="">
                <input type="hidden" name="_layout" value="{{$layout}}" />
                <input type="hidden" name="skill" value="{{request()->get('skill')}}" />
                <input type="hidden" name="date_posted" value="{{request()->get('date_posted')}}" />
                <input type="hidden" name="experience_year" value="{{request()->get('experience_year')}}" />
                <input type="hidden" name="education_level" value="{{request()->get('education_level')}}" />
                <input type="hidden" name="orderby" value="{{request()->get('orderby')}}" />
                <input type="hidden" name="limit" value="{{request()->get('limit')}}" />
                <div class="row">
                    <!-- Form Group -->
                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                        <span class="icon flaticon-search-1"></span>
                        <input type="text" name="s" value="{{ request()->input('s') }}" placeholder="{{ __("Candidate title...") }}">
                    </div>

                    <!-- Form Group -->
                    @php $location_search_style = setting_item('candidate_location_search_style') @endphp
                    @if($location_search_style == 'autocomplete')
                        <?php
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
                        ?>
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 location smart-search">
                            <input type="text" class="smart-search-location parent_text form-control" placeholder="{{__("Choose a location")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                                   data-default="{{ json_encode($list_json) }}">
                            <input type="hidden" class="child_id" name="location" value="{{ $location_id }}">
                            <span class="icon flaticon-map-locator"></span>
                        </div>
                    @else
                        <div class="form-group col-lg-3 col-md-12 col-sm-12 location bc-select-has-delete">
                            <span class="icon flaticon-map-locator"></span>
                            <select class="chosen-select" name="location">
                                <option value="">{{ __("Choose a location") }}</option>
                                @if(!empty($list_locations))
                                    @foreach($list_locations as $location)
                                        @php
                                            $translate = $location->translateOrOrigin(app()->getLocale());
                                        @endphp
                                        <option value="{{ $location->id }}" @if($location->id == request()->get('location')) selected @endif  >{{ $translate->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    @endif

                    <!-- Form Group -->
                    <div class="form-group col-lg-3 col-md-12 col-sm-12 location">
                        <span class="icon flaticon-briefcase"></span>
                        <select class="chosen-select" name="category">
                            <option value="">{{ __("Choose a category") }}</option>
                            @if(!empty($list_categories))
                            @foreach($list_categories as $cat)
                                @php
                                    $translate = $cat->translateOrOrigin(app()->getLocale());
                                @endphp
                                <option value="{{ $cat->id }}" @if($cat->id == request()->get('category')) selected @endif  >{{ $translate->name }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Form Group -->
                    <div class="form-group col-lg-2 col-md-12 col-sm-12 text-right">
                        <button type="submit" class="theme-btn btn-style-one">{{__('Find Candidates')}}</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- Job Search Form -->
    </div>
</section>
<!--End Page Title-->

<!-- Listing Section -->
<section class="ls-section">
    <div class="auto-container">
        <div class="filters-backdrop"></div>

        <div class="row">
            <!-- Content Column -->
            <div class="content-column col-lg-12">
                <div class="ls-outer">
                    <!-- ls Switcher -->
                    <div class="ls-switcher">
                        <form class="bc-form-order" method="get">
                            <input type="hidden" name="_layout" value="{{$layout}}" />
                            <input type="hidden" name="location" value="{{request()->get('location')}}" />
                            <input type="hidden" name="category" value="{{request()->get('category')}}" />
                            <input type="hidden" name="orderby" value="{{request()->get('orderby')}}" />
                            <input type="hidden" name="limit" value="{{request()->get('limit')}}" />
                            <div class="showing-result">
                                <div class="top-filters">
                                    <div class="form-group">
                                        <select class="chosen-select" name="skill" onchange="this.form.submit()">
                                            <option value="">{{ __("Choose a skill") }}</option>
                                            @foreach($list_skills as $skill)
                                                @php
                                                    $translate = $skill->translateOrOrigin(app()->getLocale());
                                                @endphp
                                                <option value="{{ $skill->id }}" @if($skill->id == request()->get('skill')) selected @endif  >{{ $translate->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select class="chosen-select" name="date_posted" onchange="this.form.submit()">
                                            <option @if(request()->get('date_posted') == "all") selected @endif value="all">{{ __("Date Posted") }}</option>
                                            <option @if(request()->get('date_posted') == "last_hour") selected @endif value="last_hour">{{ __("Last Hour") }}</option>
                                            <option @if(request()->get('date_posted') == "last_1") selected @endif value="last_1">{{ __("Last 24 Hours") }}</option>
                                            <option @if(request()->get('date_posted') == "last_7") selected @endif value="last_7">{{ __("Last 7 Days") }}</option>
                                            <option @if(request()->get('date_posted') == "last_14") selected @endif value="last_14">{{ __("Last 14 Days") }}</option>
                                            <option @if(request()->get('date_posted') == "last_30") selected @endif value="last_30">{{ __("Last 30 Days") }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group" >
                                        <select class="chosen-select" name="experience_year" onchange="this.form.submit()">
                                            <option value="">{{ __("Choose an experience") }}</option>
                                            <option @if(request()->get('experience_year') == "fresh") selected @endif value="fresh">{{ __("Fresh") }}</option>
                                            <option @if(request()->get('experience_year') == "1") selected @endif value="1">{{ __("1 Year") }}</option>
                                            <option @if(request()->get('experience_year') == "2") selected @endif value="2">{{ __("2 Years") }}</option>
                                            <option @if(request()->get('experience_year') == "3") selected @endif value="3">{{ __("3 Years") }}</option>
                                            <option @if(request()->get('experience_year') == "4") selected @endif value="4">{{ __("4 Years") }}</option>
                                            <option @if(request()->get('experience_year') == "5") selected @endif value="5">{{ __("5 Years") }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group" >
                                        <select class="chosen-select" name="education_level" onchange="this.form.submit()">
                                            <option value="">{{ __("Choose an education level") }}</option>
                                            <option @if(request()->get('education_level') == "certificate") selected @endif value="certificate">{{ __("Certificate") }}</option>
                                            <option @if(request()->get('education_level') == "diploma") selected @endif value="diploma">{{ __("Diploma") }}</option>
                                            <option @if(request()->get('education_level') == "associate") selected @endif value="associate">{{ __("Associate Degree") }}</option>
                                            <option @if(request()->get('education_level') == "bachelor") selected @endif value="bachelor">{{ __("Bachelor Degree") }}</option>
                                            <option @if(request()->get('education_level') == "master") selected @endif value="master">{{ __("Master’s Degree") }}</option>
                                            <option @if(request()->get('education_level') == "professional") selected @endif value="professional">{{ __("Professional’s Degree") }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <form class="bc-form-order" method="get">
                            <input type="hidden" name="_layout" value="{{$layout}}" />
                            <input type="hidden" name="location" value="{{request()->get('location')}}" />
                            <input type="hidden" name="category" value="{{request()->get('category')}}" />
                            <input type="hidden" name="skill" value="{{request()->get('skill')}}" />
                            <input type="hidden" name="date_posted" value="{{request()->get('date_posted')}}" />
                            <input type="hidden" name="experience_year" value="{{request()->get('experience_year')}}" />
                            <input type="hidden" name="education_level" value="{{request()->get('education_level')}}" />
                            <div class="sort-by">
                                <select class="chosen-select" name="orderby" onchange="this.form.submit()">
                                    <option value="">{{__('Sort by (Default)')}}</option>
                                    <option value="new" @if(request()->get('orderby') == 'new') selected @endif>{{__('Newest')}}</option>
                                    <option value="old" @if(request()->get('orderby') == 'old') selected @endif>{{__('Oldest')}}</option>
                                    <option value="name_high" @if(request()->get('orderby') == 'name_high') selected @endif>{{__('Name [a->z]')}}</option>
                                    <option value="name_low" @if(request()->get('orderby') == 'name_low') selected @endif>{{__('Name [z->a]')}}</option>
                                </select>

                                <select class="chosen-select" name="limit" onchange="this.form.submit()">
                                    <option value="10" @if(request()->get('limit') == 10) selected @endif >{{ __("Show 10") }}</option>
                                    <option value="20" @if(request()->get('limit') == 20) selected @endif >{{ __("Show 20") }}</option>
                                    <option value="30" @if(request()->get('limit') == 30) selected @endif >{{ __("Show 30") }}</option>
                                    <option value="40" @if(request()->get('limit') == 40) selected @endif >{{ __("Show 40") }}</option>
                                    <option value="50" @if(request()->get('limit') == 50) selected @endif >{{ __("Show 50") }}</option>
                                    <option value="60" @if(request()->get('limit') == 60) selected @endif >{{ __("Show 60") }}</option>
                                </select>
                            </div>
                        </form>
                    </div>


                    @if(!empty($rows) && count($rows) > 0)
                    <div class="row">

                        @foreach($rows as $row)
                            <div class="candidate-block-four col-lg-4 col-md-6 col-sm-12">
                                @include("Candidate::frontend.layouts.loop.item-v3")
                            </div>
                        @endforeach
                    </div>

                    <!-- Listing pagination -->
                    <div class="ls-pagination">
                        {{$rows->appends(request()->query())->links()}}
                    </div>
                    @else
                        <div class="candidate-results-not-found">
                            <h3>{{ __("No candidate results found") }}</h3>
                        </div>
                    @endif
                </div>
            </div>
            <div class="filters-column col-lg-12 col-md-12 col-sm-12">
                <div class="inner-column">
                @php
                    $candidate_sidebar_cta = setting_item_with_lang('candidate_sidebar_cta',request()->query('lang'), $settings['candidate_sidebar_cta'] ?? false);
                    if(!empty($candidate_sidebar_cta)) $candidate_sidebar_cta = json_decode($candidate_sidebar_cta);

                @endphp
                @if(!empty($candidate_sidebar_cta->title))
                    <!-- Call To Action -->
                        <div class="call-to-action-four">
                            <h5>{{ $candidate_sidebar_cta->title ?? '' }}</h5>
                            <p>{{ $candidate_sidebar_cta->desc ?? '' }}</p>
                            @if(!empty($candidate_sidebar_cta->button->url))
                                <a href="{{ ($candidate_sidebar_cta->button->url) }}" target="_{{ $candidate_sidebar_cta->button->target ?? "self" }}" class="theme-btn btn-style-one bg-blue">
                                    <span class="btn-title">{{ $candidate_sidebar_cta->button->name ?? __("Start Recruiting Now") }}</span>
                                </a>
                            @endif
                            <div class="image" style="background-image: url({{ !empty($candidate_sidebar_cta->image) ? \Modules\Media\Helpers\FileHelper::url($candidate_sidebar_cta->image, 'full') : '' }});"></div>
                        </div>
                        <!-- End Call To Action -->
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!--End Listing Page Section -->
