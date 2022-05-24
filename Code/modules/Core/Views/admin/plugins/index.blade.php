@extends('admin.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{__("All Plugins")}}</h1>
        </div>
        @include('admin.message')
        <div class="filter-div d-flex justify-content-between ">
            <div class="col-left">
                @if(!empty($rows))
                    <form method="post" action="{{route('core.admin.plugins.bulkEdit')}}" class="filter-form filter-form-left d-flex justify-content-start">
                        {{csrf_field()}}
                        <select name="action" class="form-control">
                            <option value="">{{__(" Bulk Actions ")}}</option>
                        </select>
                        <button class="btn-info btn btn-icon dungdt-apply-form-btn" type="button">{{__('Apply')}}</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <form action="" class="bravo-form-item">
                    <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th width="60px"><input type="checkbox" class="check-all"></th>
                            <th width="200px"> {{ __('Plugin name')}}</th>
                            <th > {{ __('Description')}}</th>
                            <th width="130px"> {{ __('Author')}}</th>
                            <th width="100px"> {{ __('Version')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($rows))
                            @foreach($rows as $key=>$row)
                                <tr class="{{$row['module_name']}}">
                                    <td><input type="checkbox" name="ids[]" class="check-item" value="{{$row['module_name']}}">
                                    </td>
                                    <td class="title">
                                        <a href="#">{{$row['title']}}</a>
                                    </td>
                                    <td>
                                        {{$row['desc']}}
                                    </td>
                                    <td>
                                        {{$row['author']}}
                                    </td>
                                    <td>
                                        {{$row['version']}}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7">{{__("No Plugin found")}}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
