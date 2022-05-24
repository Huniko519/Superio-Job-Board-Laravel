@extends('layouts.app')
@section('head')

@endsection
@section('content')
    <section class="pricing-section">
        <div class="auto-container">
            @include('admin.message')
            <?php
            if(!$user or !$user_plan = $user->user_plan)
                return;
            ?>
            <div class="sec-title text-center">
                <h2>{{__("My Current Plan")}}</h2>
            </div>
            <table class="default-table manage-job-table mb-5">
                <thead>
                <tr>
                    <th>{{__("Plan ID")}}</th>
                    <th>{{__("Plan Name")}}</th>
                    <th>{{__("Expiry")}}</th>
                    <th>{{__("Used/Total")}}</th>
                    <th>{{__("Price")}}</th>
                    <th>{{__("Status")}}</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <td>#{{$user_plan->plan_id}}</td>
                    <td class="trans-id">{{$user_plan->plan->title ?? ''}}</td>
                    <td class="total-jobs">{{display_datetime($user_plan->end_date)}}</td>
                    <td class="used">@if(!$user_plan->max_service) {{__("Unlimited")}} @else {{$user_plan->used}}/{{$user_plan->max_service}} @endif</td>
                    <td class="remaining">{{format_money($user_plan->price)}}</td>
                    <td >
                        @if($user_plan->is_valid)
                            <span class="text-success">{{__('Active')}}</span>
                        @else
                            <div class="text-danger mb-3">{{__('Expired')}}</div>
                            <div>
                                <a href="{{route('plan')}}" class="btn btn-warning">{{__('Renew')}}</a>
                            </div>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
        </div>
    </section>
@endsection
@section('footer')
@endsection
