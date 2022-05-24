<?php


    namespace Modules\Order\Controllers;


    use App\Currency;
    use App\Helpers\ReCaptchaEngine;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Modules\FrontendController;
    use Modules\Order\Events\PaymentUpdated;
    use Modules\Order\Helpers\CartManager;
    use Modules\Order\Models\Order;
    use Modules\Order\Models\Payment;

    class CheckoutController extends FrontendController
    {

        public function index(){
            $data = [
                'items'=>CartManager::items(),
                'page_title'=>__("Checkout"),
                'hide_newsletter'=>true,
                'gateways'=>get_payment_gateway_objects(),
                'user'=>auth()->user()
            ];
            return view('Order::frontend.checkout.index',$data);
        }

        public function process(Request $request){

            $user = auth()->user();
            $items = CartManager::items();
            if(empty($items)){
                return $this->sendError(__("Your cart is empty"));
            }

            /**
             * Google ReCapcha
             */
            if(ReCaptchaEngine::isEnable() and setting_item("order_enable_recaptcha")){
                $codeCapcha = $request->input('g-recaptcha-response');
                if(!$codeCapcha or !ReCaptchaEngine::verify($codeCapcha)){
                    return $this->sendError(__("Please verify the captcha"));
                }
            }

            $rules = [
                'first_name'      => 'required|string|max:255',
                'last_name'       => 'required|string|max:255',
                'phone'           => 'required|string|max:255',
                'country' => 'required',
                'address' => 'required',
                'zip_code' => 'required',
                'payment_gateway' => 'required',
                'term_conditions' => 'required',
            ];
            $payment_gateway = $request->input('payment_gateway');

            $messages = [
                'term_conditions.required'    => __('Please read and accept Term conditions'),
                'payment_gateway.required' => __('Please select Payment gateway'),
            ];
            $validator = Validator::make($request->all(), $rules , $messages );
            if ($validator->fails()) {
                return $this->sendError('', ['errors' => $validator->errors()]);
            }

            $order = CartManager::order();

            $order->gateway = $payment_gateway;
            $billing_data = [
                'first_name'=>$request->input('first_name'),
                'last_name'=>$request->input('last_name'),
                'phone'=>$request->input('phone'),
                'country'=>$request->input('country'),
                'address'=>$request->input('address'),
                'address2'=>$request->input('address2'),
                'state'=>$request->input('state'),
                'city'=>$request->input('city'),
                'zip_code'=>$request->input('zip_code'),
            ];
            $order->billing = $billing_data;

            $gateways = get_payment_gateways();

            $gatewayObj = new $gateways[$payment_gateway]($payment_gateway);
            if (!empty($rules['payment_gateway'])) {
                if (empty($gateways[$payment_gateway]) or !class_exists($gateways[$payment_gateway])) {
                    return $this->sendError(__("Payment gateway not found"));
                }
                if (!$gatewayObj->isAvailable()) {
                    return $this->sendError(__("Payment gateway is not available"));
                }
            }

            $order->addMeta('locale',app()->getLocale());

            $payment = new Payment();
            $payment->object_id = $order->id;
            $payment->object_model = 'order';
            $payment->amount = $order->total;
            $payment->currency = Currency::getCurrent();
            $payment->gateway = $payment_gateway;
            $payment->save();

            $order->payment_id = $payment->id;
            $order->save();

            // Save User
            $billing_data = [
                'billing_first_name'=>$request->input('first_name'),
                'billing_last_name'=>$request->input('last_name'),
                'phone'=>$request->input('phone'),
                'country'=>$request->input('country'),
                'address'=>$request->input('address'),
                'address2'=>$request->input('address2'),
                'state'=>$request->input('state'),
                'city'=>$request->input('city'),
                'zip_code'=>$request->input('zip_code'),
            ];
            foreach ($billing_data as $k=>$v){
                $user->setAttribute($k,$v);
            }
            $user->save();

            try {
                if (!$payment->amount) {
                    $payment->status = $payment::COMPLETED;
                    $payment->save();
                    PaymentUpdated::dispatch($payment);
                    $res = true;
                }else {
                    $res = $gatewayObj->process($payment);
                }

            CartManager::clear();

                if ($res !== true) {
                    return response()->json($res);
                }
                return $this->sendSuccess([
                    'url' => $order->getDetailUrl()
                ]);

            }catch (\Throwable $throwable){
                return $this->sendError($throwable->getMessage());
            }
        }
    }
