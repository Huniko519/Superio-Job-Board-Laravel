@extends('admin.layouts.app')
@section('title','My Contact')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb-4">
            <h1 class="title-bar">{{__("My Contact")}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">

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
                                        <th> {{ __('Name')}}</th>
                                        <th> {{ __('Email')}}</th>
                                        <th>{{  __('Message')}}</th>
                                        <th>{{  __('Job')}}</th>
                                        <th>{{  __('Time Sent')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($rows->total() > 0)
                                        @foreach($rows as $row)
                                            <tr>
                                                <td> {{ $row->name }}</td>
                                                <td> {{ $row->email }}</td>
                                                <td> {{ $row->message }}</td>
                                                <td>
                                                    @if($row->job)
                                                        <a href="{{ $row->job->getDetailUrl() }}" target="_blank">{{ $row->job->title }}</a>
                                                    @endif
                                                </td>
                                                <td> {{ display_date($row->created_at) }}</td>
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
