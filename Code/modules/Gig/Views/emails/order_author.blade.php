@extends('Email::layout')
@section('content')
    <div class="b-container">
        <div class="b-panel">
            <h1>{{__("Hello")}} {{$author->display_name}}
            </h1>

            <p>{{__('Here is the order information: ')}}</p>
            <p><strong>{{__("Order ID:")}}</strong> #{{$order->id}}</p>
            <p><strong>{{__("Order Date:")}}</strong> {{display_datetime($gig_order->created_at)}}</p>
            <br>
            <br>
            <table class="b-table" border="1px" cellpadding="0" cellspacing="0">
                <thead>
                <tr style="border-bottom: 1px solid #EAEEF3" class="carttable_row">
                    <th style="padding: 10px" class="cartm_title">{{__('Product')}}</th>
                    <th style="padding: 10px" class="cartm_title">{{__('Price')}}</th>
                    <th style="padding: 10px" class="cartm_title">{{__('Actions')}}</th>
                </tr>
                </thead>
                <tbody class="table_body">
                    <tr style="border-bottom: 1px solid #EAEEF3">
                        <td style="border-bottom: 1px solid #EAEEF3;padding: 10px" scope="row">
                            <a href="{{$gig->getDetailUrl()}}">{{$gig->title}}</a>
                            @if(!empty($gig_order->package))
                                <div>{{__("Package: ")}} {{package_key_to_name($gig_order->package)}}</div>
                            @endif
                        </td>
                        <td style="border-bottom: 1px solid #EAEEF3;padding: 10px">{{format_money($gig_order->total)}}</td>
                        <td style="border-bottom: 1px solid #EAEEF3;padding: 10px">
                            <a href="{{route('seller.order',['id'=>$gig_order->id])}}">{{__("View Order")}}</a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <br>
            <h4>{{__("Customer Details")}}</h4>
            <?php $customer = $order->customer;?>
            @if($customer)
            <ul>
                <li><strong>{{__("First name:")}}</strong> {{$customer->billing_first_name}}</li>
                <li><strong>{{__("Last name:")}}</strong> {{$customer->billing_last_name}}</li>
                <li><strong>{{__("Email:")}}</strong> {{$customer->email}}</li>
                <li><strong>{{__("Phone:")}}</strong> {{$customer->phone}}</li>
                <li><strong>{{__("Country:")}}</strong> {{get_country_name($customer->country)}}</li>
                <li><strong>{{__("State:")}}</strong> {{$customer->state}}</li>
                <li><strong>{{__("City:")}}</strong> {{$customer->city}}</li>
                <li><strong>{{__("Zip Code:")}}</strong> {{$customer->zip_code}}</li>
                <li><strong>{{__("Address:")}}</strong> {{$customer->address}}</li>
                <li><strong>{{__("Address 2:")}}</strong> {{$customer->address2}}</li>
            </ul>
            @endif
            <br>
            <p>{{__('Regards')}},<br>{{setting_item('site_title')}}</p>
        </div>
    </div>
@endsection
