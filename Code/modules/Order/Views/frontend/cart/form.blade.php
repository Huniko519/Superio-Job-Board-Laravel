<div class="cart_page_form">
    <form action="#">
        <div class=" table-responsive">
        <table class="table">
              <thead>
                <tr class="carttable_row">
                    <th class="cartm_title">{{__('Product')}}</th>
                    <th class="cartm_title">{{__('Price')}}</th>
                    <th class="cartm_title">{{__('Quantity')}}</th>
                    <th class="cartm_title">{{__('Total')}}</th>
                    @if(empty($is_checkout))
                    <th class="cartm_title">{{__('Actions')}}</th>
                    @endif
                </tr>
              </thead>
              <tbody class="table_body">

                @foreach(\Modules\Order\Helpers\CartManager::items() as $cartItem)
                <tr>
                    <th scope="row">
                        @if($cartItem->model)
                            <ul class="cart_list d-flex align-center list-unstyled">
                                @if($cartItem->model->image_id)
                                <li class="list-inline-item pr20">
                                    {!! get_image_tag($cartItem->model->image_id ?? '','thumb',['class'=>'float-left img-120 mw-80'])!!}
                                </li>
                                @endif
                                <li class="list-inline-item"><a class="cart_title" href="{{$cartItem->getDetailUrl()}}">{{$cartItem->name}}</a></li>
                            </ul>
                        @else
                            <ul class="cart_list d-flex align-center list-unstyled">
                                <li class="list-inline-item pr20">
                                </li>
                                <li class="list-inline-item"><a class="cart_title" >{{$cartItem->name}}</a></li>
                            </ul>
                        @endif
                    </th>
                    <td>{{format_money($cartItem->price)}}</td>
                    <td>{{$cartItem->qty}}</td>
                    <td class="cart_total">{{format_money($cartItem->subtotal)}}</td>
                    @if(empty($is_checkout))
                    <td>
                        <a href="#" class="bravo_delete_cart_item text-danger" data-id="{{$cartItem->id}}"><i class="icon_trash_alt"></i></a>
                    </td>
                    @endif
                </tr>
                @endforeach
              </tbody>
        </table>
        </div>
    </form>
</div>
