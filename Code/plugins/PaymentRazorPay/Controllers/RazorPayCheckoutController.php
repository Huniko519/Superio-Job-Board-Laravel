<?php

    namespace Plugins\PaymentRazorPay\Controllers;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Modules\Booking\Models\Booking;
    use Plugins\PaymentRazorPay\Gateway\RazorPayCheckoutGateway;

    class RazorPayCheckoutController extends Controller
    {
        public function handleCheckout(Request $request, $c, $r)
        {

            if ($c == '' || $r == '') {
                return redirect("/");
            }
            $payment = \Modules\Order\Models\Payment::find($c);
            if (!$payment) {
                return redirect("/");
            }
            $razorPayGateway = new RazorPayCheckoutGateway();
            $sandBoxEnable = $razorPayGateway->getOption('razorpay_enable_sandbox');
            if ($sandBoxEnable) {
                $keyId = $razorPayGateway->getOption('razorpay_test_key_id');
                $keySecret = $razorPayGateway->getOption('razorpay_test_key_secret');
            } else {
                $keyId = $razorPayGateway->getOption('razorpay_key_id');
                $keySecret = $razorPayGateway->getOption('razorpay_key_secret');
            }
            $data = [
                'payment'   => $payment,
                'form_url'  => $this->getReturnUrl($c), 'key' => $keyId,
                'secret'    => $keySecret,
                'cancelUrl' => $this->getCancelUrl($c),
                'c'=>$c,
                'r'=>$r
            ];

            return view("PaymentRazorPay::frontend.razorpaycheckout", $data);

        }

        public function handleProcess(Request $request, $r,$c)
        {

            $request->request->add(['c'=>$c,'r'=>$r]);
            $razorPayGateway = new RazorPayCheckoutGateway();
            return $razorPayGateway->confirmPayment($request);
        }

        public function getReturnUrl($c)
        {
            return url(app_get_locale(false, false, "/")).'/gateway_callback/processRazorPayGT/razorpay_gateway/' .$c;
        }

        public function getCancelUrl($c)
        {
            return url(app_get_locale(false, false, "/").config('booking.booking_route_prefix').'/cancel/razorpay_gateway').'?c='.$c;
        }
    }
