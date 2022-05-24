@extends('layouts.app')
@section('head')
    <link href="{{ asset('dist/frontend/module/location/css/location.css?_ver='.config('app.version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}"/>
@endsection
@section('content')
    <div class="bravo_detail_location">
        @include('Location::frontend.layouts.details.location-banner')
        <div class="bravo_content">
            <div class="border-bottom border-color-8">
                <div class="container space-bottom-1 space-top-lg-3">
                    <div class="w-md-80 w-lg-50 text-center mx-md-auto mb-4 mb-xl-7 pb-xl-1">
                        <h2 class="section-title text-black font-size-30 font-weight-bold mb-0">{{ __('Welcome to :name',['name' => $translation->name]) }}</h2>
                    </div>
                    <div class="w-lg-80 w-xl-60 mx-auto collapse_custom position-relative mb-4 pb-xl-1">
                        {!! clean($translation->content) !!}
                    </div>
                </div>
            </div>
            <div class="tabs-block tab-v1 g-location-module">
                <div class="container space-lg-1">
                    @php $types = get_bookable_services() @endphp
                    @if(!empty($types))
                        <div class="w-md-80 w-lg-50 text-center mx-md-auto my-3">
                            <h2 class="section-title text-black font-size-30 font-weight-bold mb-0">{{ __('Top Experiences in :name',['name' => $translation->name]) }}</h2>
                        </div>
                        <!-- Nav Classic -->
                        <ul class="nav tab-nav-pill flex-nowrap pb-4 pb-lg-5 tab-nav justify-content-lg-center" role="tablist">
                            @php $i = 0 ;$not_in =['flight']@endphp
                            @foreach($types as $type=>$moduleClass)
                                @php
                                    if(!$moduleClass::isEnable() or in_array($type,$not_in)==true) continue;
                                    $moduleInst = new $moduleClass();
                                    $data[$type] = $moduleInst->select($moduleInst::getTableName().'.*')
                                    ->join('bc_locations', function ($join) use ($row,$moduleInst) {
                                        $join->on('bc_locations.id', '=', $moduleInst::getTableName().'.location_id')
                                            ->where('bc_locations._lft', '>=', $row->_lft)
                                            ->where('bc_locations._rgt', '<=', $row->_rgt);
                                    })
                                    ->where($moduleInst::getTableName().'.status','publish')->with('location')->take(8)->get();
                                @endphp
                                @if($data[$type]->count()>0)
                                    <li class="nav-item">
                                        <a class="nav-link font-weight-medium {{$i==0?'active':""}}" id="#module-{{$type}}-tab" data-toggle="pill" href="#module-{{$type}}" role="tab" aria-controls="#module-{{$type}}" aria-selected="true">
                                            <div class="d-flex flex-column flex-md-row  position-relative text-dark align-items-center">
                                                <span class="tabtext font-weight-semi-bold">{{call_user_func([$moduleClass,'getModelName'])}}</span>
                                            </div>
                                        </a>
                                    </li>
                                    @php $i++ @endphp
                                @endif
                            @endforeach
                        </ul>
                        <!-- End Nav Classic -->
                        <div class="tab-content">
                            @php $i=0 @endphp
                            @foreach($types as $type=>$moduleClass)
                                @php  if(!$moduleClass::isEnable() or in_array($type,$not_in)==true) continue;@endphp
                                @php $view = ucfirst($type).'::frontend.blocks.list-'.$type.'.style_1' @endphp
                                @if(view()->exists($view))
                                    @if($data[$type]->count()>0)
                                        <div class="tab-pane fade {{$i==0?'active show':""}}" id="module-{{$type}}" role="tabpanel" aria-labelledby="module-{{$type}}-tab">
                                            @include($view,['title'=>"",'style_list'=>'normal','desc'=>'','rows'=> $data[$type]])
                                        </div>
                                        @php $i++ @endphp
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            @include('Location::frontend.layouts.details.location-map')
        </div>
        @if(!empty($articles))
            <div class="recent-articles border-bottom border-color-8">
            <div class="container space-lg-1">
                <!-- Title -->
                <div class="w-md-80 w-lg-50 text-center mx-md-auto mt-3 mb-5 mb-lg-8 pb-lg-2">
                    <h2 class="section-title text-black font-size-30 font-weight-bold">{{ __('Recent articles') }}</h2>
                </div>
                <!-- End Title -->
                <div class="mb-4 mb-lg-6">
                    <div class="row">
                        @if(!empty($articles))
                            @foreach($articles as $article)
                                <div class="col-md-12 col-lg-6 d-md-flex pb-4 pb-lg-6">
                                    <div class="item-thumb col-xl-4dot1">
                                        <a class="d-block" href="{{ $article->getDetailUrl() }}">
                                            {!! get_image_tag($article->image_id,'thumb') !!}
                                        </a>
                                    </div>
                                    <div class="col-xl-7dot9">
                                        <div class="item-content ml-3 pl-1">
                                            <h4 class="font-size-21 font-weight-semi-bold text-gray-6">
                                                <a href="{{ $article->getDetailUrl() }}">{!! clean($article->title) !!}</a>
                                            </h4>
                                            <p class="text-gray-1 text-lh-lg">{!! clean(get_exceprt($article->content,'100','...')) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="text-center">
                        <a class="text-center btn btn-md-wide border-width-2 btn-outline-navy font-weight-semi-bold px-5 transition-3d-hover" href="{{ url('/news')  }}">{{ __('Read More Articles') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        jQuery(function ($) {
            "use strict"
            @if($row->map_lat && $row->map_lng)
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [{{$row->map_lat}}, {{$row->map_lng}}],
                zoom:{{$row->map_zoom ?? "8"}},
                ready: function (engineMap) {
                    engineMap.addMarker([{{$row->map_lat}}, {{$row->map_lng}}], {
                        icon_options: {}
                    });
                }
            });
            @endif
        })
    </script>

    <script type="text/javascript" src="{{ asset("libs/ion_rangeslider/js/ion.rangeSlider.min.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/fotorama/fotorama.js") }}"></script>
    <script type="text/javascript" src="{{ asset("libs/sticky/jquery.sticky.js") }}"></script>
@endsection
