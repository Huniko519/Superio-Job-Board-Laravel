@extends('admin.layouts.app')

@section('content')
    <form action="{{route('gig.admin.store',['id'=>($row->id) ? $row->id : '-1','lang'=>request()->query('lang')])}}" method="post">
        @csrf
        <div class="container-fluid">
            <div class="d-flex justify-content-between mb20">
                <div class="">
                    <h1 class="title-bar">{{$row->id ? __('Edit: ').$row->title : __('Add new gig')}}</h1>
                    @if($row->slug)
                        <p class="item-url-demo">{{__("Permalink")}}: {{ url('gig' ) }}/<a href="#" class="open-edit-input" data-name="slug">{{$row->slug}}</a>
                        </p>
                    @endif
                </div>
                <div class="">
                    @if($row->slug)
                        <a class="btn btn-primary btn-sm" href="{{$row->getDetailUrl(request()->query('lang'))}}" target="_blank">{{__("View Gig")}}</a>
                    @endif
                </div>
            </div>
            @include('admin.message')
            @if($row->id)
                @include('Language::admin.navigation')
            @endif
            <div class="lang-content-box">
                <div class="row">
                    <div class="col-md-9">
                        <div class="panel">
                            <div class="panel-title"><strong>{{__("Overview")}}</strong></div>
                            <div class="panel-body">
                                @include('Gig::admin.gig.overview')
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-title"><strong>{{__("Scope & Pricing")}}</strong></div>
                            <div class="panel-body">
                                @include('Gig::admin.gig.pricing')
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-title"><strong>{{__("Description")}}</strong></div>
                            <div class="panel-body">
                                @include('Gig::admin.gig.description')
                            </div>
                        </div>
                        <div class="panel">
                            <div class="panel-title"><strong>{{__("Requirements")}}</strong></div>
                            <div class="panel-body">
                                <p>{{__('Add questions to help buyers provide you with exactly what you need to start working on their order.')}}</p>
                                @include('Gig::admin.gig.requirements')
                            </div>
                        </div>
                        @if(is_default_lang())
                        <div class="panel">
                            <div class="panel-title"><strong>{{__("Gallery")}}</strong></div>
                            <div class="panel-body">
                                <p>{{__('Showcase Your Services In A Gig Gallery')}}</p>
                                @include('Gig::admin.gig.gallery')
                            </div>
                        </div>
                        @endif

                        @include('Core::admin/seo-meta/seo-meta')
                    </div>
                    <div class="col-md-3">
                        <div class="panel">
                            <div class="panel-title"><strong>{{__('Publish')}}</strong></div>
                            <div class="panel-body">
                                @if(is_default_lang())
                                    <div>
                                        <label><input @if($row->status=='publish') checked @endif type="radio" name="status" value="publish"> {{__("Publish")}}
                                        </label></div>
                                    <div>
                                        <label><input @if($row->status=='draft') checked @endif type="radio" name="status" value="draft"> {{__("Draft")}}
                                        </label></div>

                                    @if(!empty($gig_manage_others))
                                            <hr>
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="is_featured" @if($row->is_featured) checked @endif value="1"> {{__("Enable featured")}}
                                            </label>
                                        </div>
                                    @endif
                                @endif
                                <div class="text-right">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> {{__('Save Changes')}}</button>
                                </div>
                            </div>
                        </div>


                        @if(is_default_lang() and !empty($gig_manage_others))
                            <div class="panel">
                                <div class="panel-title"><strong>{{__("Author Setting")}}</strong></div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <?php
                                        $user_id = old('author_id',$row->author_id);
                                        $user = $user_id ? App\User::find($user_id) : false;
                                        \App\Helpers\AdminForm::select2('author_id', [
                                            'configs' => [
                                                'ajax'        => [
                                                    'url' => url('/admin/module/user/getForSelect2'),
                                                    'dataType' => 'json'
                                                ],
                                                'allowClear'  => true,
                                                'placeholder' => __('-- Select User --')
                                            ]
                                        ], !empty($user->id) ? [
                                            $user->id,
                                            $user->getDisplayName() . ' (#' . $user->id . ')'
                                        ] : false)
                                        ?>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @include('Gig::admin.gig.attributes')
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section ('script.body')
    <script>
        jQuery(function ($) {
            "use strict"
            var on_load = true;
            $('[name=cat_id]').on('change',function (){
                $('[name="cat2_id"] option').show().hide();
                $('[name="cat2_id"] [data-parent="'+$(this).val()+'"]').show();
                if(!on_load){
                    $('[name="cat2_id"] option:eq(0)').prop('selected', true);
                    $('[name="cat3_id"] option:eq(0)').prop('selected', true);
                }
                $('[name="cat2_id"]').trigger("change");
                on_load = false;
            }).trigger('change')
            $('[name=cat2_id]').on('change',function (){
                $('[name="cat3_id"] option').show().hide();
                $('[name="cat3_id"] [data-parent="'+$(this).val()+'"]').show();
            }).trigger('change')
        })
    </script>
@endsection
