@extends('Email::layout')
@section('content')
    <div class="b-container">
        <div class="b-panel">
            <h1>{{__("Hello")}}
                @if($email_to == 'customer')
                    {{$row->customer->display_name ?? ''}}
                @else
                    {{__("Administrator")}}
                @endif
            </h1>

            <p>{{__('Here is the order information: ')}}</p>
            <p><strong>{{__("Order ID:")}}</strong> #{{$row->id}}</p>
            <p><strong>{{__("Order Date:")}}</strong> {{display_datetime($row->created_at)}}</p>
            <p><strong>{{__("Gateway:")}}</strong> {{$row->gateway_obj->getDisplayName()}}</p>
            <p><strong>{{__("Status:")}}</strong> {{$row->status_name}}</p>
            <br>
            <br>
            <table class="b-table" border="1px" cellpadding="0" cellspacing="0">
                <thead>
                <tr style="border-bottom: 1px solid #EAEEF3" class="carttable_row">
                    <th style="padding: 10px" class="cartm_title">{{__('Product')}}</th>
                    <th style="padding: 10px" class="cartm_title">{{__('Quantity')}}</th>
                    <th style="padding: 10px" class="cartm_title">{{__('Price')}}</th>
                </tr>
                </thead>
                <tbody class="table_body">

                @foreach($row->items as $orderItem)
                    <?php $model = $orderItem->model(); ?>
                    <tr style="border-bottom: 1px solid #EAEEF3">
                        <td style="border-bottom: 1px solid #EAEEF3;padding: 10px" scope="row">
                            @if($model)
                                {{$model->title}}
                            @else
                                {{$orderItem->name}}
                            @endif

                            @if(!empty($orderItem->meta['package']))
                                <div class="mt-3">{{__('Package: ')}} {{package_key_to_name($orderItem->meta['package'])}} ({{format_money($orderItem->price)}})</div>
                            @endif
                            @if(!empty($orderItem->meta['extra_prices']))
                                <div><strong>{{__("Extra Prices:")}}</strong></div>
                                <ul class="list-unstyled">
                                    @foreach($orderItem->meta['extra_prices'] as $extra_price)
                                        <li>{{$extra_price['name'] ?? ''}} : {{format_money($extra_price['price'] ?? 0)}}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                        <td style="border-bottom: 1px solid #EAEEF3;padding: 10px">{{$orderItem->qty}}</td>
                        <td style="border-bottom: 1px solid #EAEEF3;padding: 10px">{{format_money($orderItem->subtotal)}}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="2"><strong>{{__('Total')}}</strong></td>
                        <td>{{format_money($row->total)}}</td>
                    </tr>
                </tbody>
            </table>
            <br>
            <br>
            <h4>{{__("Billing Details")}}</h4>
            <?php $customer = $row->customer;?>
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
