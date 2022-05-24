<?php
namespace Plugins\PaymentFlutterWaveCheckout\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Modules\Order\Events\PaymentUpdated;
use Modules\Order\Models\Order;
use Illuminate\Support\Facades\Log;
use Modules\Order\Gateways\BaseGateway;
use Modules\Order\Models\Payment;

class FlutterWaveCheckoutGateway extends BaseGateway
{
    protected $id = 'flutter_wave_checkout_gateway';
    public    $name            = 'FlutterWave Checkout';
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable FlutterWave Standard?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("FlutterWave")
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description')
            ],
            [
                'type'  => 'input',
                'id'    => 'flutter_wave_api_key',
                'label' => __('Public Key'),
            ],
            [
                'type'  => 'input',
                'id'    => 'flutter_wave_api_secret_key',
                'label' => __('Secret Key'),
            ],
            [
                'type'  => 'input',
                'id'    => 'flutter_wave_api_encryption_key',
                'label' => __('Encryption Key'),
            ],

        ];
    }
    public function process(Payment $payment)
    {
        if (!$payment->amount) {
            throw new Exception(__("Order amount is zero. Can not process payment gateway!"));
        }
        return ['url' => route('checkoutFlutterWaveGateway',['payment_id'=>$payment->id])];
    }
    public function handlePurchaseData($data, $payment)
    {
        $data['public_key']= $this->getOption('flutter_wave_api_key');
        $data['amount'] = ((float)$payment->amount);
        $data['currency'] = setting_item('currency_main');
        $data['tx_ref'] = $payment->id;
        $data['description'] = setting_item("site_title")." - #".$payment->id;
        $data['service_title'] = $payment->service->title??"";
        $data['checkoutNormal'] = 0;
        $data['returnUrl'] = $this->getReturnUrl() . '?c=' . $payment->id ;
        $data['cancelUrl'] = $this->getCancelUrl() . '?c=' . $payment->id;
        return $data;
    }
    public function cancelPayment(Request $request)
    {
        $c = $request->query('c');
        $payment = Payment::find($c);
        if ($payment->status!=='completed') {
            $payment = $payment->payment;
            if ($payment) {
                $payment->status = 'cancel';
                $payment->logs = \GuzzleHttp\json_encode([
                    'customer_cancel' => 1,
                    'log'=>$request->all()
                ]);
                $payment->save();
            }
            return redirect($payment->getDetailUrl())->with("error", __("You cancelled the payment"));
        }else {
            return redirect(url('/'));
        }
    }
    public function confirmPayment(Request $request){
        $payment_id = $request->query('payment_id');
        $payment = Payment::find($payment_id);
        $transaction_id = $request->transaction_id??"";
        $response = $request->all();
        if (!empty($payment) and $payment->status !=='completed') {
            if(!empty($transaction_id)){
                $response = $this->verifyTransaction($transaction_id);
            }
            if ($response['status'] ==='successful') {
                $payment->status = 'completed';
                $payment->logs = \GuzzleHttp\json_encode($response);
                $payment->save();
                PaymentUpdated::dispatch($payment);
                Session::flash('success', __("You payment has been processed successfully"));
                if($request->ajax()){
                    return response()->json(['status'=>1,'message'=>__("You payment has been processed successfully")]);
                }
                return $payment->getDetailUrl();
            }
        }
        $payment->status = 'fail';
        $payment->logs = \GuzzleHttp\json_encode($response);
        $payment->save();
        Session::flash('error', __("Payment Failed"));
        if($request->ajax()){
            return response()->json(['status'=>0,'message'=>__("Payment Failed")]);
        }
        return $payment->getDetailUrl();
    }

    public function verifyTransaction($id){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.flutterwave.com/v3/transactions/".$id."/verify",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->getOption('flutter_wave_api_secret_key')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return  $response;
    }
}