@extends('admin.layouts.app')
@section('title','Candidate')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("All candidate")}}</h1>
            <div class="title-actions">
                <a href="{{route('user.admin.create', ['candidate_create' => 1])}}" class="btn btn-primary">{{__("Add new Candidate")}}</a>
            </div>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{url('admin/module/candidate/bulkEdit')}}"
                          class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                            <option value="delete">{{__(" Delete ")}}</option>
                        </select>
                        <button data-confirm="{{__("Do you want to delete?")}}" class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
            <div class="col-left">
                <form method="get" action="{{url('/admin/module/candidate/')}} " class="filter-form filter-form-right d-flex justify-content-end flex-column flex-sm-row" role="search">
                    <input type="text" name="s" value="{{ Request()->s }}" placeholder="{{__('Search by name')}}"
                           class="form-control">
                    <select name="cate_id" class="form-control">
                        <option value="">{{ __('--All Category --')}} </option>
                        <?php
                        if (!empty($categories)) {
                            foreach ($categories as $category) {
                                printf("<option ".(Request()->cate_id == $category->id ? 'selected' : '')." value='%s' >%s</option>", $category->id, $category->name);
                            }
                        }
                        ?>
                    </select>
                    <select name="status" class="form-control">
                        <option value="">{{ __('-- Status --')}} </option>
                        <option @if((Request()->status == 'publish')) selected @endif value="publish"> {{__('Publish')}} </option>
                        <option @if((Request()->status == 'blocked')) selected @endif value="blocked"> {{__('Blocked')}} </option>
                    </select>
                    <select name="allow_search" class="form-control">
                        <option value="">{{ __('-- Allow Search --')}} </option>
                        <option @if((Request()->allow_search == 'publish')) selected @endif value="publish"> {{__('Publish')}} </option>
                        <option @if((Request()->allow_search == 'hide')) selected @endif value="hide"> {{__('Hide')}} </option>
                    </select>
                    <button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search Candidate')}}</button>
                </form>
            </div>
        </div>
        <div class="text-right">
            <p><i>{{__('Found :total items',['total'=>$rows->total()])}}</i></p>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <form action="" class="bravo-form-item">
                            <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="60px"><input type="checkbox" class="check-all"></th>
                                    <th class="title"> {{ __('Name')}}</th>
                                    <th class="title"> {{ __('Title')}}</th>
                                    <th class="title"> {{ __('Email')}}</th>
                                    <th class="title"> {{ __('Phone')}}</th>
                                    <th width="100px"> {{ __('Date')}}</th>
                                    <th width="100px">{{  __('Status')}}</th>
                                    <th width="100px">{{  __('Allow Search')}}</th>
                                    <th width="100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($rows->total() > 0)
                                    @foreach($rows as $row)
                                        <tr>
                                            <td>
                                                <input type="checkbox" class="check-item" name="ids[]" value="{{$row->id}}">
                                            </td>
                                            <td class="title">
                                                <a href="{{route('user.admin.detail',['id'=>$row->id])}}">{{$row->getDisplayName()}}</a>
                                            </td>
                                            <td> {{ $row->candidate->title ?? '' }}</td>
                                            <td> {{ $row->email}}</td>
                                            <td> {{ $row->phone}}</td>
                                            <td> {{ display_date($row->updated_at)}}</td>
                                            <td><span class="badge badge-{{ $row->status }}">{{ $row->status }}</span></td>
                                            <td><span class="badge badge-{{ $row->candidate->allow_search == 'publish' ? 'active' : 'warning' }}">{{ $row->candidate->allow_search == 'publish' ? __('Publish') : __('Hide') }}</span></td>
                                            <td>
                                                <a href="{{route('user.admin.detail',['id'=>$row->id])}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('Edit')}}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">{{__("No data")}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            </div>
                        </form>
                        {{$rows->appends(request()->query())->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
