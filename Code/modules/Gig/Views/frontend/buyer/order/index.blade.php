@extends('layouts.app')
@section('head')
@endsection
@section('content')
    @include('Gig::frontend.buyer.head')
    <div class="auto-container pb-5 buyer-order">
{{--        <h4 class="mb-3">{{__('Manage Orders')}}</h4>--}}
        <div class="table-outer">
            <table class="default-table manage-job-table">
                <thead>
                <tr>
                    <th>{{__('Title')}}</th>
                    <th>{{__('Created')}}</th>
                    <th>{{__("Price")}}</th>
                    <th>{{__("Status")}}</th>
                    <th>{{__('Action')}}</th>
                </tr>
                </thead>

                <tbody>
                @foreach($rows as $row)
                    <tr>
                        <td class="gig-name">
                            @if(!empty($row->gig->image_id))
                                {!! get_image_tag($row->gig->image_id,'full',['alt'=>$row->gig->title,'class'=>'gig-img img-fluid lazy loaded']) !!}
                            @endif
                            <a href="{{$row->gig ? $row->gig->getDetailUrl() : '#'}}">{{$row->gig->title ?? ''}}</a>
                        </td>
                        <td>{{display_date($row->created_at)}}</td>
                        <td>{{format_money($row->price)}}</td>
                        <td>
                           <span class="">{{$row->status_text}}</span>
                        </td>
                        <td class="order-detail"><a href="{{route('buyer.order',['id'=>$row->id])}}" class="btn btn-success">{{__("View")}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$rows->appends(request()->query())->links()}}
        </div>
    </div>
@endsection
