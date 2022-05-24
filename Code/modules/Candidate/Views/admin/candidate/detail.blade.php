@extends('admin.layouts.app')

@section('content')
    <form action="{{route('candidate.admin.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post" class="dungdt-form">
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{__('My Profile')}}</h1>
                    @if($row->slug)
                        <p class="item-url-demo">{{__("Permalink")}}: {{ url( (request()->query('lang') ? request()->query('lang').'/' : '').config('candidate.candidate_route_prefix'))  }}/<a href="#" class="open-edit-input" data-name="slug">{{$row->slug}}</a>
                        </p>
                    @endif
                </div>
                <div class="">
                    @if($row->slug)
                        <a class="btn btn-primary btn-sm" href="{{$row->getDetailUrl(request()->query('lang'))}}" target="_blank">{{__("View Link")}}</a>
                    @endif
                </div>
            </div>
            @include('admin.message')
{{--            @include('Language::admin.navigation')--}}
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="panel-title"><strong>{{ __('Candidate content')}}</strong></div>
                            <div class="panel-body">
                                @csrf
                                @include('Candidate::admin/candidate/form',['row'=> $row])
                            </div>
                        </div>

                        @if(is_default_lang())
                            <div class="panel">
                                <div class="panel-title"><strong>{{__("Location")}}</strong></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="">{{__("Country")}}</label>
                                                <select name="country" class="form-control" id="country-sms-testing">
                                                    <option value="">{{__('-- Select --')}}</option>
                                                    @foreach(get_country_lists() as $id=>$name)
                                                        <option @if($row->country==$id) selected @endif value="{{$id}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{__("City")}}</label>
                                                <input type="text" value="{{old('city',$row->city)}}" name="city" placeholder="{{__("City")}}" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>{{ __('Address Line')}}</label>
                                                <input type="text" value="{{old('address',$row->address)}}" placeholder="{{ __('Address')}}" name="address" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{__("Location")}}</label>
                                        @if(!empty($is_smart_search))
                                            <div class="form-group-smart-search">
                                                <div class="form-content">
                                                    <?php
                                                    $location_name = "";
                                                    $list_json = [];
                                                    $traverse = function ($locations, $prefix = '') use (&$traverse, &$list_json , &$location_name,$row) {
                                                        foreach ($locations as $location) {
                                                            $translate = $location->translateOrOrigin(app()->getLocale());
                                                            if ($row->location_id == $location->id){
                                                                $location_name = $translate->name;
                                                            }
                                                            $list_json[] = [
                                                                'id' => $location->id,
                                                                'title' => $prefix . ' ' . $translate->name,
                                                            ];
                                                            $traverse($location->children, $prefix . '-');
                                                        }
                                                    };
                                                    $traverse($locations);
                                                    ?>
                                                    <div class="smart-search">
                                                        <input type="text" class="smart-search-location parent_text form-control" placeholder="{{__("-- Please Select --")}}" value="{{ $location_name }}" data-onLoad="{{__("Loading...")}}"
                                                               data-default="{{ json_encode($list_json) }}">
                                                        <input type="hidden" class="child_id" name="location_id" value="{{$row->location_id ?? Request::query('location_id')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="">
                                                <select name="location_id" class="form-control">
                                                    <option value="">{{__("-- Please Select --")}}</option>
                                                    <?php
                                                    $traverse = function ($locations, $prefix = '') use (&$traverse, $row) {
                                                        foreach ($locations as $location) {
                                                            $selected = '';
                                                            if ($row->location_id == $location->id)
                                                                $selected = 'selected';
                                                            printf("<option value='%s' %s>%s</option>", $location->id, $selected, $prefix . ' ' . $location->name);
                                                            $traverse($location->children, $prefix . '-');
                                                        }
                                                    };
                                                    $traverse($locations);
                                                    ?>
                                                </select>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">{{__("The geographic coordinate")}}</label>
                                        <div class="control-map-group">
                                            <div id="map_content"></div>
                                            <input type="text" placeholder="{{__("Search by name...")}}" class="bravo_searchbox form-control" autocomplete="off" onkeydown="return event.key !== 'Enter';">
                                            <div class="g-control">
                                                <div class="form-group">
                                                    <label>{{__("Map Latitude")}}:</label>
                                                    <input type="text" name="map_lat" class="form-control" value="{{$row->map_lat}}" onkeydown="return event.key !== 'Enter';">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__("Map Longitude")}}:</label>
                                                    <input type="text" name="map_lng" class="form-control" value="{{$row->map_lng}}" onkeydown="return event.key !== 'Enter';">
                                                </div>
                                                <div class="form-group">
                                                    <label>{{__("Map Zoom")}}:</label>
                                                    <input type="text" name="map_zoom" class="form-control" value="{{$row->map_zoom ?? "8"}}" onkeydown="return event.key !== 'Enter';">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endif
{{--                        @include('Core::admin/seo-meta/seo-meta')--}}

                        <div class="panel">
                            <div class="panel-title"><strong>{{ __('Education - Experience - Award')}}</strong></div>
                            <div class="panel-body">


                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="panel">
                            <div class="panel-body">
                                <h3 class="panel-body-title"> {{ __('Avatar')}}</h3>
                                <div class="form-group">
                                    {!! \Modules\Media\Helpers\FileHelper::fieldUpload('avatar_id',$row->avatar_id) !!}
                                </div>

                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('script.body')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        $(document).ready(function() {
            $('#cat_id').select2();
            $('#skills').select2();
        });
        jQuery(function ($) {
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat ?? "51.505"}}, {{$row->map_lng ?? "-0.09"}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    @if($row->map_lat && $row->map_lng)
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {}
                    });
                    @endif
                    engineMap.on('click', function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                    engineMap.on('zoom_changed', function (zoom) {
                        $("input[name=map_zoom]").attr("value", zoom);
                    });
                    engineMap.searchBox($('#customPlaceAddress'),function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                    engineMap.searchBox($('.bravo_searchbox'),function (dataLatLng) {
                        engineMap.clearMarkers();
                        engineMap.addMarker(dataLatLng, {
                            icon_options: {}
                        });
                        $("input[name=map_lat]").attr("value", dataLatLng[0]);
                        $("input[name=map_lng]").attr("value", dataLatLng[1]);
                    });
                }
            });

        })
    </script>
@endsection
