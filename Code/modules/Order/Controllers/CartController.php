<?php


namespace Modules\Order\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\FrontendController;
use Modules\Order\Helpers\CartManager;

class CartController extends FrontendController
{

    public function index(Request $request){

        $data = [
            'items'=>CartManager::items(),
            'page_title'=>__("Cart")
        ];
        return view('Order::frontend.cart.index',$data);
    }

    public function addToCart(Request $request)
    {
        if(!Auth::check()){
            return $this->sendError(__("You have to login in to do this"))->setStatusCode(401);
        }

        if(Auth::user() && !Auth::user()->hasVerifiedEmail() && setting_item('enable_verify_email_register_user')==1){
            return $this->sendError(__("You have to verify email first"), ['url' => url('/email/verify')]);
        }

        $validator = Validator::make($request->all(), [
            'id'   => 'required|integer',
            'type' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }
        $service_type = $request->input('type');
        $service_id = $request->input('id');
        $allServices = get_bookable_services();
        if (empty($allServices[$service_type])) {
            return $this->sendError(__('Service type not found'));
        }
        $module = $allServices[$service_type];
        $service = $module::find($service_id);

        if (empty($service) or !is_subclass_of($service, '\\Modules\\Booking\\Models\\Bookable')) {
            return $this->sendError(__('Service not found'));
        }
        if (!$service->isBookable()) {
            return $this->sendError(__('Service is not bookable'));
        }
        return $service->addToCart($request);
    }
    public function removeCartItem(Request $request){
        $validator = Validator::make($request->all(), [
            'id'   => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('', ['errors' => $validator->errors()]);
        }

        CartManager::remove($request->input('id'));

        return $this->sendSuccess([
            'fragments'=> CartManager::get_cart_fragments(),
            'reload'=>CartManager::count()  ? false: true,
        ],__("Item removed"));
    }


}
