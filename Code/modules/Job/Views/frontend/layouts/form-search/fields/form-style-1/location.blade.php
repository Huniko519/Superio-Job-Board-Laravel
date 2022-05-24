<!-- Filter Block -->
@php $location_search_style = setting_item('job_location_search_style') @endphp
@if($list_locations)
    <div class="filter-block">
        <h4>{{ $val['title'] }}</h4>
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
            <div class="form-group smart-search">
                <input type="text" class="smart-search-location parent_text form-control" placeholder="{{__("Choose a location")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                       data-default="{{ json_encode($list_json) }}">
                <input type="hidden" class="child_id" name="location" value="{{ $location_id }}">
                <span class="icon flaticon-map-locator"></span>
            </div>
        @else
            <div class="form-group bc-select-has-delete">
                <select class="chosen-select" name="location">
                    <option value="">{{ __("Choose a location") }}</option>
                    @php
                        $location_id = request()->get('location');
                        $traverse = function ($locations, $prefix = '') use (&$traverse, $location_id) {
                            foreach ($locations as $location) {
                                $selected = '';
                                if ($location_id == $location->id)
                                    $selected = 'selected';
                                $translate = $location->translateOrOrigin(app()->getLocale());
                                printf("<option value='%s' %s>%s</option>", $location->id, $selected, $prefix . ' ' . $translate->name);
                                $traverse($location->children, $prefix . '-');
                            }
                        };
                        $traverse($list_locations);
                    @endphp
                </select>
                <span class="icon flaticon-map-locator"></span>
            </div>
        @endif
    </div>
@endif
