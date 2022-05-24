<section class="ls-section map-layout">
    <div class="filters-backdrop"></div>

    <div class="ls-cotainer">
        <!-- Filters Column -->
        <div class="filters-column hide-left">
            <div class="inner-column">
                <div class="filters-outer">
                    <button type="button" class="theme-btn close-filters">X</button>
                    @include("Candidate::frontend.layouts.sidebars.category-sidebar")
                </div>
            </div>
        </div>

        <!-- Map Column -->
        <div class="map-column width-50">
            <div id="bravo_results_map" class="results_map_inner" style="height: 100%"></div>
        </div>

        <!-- Content Column -->
        <div class="content-column width-50">
            <div class="ls-outer">
                @if(!empty($rows) && count($rows) > 0)
                    <div class="ls-switcher">
                        <div class="showing-result show-filters">
                            <button type="button" class="theme-btn toggle-filters"><span class="icon icon-filter"></span> {{ __('Filter') }}</button>
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
                            @include("Candidate::frontend.layouts.loop.item-v1",['hide_profile' => 1])
                        </div>
                    @endforeach

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
