@extends('layouts.app')
@section('head')
@endsection
@section('content')
    <section class="page-title">
        <div class="auto-container">
            <div class="title-outer">
                <h1>{{__("Manage Orders")}}</h1>
            </div>
        </div>
    </section>
    <div class="auto-container">
        <div class="mt-3 mb-5">
            <div class="default-tabs style-two tabs-box">
                <ul class="tab-buttons clearfix">
                    <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::INCOMPLETE) active-btn @endif"><a href="{{ route('seller.orders',['status'=>\Modules\Gig\Models\GigOrder::INCOMPLETE]) }}">{{__("Incomplete")}}</a></li>
                    <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::IN_PROGRESS) active-btn @endif"><a href="{{ route('seller.orders',['status'=>\Modules\Gig\Models\GigOrder::IN_PROGRESS]) }}">{{__("In Progress")}}</a></li>
                    <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::DELIVERED) active-btn @endif"><a href="{{ route('seller.orders',['status'=>\Modules\Gig\Models\GigOrder::DELIVERED]) }}">{{__("Delivered")}}</a></li>
                    <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::IN_REVISION) active-btn @endif"><a href="{{ route('seller.orders',['status'=>\Modules\Gig\Models\GigOrder::IN_REVISION]) }}">{{__("In Revision")}}</a></li>
                    <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::COMPLETED) active-btn @endif"><a href="{{ route('seller.orders',['status'=>\Modules\Gig\Models\GigOrder::COMPLETED]) }}">{{__("Completed")}}</a></li>
                    <li class="@if(request()->get('status') == \Modules\Gig\Models\GigOrder::CANCELLED) active-btn @endif"><a href="{{ route('seller.orders',['status'=>\Modules\Gig\Models\GigOrder::CANCELLED]) }}">{{__("Cancelled")}}</a></li>
                    <li class="@if(request()->get('status') == '') active-btn @endif"><a href="{{route('seller.orders')}}">{{__("All")}}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="auto-container pb-5 buyer-order">
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
                        <td class="order-detail"><a href="{{route('seller.order',['id'=>$row->id])}}" class="btn btn-success">{{__("View")}}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$rows->appends(request()->query())->links()}}
        </div>
    </div>
@endsection
