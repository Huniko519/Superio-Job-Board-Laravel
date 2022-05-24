<?php


namespace Modules\Order\Helpers;

use Illuminate\Support\Collection;
use Modules\Booking\Models\Bookable;
use Modules\Order\Models\CartItem;
use Modules\Order\Models\Order;
use Modules\Order\Models\OrderItem;
use Modules\Product\Models\ProductLicense;

class CartManager
{
    protected static $session_key='bc_carts';

    public static function add($product_id, $name = '', $qty = 1, $price = 0,$meta = [], $variant_id = false){

        $items = static::items();
        $item = static::item($product_id,$variant_id);
        if(!$item){
            if($product_id instanceof Bookable){
                $item = CartItem::fromModel($product_id,$qty,$price,$meta, $variant_id);
            }else{
                $item = CartItem::fromAttribute($product_id,$name,$qty,$price, $meta, $variant_id);
            }
            $items->put($item->id, $item);

        }else{
            $item->qty = $qty;
            $item->price = $price;
        }

        session()->put(static::$session_key, $items);

        return $item;
    }

    /**
     * Get Cart Item by Product ID (Or Bookable) and Variation ID
     *
     * @param int|Bookable $product_id
     * @param false $variant_id
     * @return CartItem|null
     */
    public static function item($product_id, $variant_id = false){

        $currentItems  = static::items();
        if($product_id instanceof Bookable){
            $items =  $currentItems->where('product_id',$product_id->id);
        }else{
            $items =  $currentItems->where('product_id',$product_id);
        }
        if($variant_id){
            $items->where('variant_id',$variant_id);
        }
        return $items->first();
    }

    /**
     * Update Cart Item
     *
     * @param $cart_item_id
     * @param int $qty
     * @param false $price
     * @param false $variant_id
     * @return bool|Collection|null
     */
    public static function update($cart_item_id,$qty = 1,$price = false, $meta = [], $variant_id = false){

        $items = static::items();
        $find = $items->where('id',$cart_item_id);

        if($find){
            $find->qty = $qty;
            if(!is_null($price)){
                $find->price = $price;
            }
            if(!is_null($variant_id)){
                $find->variant_id = $variant_id;
            }
            if(!is_null($meta)){
                $find->meta = $meta;
            }

            if($qty <= 0){

                return static::remove($cart_item_id);

            }else{
                $items->put($cart_item_id,$find);
                session()->put(static::$session_key, $items);
            }

            return $find;
        }

        return null;
    }

    /**
     * Remove cart item by id
     *
     * @param $cart_item_id
     * @return boolean
     *
     */
    public static function remove($cart_item_id){

        $items = static::items();
        $items->pull($cart_item_id);

        session()->put(static::$session_key, $items->all());

        return true;

    }

    /**
     * @return bool
     */
    public static function clear(){

        session()->remove(static::$session_key);

        return true;
    }


    /**
     * Get Cart Items
     *
     * @return Collection
     */
    public static function items(){
        $items = session()->get(static::$session_key);
        if(!$items or !$items instanceof Collection){
            return new Collection([]);
        }

        return $items;
    }

    /**
     * Return number of cart items
     *
     * @return int
     */
    public static function count(){
        return count(static::items());
    }

    /**
     * Get Subtotal
     *
     * @return float
     */
    public static function subtotal(){
        return static::items()->sum('subtotal');
    }

    /**
     * Get Subtotal
     *
     * @return float
     */
    public static function total(){
        return static::subtotal();
    }

    public static function get_cart_fragments(){
        return [
            '.header_widgets .dropdown_cart'=>view('Order::frontend.cart.mini-cart')->render(),
            '.header_widgets .cart-total'=> self::count()
        ];
    }


    /**
     * return Order
     */
    public static function order(){
        $order = new Order();
        $order->customer_id = auth()->id();
        $order->status = 'draft';
        $order->save();

        $items = static::items();
        foreach ($items as $item){
            $order_item = new OrderItem();
            $order_item->order_id = $order->id;
            $order_item->object_id = $item->model->id;
            $order_item->object_model = $item->model->type;
            $order_item->price = $item->price;
            $order_item->qty = $item->qty;
            $order_item->subtotal = $item->subtotal;
            $order_item->status = 'draft';
            $order_item->meta = $item->meta;
            $order_item->save();

        }
        $order->syncTotal();
        return $order;
    }

}
