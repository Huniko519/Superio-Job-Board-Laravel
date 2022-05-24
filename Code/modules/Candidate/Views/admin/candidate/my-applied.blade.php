@extends('admin.layouts.app')
@section('title','My Applied')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="title-bar">{{__("Applied Jobs")}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                <form method="get" action="{{ route('candidate.admin.myApplied') }} " class="filter-form filter-form-right d-flex flex-column flex-sm-row" role="search">
                    <select class="form-control w-auto" name="status">
                        <option value="">{{ __("All") }}</option>
                        <option value="pending" @if(request()->get('status') == 'pending') selected @endif>{{ __("Pending") }}</option>
                        <option value="approved" @if(request()->get('status') == 'approved') selected @endif>{{ __("Approved") }}</option>
                        <option value="rejected" @if(request()->get('status') == 'rejected') selected @endif>{{ __("Rejected") }}</option>
                    </select>
                    <input type="text" name="s" value="{{ request()->get('s') }}" placeholder="{{__('Search by job name')}}" class="form-control">
                    <button class="btn-info btn btn-icon btn_search" type="submit">{{__('Search')}}</button>
                </form>
            </div>
            <div class="col-left">
                <form method="get" action="{{ request()->fullUrl() }} ">
                    <div class="form-group form-inline">
                        <label class="mr-2">{{ __("Order By") }}</label>
                        <select class="form-control" name="orderby" onchange="this.form.submit()">
                            <option value="">{{ __("Default") }}</option>
                            <option value="newest" @if(request()->get('orderby') == 'newest') selected @endif>{{ __("Newest") }}</option>
                            <option value="oldest" @if(request()->get('orderby') == 'oldest') selected @endif>{{ __("Oldest") }}</option>
                        </select>
                    </div>
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
                                <table class="table table-hover table-vertical-middle">
                                    <thead>
                                    <tr>
                                        <th class="title" style="min-width: 200px"> {{ __('Job Title')}}</th>
                                        <th class="title" style="min-width: 100px"> {{ __('Date Applied')}}</th>
                                        <th width="100px">{{  __('Status')}}</th>
                                        <th width="100px" style="min-width: 100px">{{ __("Actions") }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($rows->total() > 0)
                                        @foreach($rows as $row)
                                            <tr>
                                                <td class="vertical">
                                                    @if($row->jobInfo)
                                                        <a href="{{ $row->jobInfo->getDetailUrl() }}" target="_blank">
                                                            <img src="{{ $row->jobInfo->getThumbnailUrl() }}" class="company-logo" />
                                                            {{ $row->jobInfo->title}}
                                                        </a>
                                                    @else
                                                        {{__('[Deleted]')}}
                                                    @endif
                                                </td>
                                                <td> {{ display_date($row->created_at) }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $row->status }}">{{ $row->status }}</span>
                                                </td>
                                                <td>
                                                    @if($row->status == 'pending')
                                                        <a href="{{ route('candidate.admin.myApplied.delete', ['id' => $row->id]) }}" data-confirm="{{__("Do you want to delete?")}}" title="{{ __("Delete") }}" class="btn btn-danger btn-square-sm mr-1 bc-delete-item"><i class="ion-md-close"></i></a>
                                                    @endif
                                                    @if($row->jobInfo)
                                                        <a href="{{ $row->jobInfo->getDetailUrl() ?? '' }}" title="{{ __("View") }}" target="_blank" class="btn btn-primary btn-square-sm"><i class="ion-md-eye"></i></a>
                                                    @else
                                                        {{__('[Deleted]')}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">{{__("No data")}}</td>
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
