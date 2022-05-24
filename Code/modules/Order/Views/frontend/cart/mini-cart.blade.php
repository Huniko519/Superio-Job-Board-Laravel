<?php
    $countCart = \Modules\Order\Helpers\CartManager::count();
    ?>
    <div class="drop_headline">
        <h4>  {{__('My Cart')}} </h4>
        @if(!empty($countCart))
            <a href="{{route('order.checkout')}}" class="btn_action hover:bg-gray-100 mr-2 px-2 py-1 rounded-md underline"> {{__('Checkout')}} </a>
        @endif
    </div>
    @if(!empty($countCart))
    <ul class="dropdown_cart_scrollbar" data-simplebar>
        @foreach(\Modules\Order\Helpers\CartManager::items() as $cart_item_id => $cartItem)
            <li>
                @if($cartItem->model)
                <div class="cart_avatar">
                    {!! get_image_tag($cartItem->model->image_id,'thumb',['class'=>'float-left','lazy'=>false])!!}
                </div>
                <div class="cart_text">
                    <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1">{{$cartItem->model->title}}</div>
                </div>
                @else
                    <div class="cart_avatar"></div>
                    <div class="cart_text">
                        <div class=" font-semibold leading-4 mb-1.5 text-base line-clamp-1">{{$cartItem->name}}</div>
                    </div>
                @endif
                <div class="cart_price">
                    <span> {{format_money($cartItem->price)}} </span>
                    <button class="type bc_delete_cart_item"  data-id="{{$cart_item_id}}"> {{__('Remove')}}</button>
                </div>
            </li>
        @endforeach
    </ul>
    <div class="cart_footer">
        <p> {{__('Subtotal')}} : {{format_money(\Modules\Order\Helpers\CartManager::subtotal())}} </p>
        <h1> {{__('Total')}} :  <strong> {{format_money(\Modules\Order\Helpers\CartManager::subtotal())}}</strong> </h1>
    </div>
    @else
        <div class="cart_body">
            <p>{{__("Your cart is empty")}}</p>
        </div>
    @endif

