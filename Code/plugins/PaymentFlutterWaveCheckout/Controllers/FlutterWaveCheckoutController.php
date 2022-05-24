<?php

    namespace Plugins\PaymentFlutterWaveCheckout\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Modules\Order\Models\Payment;
    use Plugins\PaymentFlutterWaveCheckout\Gateway\FlutterWaveCheckoutGateway;


    class FlutterWaveCheckoutController extends Controller
    {


        public function handleCheckout(Request $request, $payment_id)
        {
            if (!empty($payment_id)) {
                $payment = Payment::find($payment_id);
                if (empty($payment)) {
                    return redirect('/');
                }
                $gateway = new FlutterWaveCheckoutGateway();
                $data = $gateway->handlePurchaseData([], $payment);
                return view("PaymentFlutterWaveCheckout::frontend.checkout", ['payment' => $payment, 'data' => $data]);
            } else {
                return redirect('/');
            }
        }


        public function confirmCheckout(Request $request, $payment_id)
        {
            $FlutterWaveCheckoutGateway = new FlutterWaveCheckoutGateway();
            $request->merge(['payment_id'=>$payment_id]);
            return $FlutterWaveCheckoutGateway->confirmPayment($request);

        }

        public function webhookCheckout(){
            $request = \request();
            $data = $request->query('data',[]);
            $payment_id = $data['tx_ref']??"";
            if(!empty($payment_id)){
                $FlutterWaveCheckoutGateway = new FlutterWaveCheckoutGateway();
                $request->merge(['payment_id'=>$payment_id]);
                return $FlutterWaveCheckoutGateway->confirmPayment($request);
            }
        }

    }
