<div class="listing-maps">
    <div id="bravo_results_map" class="results_map_inner" style="min-height: 500px"></div>
</div>

<!-- Listing Section -->
<section class="ls-section">
    <div class="auto-container">
        <div class="filters-backdrop"></div>

        <div class="row">

            <!-- Filters Column -->
            <div class="filters-column col-lg-4 col-md-12 col-sm-12">
                <div class="inner-column">
                    <div class="filters-outer">
                        <button type="button" class="theme-btn close-filters">X</button>
                        @include("Candidate::frontend.layouts.sidebars.category-sidebar")
                    </div>

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

            <!-- Content Column -->
            <div class="content-column col-lg-8 col-md-12 col-sm-12">
                <div class="ls-outer">
                    <button type="button" class="theme-btn btn-style-two toggle-filters">{{ __("Show Filters") }}</button>

                @if(!empty($rows) && count($rows) > 0)
                    <!-- ls Switcher -->
                        <div class="ls-switcher">
                            <div class="showing-result">
                                <div class="text">{{ __("Showing") }} <strong>{{ $rows->firstItem() }}-{{ $rows->lastItem() }}</strong> {{ __("of") }} <strong>{{ $rows->total() }}</strong> {{ __("candidates") }}</div>
                            </div>
                            <form class="bc-form-order" method="get">
                                <div class="sort-by">
                                    <input type="hidden" name="_layout" value="{{$layout}}" />
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


                        @foreach($rows as $row)
                            <div class="candidate-block-three">
                                @include("Candidate::frontend.layouts.loop.item-v1")
                            </div>
                        @endforeach

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
        </div>
    </div>
</section>

@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        var bravo_map_data = {
            markers:{!! json_encode($markers) !!},
            center: [{{ !empty($markers[0]['lat']) ? $markers[0]['lat'] : 40.80 }}, {{ !empty($markers[0]['lng']) ? $markers[0]['lng'] : -73.70 }}]
        };
    </script>
    <script type="text/javascript" src="{{ asset('module/candidate/js/candidate-map.js?_ver='.config('app.asset_version')) }}"></script>
    <script>
        jQuery(".view-more").on("click", function () {
            jQuery(this).closest('ul').find('li.tg').toggleClass("d-none");
            jQuery(this).find('.tg-text').toggleClass('d-none');
        });
    </script>
@endsection
