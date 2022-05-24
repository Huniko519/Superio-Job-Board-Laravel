@extends('admin.layouts.app')

@section('content')
    <form action="{{url('admin/module/user/store/'.($row->id ?? -1))}}" method="post" class="needs-validation" novalidate>
        @csrf
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? 'Edit: '.$row->getDisplayName() : 'Add new user'}}</h1>
                    @if(!empty($row->candidate))
                        <p class="item-url-demo">{{__("Permalink")}}: {{ url(config('candidate.candidate_route_prefix') ) }}/<a href="#" class="open-edit-input" data-name="slug">{{$row->candidate->slug}}</a>
                        </p>
                    @endif
                </div>
                @if(is_admin() && !empty($row->candidate) && !empty($row->candidate->slug) && old('role_id',$row->role_id) == 3)
                    <div class="flex">
                        <a class="btn btn-default btn-sm" href="{{ route('candidate.detail', ['slug' => $row->candidate->slug]) }}" target="_blank"><i class="fa fa-eye"></i> {{ __("View Candidate") }}</a>
                    </div>
                @endif
            </div>
            @include('admin.message')
            <div class="row">
                <div class="col-md-9">
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('User Info')}}</strong></div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('E-mail')}}</label>
                                        <input type="email" required value="{{old('email',$row->email)}}" placeholder="{{ __('Email')}}" name="email" class="form-control"  >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("First name")}}</label>
                                        <input type="text" required value="{{old('first_name',$row->first_name)}}" name="first_name" placeholder="{{__("First name")}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{__("Last name")}}</label>
                                        <input type="text" required value="{{old('last_name',$row->last_name)}}" name="last_name" placeholder="{{__("Last name")}}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Phone Number')}}</label>
                                        <input type="text" value="{{old('phone',$row->phone)}}" placeholder="{{ __('Phone')}}" name="phone" class="form-control" required   >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ __('Birthday')}}</label>
                                        <input type="text" readonly style="background: white" value="{{ old('birthday',$row->birthday ? date("Y/m/d",strtotime($row->birthday)) :'') }}" placeholder="{{ __('Birthday')}}" name="birthday" class="form-control has-datepicker input-group date">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">{{ __('Biographical')}}</label>
                                <div class="">
                                    <textarea name="bio" class="d-none has-ckeditor" cols="30" rows="10">{{old('bio',$row->bio)}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($row->hasRole('candidate') || !empty($candidate_create))
                        <div class="panel">
                            <div class="panel-title"><strong>{{ __('Candidate Info')}}</strong></div>
                            <div class="panel-body">
                                @include('Candidate::admin/candidate/form',['row'=> $row])
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-title"><strong>{{ __('Location Info')}}</strong></div>
                            <div class="panel-body">
                                @include('Candidate::admin/candidate/location',['row'=> $row, 'locations' => $locations])
                            </div>
                        </div>

                        <div class="panel">
                            <div class="panel-title"><strong>{{ __('Education - Experience - Award')}}</strong></div>
                            <div class="panel-body">
                                @include('Candidate::admin/candidate/sub_information',['row'=> $row])
                            </div>
                        </div>

                        @include('Core::admin/seo-meta/seo-meta', ['row' => ($row->candidate ?? $candidate)])
                    @endif
                </div>

                <div class="col-md-3">
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Publish')}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>{{__('Status')}}</label>
                                <select required class="custom-select" name="status">
                                    <option value="">{{ __('-- Select --')}}</option>
                                    <option @if(old('status',$row->status) =='publish') selected @endif value="publish">{{ __('Publish')}}</option>
                                    <option @if(old('status',$row->status) =='blocked') selected @endif value="blocked">{{ __('Blocked')}}</option>
                                </select>
                            </div>
                            @if(is_admin())
                            <div class="form-group">
                                <label>{{__('Role')}}</label>
                                <select required class="form-control" name="role_id">
                                    <option value="">{{ __('-- Select --')}}</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if(old('role_id',$row->role_id) == $role->id) selected @elseif(old('role_id')  == $role->id ) selected @endif >{{ucfirst($role->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            @if($row->hasRole('candidate') || !empty($candidate_create))
                                <div class="form-group">
                                    <label>{{__('Allow Search')}}</label>
                                    <select required class="custom-select" name="allow_search">
                                        <option value="">{{ __('-- Select --')}}</option>
                                        <option @if(old('allow_search',@$row->candidate->allow_search) =='publish') selected @endif value="publish">{{ __('Publish')}}</option>
                                        <option @if(old('allow_search',@$row->candidate->allow_search) =='hide') selected @endif value="hide">{{ __('Hide')}}</option>
                                    </select>
                                </div>
                            @endif

                            <hr>
                            <div class="d-flex justify-content-between">
                                <span></span>
                                <button class="btn btn-primary" type="submit">{{ __('Save Change')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Avatar')}}</strong></div>
                        <div class="panel-body">
                            <div class="form-group">
                                {!! \Modules\Media\Helpers\FileHelper::fieldUpload('avatar_id',old('avatar_id',$row->avatar_id)) !!}
                            </div>
                        </div>
                    </div>
                    @if($row->hasRole('candidate') || !empty($candidate_create))
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

                    <div class="panel">
                        <div class="panel-title"><strong>{{ __('Social Media')}}</strong></div>
                        <div class="panel-body">
                            <?php $socialMediaData = !empty($row->candidate) ? $row->candidate->social_media : []; ?>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-skype"><i class="fa fa-skype"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[skype]" value="{{@$socialMediaData['skype']}}" placeholder="{{__('Skype')}}" aria-label="{{__('Skype')}}" aria-describedby="social-skype">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-facebook"><i class="fa fa-facebook"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[facebook]" value="{{@$socialMediaData['facebook']}}" placeholder="{{__('Facebook')}}" aria-label="{{__('Facebook')}}" aria-describedby="social-facebook">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-twitter"><i class="fa fa-twitter"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[twitter]" value="{{@$socialMediaData['twitter']}}" placeholder="{{__('Twitter')}}" aria-label="{{__('Twitter')}}" aria-describedby="social-twitter">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-instagram"><i class="fa fa-instagram"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[instagram]" value="{{@$socialMediaData['instagram']}}" placeholder="{{__('Instagram')}}" aria-label="{{__('Instagram')}}" aria-describedby="social-instagram">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-pinterest"><i class="fa fa-pinterest"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[pinterest]" value="{{@$socialMediaData['pinterest']}}" placeholder="{{__('Pinterest')}}" aria-label="{{__('Pinterest')}}" aria-describedby="social-pinterest">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-dribbble"><i class="fa fa-dribbble"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[dribbble]" value="{{@$socialMediaData['dribbble']}}" placeholder="{{__('Dribbble')}}" aria-label="{{__('Dribbble')}}" aria-describedby="social-dribbble">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-google"><i class="fa fa-google"></i></span>
                                </div>
                                <input type="text" class="form-control" name="social_media[google]" value="{{@$socialMediaData['google']}}" placeholder="{{__('Google')}}" aria-label="{{__('Google')}}" aria-describedby="social-google">
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="social-google"><i class="fa fa-linkedin"></i></span>
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
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between">
                <span></span>
                <button class="btn btn-primary" type="submit">{{ __('Save Change')}}</button>
            </div>
        </div>
    </form>

@endsection
@section ('script.body')
    {!! App\Helpers\MapEngine::scripts() !!}
    <script>
        @if($row->hasRole('candidate') || !empty($candidate_create))
        $(document).ready(function() {
            $('#categories').select2();
            $('#skills').select2();
        });

        let mapLat = {{ !empty($row->candidate) ? ($row->candidate->map_lat ?? "51.505") : "51.505" }};
        let mapLng = {{ !empty($row->candidate) ? ($row->candidate->map_lng ?? "-0.09") : "-0.09" }};
        let mapZoom = {{ !empty($row->candidate) ? ($row->candidate->map_zoom ?? '8') : "8" }};

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
