@extends('layouts.user')
@section('head')
    <link href="{{ asset('module/user/css/user.css') }}" rel="stylesheet">
@endsection
@section('content')
    <h3 class="title py-4">{{__("My Profile")}}</h3>
    @include('admin.message')
    <form action="{{ url('admin/module/user/store/'.($row->id ?? -1)) }}" method="post" class="default-form">
        @csrf
        <input type="hidden" name="status" value="{{ $row->status }}">
        <div class="row">
            <div class="col-lg-9">
                <div class="panel mb-4" style="height: auto;">
                    <div class="panel-title"><strong>{{ __("User Info") }}</strong></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>{{__("E-mail")}}</label>
                            <input type="text" name="email" value="{{old('email',$row->email)}}" placeholder="{{__("E-mail")}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("First name")}}</label>
                                        <input type="text" value="{{old('first_name',$row->first_name)}}" name="first_name" placeholder="{{__("First name")}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("Last name")}}</label>
                                        <input type="text" value="{{old('last_name',$row->last_name)}}" name="last_name" placeholder="{{__("Last name")}}" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>{{__("Phone Number")}}</label>
                            <input type="text" value="{{old('phone',$row->phone)}}" name="phone" placeholder="{{__("Phone Number")}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>{{__("Birthday")}}</label>
                            <input type="text" value="{{ old('birthday',$row->birthday? display_date($row->birthday) :'') }}" name="birthday" placeholder="{{__("Birthday")}}" class="form-control has-datepicker" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>{{__("Biographical")}}</label>
                            <textarea name="bio" rows="5" class="form-control">{{ strip_tags(old('bio',$row->bio)) }}</textarea>
                        </div>
                    </div>
                </div>
                @if($row->hasRole('candidate'))
                    <div class="panel mb-4 card-candidate">
                        <div class="panel-title"><strong>{{ __("Candidate Info") }}</strong></div>
                        <div class="panel-body">
                            @include('Candidate::admin.candidate.form')
                        </div>
                    </div>
                    <div class="panel mb-4 card-location">
                        <div class="panel-title"><strong>{{ __("Location Info") }}</strong></div>
                        <div class="panel-body">
                            @include('Candidate::admin.candidate.location')
                        </div>
                    </div>
                    <div class="panel mb-4 card-sub_information">
                        <div class="panel-title"><strong>{{ __("Location Info") }}</strong></div>
                        <div class="panel-body">
                            @include('Candidate::admin.candidate.sub_information')
                        </div>
                    </div>
                    <div class="card-seo-meta mb-4">
                        @include('Core::admin.seo-meta.seo-meta',['row' => ($row->candidate ?? $candidate)])
                    </div>
                @endif
                <div class="mb-4">
                    <button class="theme-btn btn-style-one" type="submit"><i class="fa fa-save" style="padding-right: 5px"></i> {{__('Save Changes')}}</button>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="panel">
                    <div class="panel-title"><strong>{{ __('Avatar')}}</strong></div>
                    <div class="panel-body">
                        <div class="form-group">
                            {!! \Modules\Media\Helpers\FileHelper::fieldUpload('avatar_id',old('avatar_id',$row->avatar_id)) !!}
                        </div>
                    </div>
                </div>
                @if($row->hasRole('candidate'))
                    <div class="panel">
                        <div class="panel-title"><strong>{{__('Categories')}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <select id="categories" class="form-control" name="categories[]" multiple="multiple">
                                    <option value="">{{__("-- Please Select --")}}</option>
                                    <?php
                                    foreach ($categories as $oneCategories) {
                                        $selected = '';
                                        if (!empty($row->candidate->categories)){

                                            foreach ($row->candidate->categories as $category){
                                                if($oneCategories->id == $category->id){
                                                    $selected = 'selected';
                                                }
                                            }
                                        }
                                        $trans = $oneCategories->translateOrOrigin(app()->getLocale());
                                        printf("<option value='%s' %s>%s</option>", $oneCategories->id, $selected, $oneCategories->name);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title"><strong>{{__("Skills")}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="">
                                    <select id="skills" name="skills[]" class="form-control" multiple="multiple">
                                        <option value="">{{__("-- Please Select --")}}</option>
                                        <?php
                                        foreach ($skills as $oneSkill) {
                                            $selected = '';
                                            if (!empty($row->candidate->skills)){
                                                foreach ($row->candidate->skills as $skill){
                                                    if($oneSkill->id == $skill->id){
                                                        $selected = 'selected';
                                                    }
                                                }
                                            }
                                            $trans = $oneSkill->translateOrOrigin(app()->getLocale());
                                            printf("<option value='%s' %s>%s</option>", $oneSkill->id, $selected, $trans->name);
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel card-social">
                        <div class="panel-title"><strong>{{ __('Social Media')}}</strong></div>
                        <div class="panel-body">
                            <?php $socialMediaData = !empty($row->candidate) ? $row->candidate->social_media : []; ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-skype"><i class="fab fa-skype"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[skype]" value="{{@$socialMediaData['skype']}}" placeholder="{{__('Skype')}}" aria-label="{{__('Skype')}}" aria-describedby="social-skype">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-facebook"><i class="fab fa-facebook"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[facebook]" value="{{@$socialMediaData['facebook']}}" placeholder="{{__('Facebook')}}" aria-label="{{__('Facebook')}}" aria-describedby="social-facebook">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-twitter"><i class="fab fa-twitter"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[twitter]" value="{{@$socialMediaData['twitter']}}" placeholder="{{__('Twitter')}}" aria-label="{{__('Twitter')}}" aria-describedby="social-twitter">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-instagram"><i class="fab fa-instagram"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[instagram]" value="{{@$socialMediaData['instagram']}}" placeholder="{{__('Instagram')}}" aria-label="{{__('Instagram')}}" aria-describedby="social-instagram">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-pinterest"><i class="fab fa-pinterest"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[pinterest]" value="{{@$socialMediaData['pinterest']}}" placeholder="{{__('Pinterest')}}" aria-label="{{__('Pinterest')}}" aria-describedby="social-pinterest">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-dribbble"><i class="fab fa-dribbble"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[dribbble]" value="{{@$socialMediaData['dribbble']}}" placeholder="{{__('Dribbble')}}" aria-label="{{__('Dribbble')}}" aria-describedby="social-dribbble">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-google"><i class="fab fa-google"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[google]" value="{{@$socialMediaData['google']}}" placeholder="{{__('Google')}}" aria-label="{{__('Google')}}" aria-describedby="social-google">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-google"><i class="fab fa-linkedin"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[linkedin]" value="{{@$socialMediaData['linkedin']}}" placeholder="{{__('Linkedin')}}" aria-label="{{__('Linkedin')}}" aria-describedby="social-linkedin">
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('CV Uploaded')}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group-item">
                                <div class="g-items-header">
                                    <div class="row">
                                        <div class="col-md-2">{{__("Default")}}</div>
                                        <div class="col-md-8">{{__("Name")}}</div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                                {!! \Modules\Media\Helpers\FileHelper::fieldFileUpload('cvs', @$cvs, 'cvs') !!}
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mb-4 text-right">
                    <button class="theme-btn btn-style-one" type="submit"><i class="fa fa-save" style="padding-right: 5px"></i> {{__('Save Changes')}}</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script type="text/javascript" src="{{ asset('libs/daterange/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/daterange/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}" ></script>
    <script>
        $('.has-datepicker').daterangepicker({
            singleDatePicker: true,
            showCalendar: false,
            autoUpdateInput: false,
            sameDate: true,
            autoApply: true,
            disabledPast: true,
            enableLoading: true,
            showEventTooltip: true,
            classNotAvailable: ['disabled', 'off'],
            disableHightLight: true,
            locale: {
                format: superio.date_format
            }
        }).on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format(superio.date_format));
        });
    </script>
    <script>
        @if($row->hasRole('candidate') || !empty($candidate_create))
        $(document).ready(function() {
            $('#categories').select2();
            $('#skills').select2();
        });

        let mapLat = {{ !empty($row->candidate) ? ($row->candidate->map_lat ?? "51.505") : "51.505" }};
        let mapLng = {{ !empty($row->candidate) ? ($row->candidate->map_lng ?? "-0.09") : "-0.09" }};
        let mapZoom = {{ !empty($row->candidate) ? ($row->candidate->map_zoom ?? "8") : "8" }};

        jQuery(function ($) {
            new BravoMapEngine('map_content', {
                disableScripts: true,
                fitBounds: true,
                center: [mapLat, mapLng],
                zoom: mapZoom,
                ready: function (engineMap) {
                    engineMap.addMarker([mapLat, mapLng], {
                        icon_options: {}
                    });
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
        @endif
    </script>
@endsection
