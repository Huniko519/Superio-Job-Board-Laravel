<?php
namespace Plugins\PaymentRazorPay\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Exception;
use Modules\Order\Events\PaymentUpdated;
use Modules\Order\Gateways\BaseGateway;

class RazorPayCheckoutGateway extends BaseGateway
{
    protected $id   = 'razorpay_gateway';
    public    $name = 'Razorpay Checkout';
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Razorpay Checkout?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Razorpay Checkout"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],[
                'type'    => 'select',
                'id'      => 'convert_to',
                'label'   => __('Convert To'),
                'desc'    => __('In case of main currency does not support by RazorPay. You must select currency and input exchange_rate to currency that RazorPay support'),
                'options' => $this->supportedCurrency()
            ],
            [
                'type'       => 'input',
                'input_type' => 'number',
                'id'         => 'exchange_rate',
                'label'      => __('Exchange Rate'),
                'desc'       => __('Example: Main currency is VND (which does not support by RazorPay), you may want to convert it to USD when customer checkout, so the exchange rate must be 23400 (1 USD ~ 23400 VND)'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'input',
                'id'    => 'razorpay_key_id',
                'label' => __('Key ID'),
            ],
            [
                'type'  => 'input',
                'id'    => 'razorpay_key_secret',
                'label' => __('Key Secret'),
            ],
            [
                'type'  => 'checkbox',
                'id'    => 'razorpay_enable_sandbox',
                'label' => __('Enable Sandbox Mode'),
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_test_key_id',
                'label'     => __('Test Key ID'),
            ],
            [
                'type'       => 'input',
                'id'        => 'razorpay_test_key_secret',
                'label'     => __('Test Key Secret'),
            ],
        ];
    }

    public function process(\Modules\Order\Models\Payment $payment)
    {
        if (!$payment->amount) {
            throw new Exception(__("Order amount is zero. Can not process payment gateway!"));
        }

        $sandBoxEnable = $this->getOption('razorpay_enable_sandbox');
        if ($sandBoxEnable) {
            $keyId = $this->getOption('razorpay_test_key_id');
            $keySecret = $this->getOption('razorpay_test_key_secret');
        } else {
            $keyId = $this->getOption('razorpay_key_id');
            $keySecret = $this->getOption('razorpay_key_secret');
        }

        if ($keyId == '' || $keySecret == '')
        {
            return ['message'=>__("Payment Failed"),'url'=>$payment->getDetailUrl()];
        }
        $data = $this->handlePurchaseData([
            'amount' => (float)$payment->amount,
            'order_id' => $payment->id,
        ], $payment);
        $orderData = [
            'receipt' => $payment->id."",
            'amount' => (float)$data['amount'] * 100, // 2000 rupees in paise
            'currency' => strtoupper($data['currency']),
            'payment_capture' => 1 // auto capture
        ];

        $razorpayOrder  = $this->generateRazorPayOrder($orderData,$keyId,$keySecret,$sandBoxEnable);
        if($razorpayOrder)
        {
            $razorpayOrder = json_decode($razorpayOrder,true);

            if(isset($razorpayOrder['error']) && !empty($razorpayOrder['error']))
            {
                $payment->status = 'fail';
                $payment->logs = \GuzzleHttp\json_encode($razorpayOrder);
                $payment->save();
                throw new Exception($razorpayOrder['error']['description']);

            }else if (isset($razorpayOrder['id']) && !empty($razorpayOrder['id'])) {
                $queryData = [];
                $queryData['c'] = $data['cart_order_id'];
                $queryData['r']= $razorpayOrder['id'];
                $payment->addMeta('razorpay_order_id',$razorpayOrder['id']);
                $payment->addMeta('razorpay_order_log',json_encode($razorpayOrder));
                return ['url'=>route('checkoutRazorPayGateway',[$queryData['c'],$queryData['r']])];
            } else {
                $payment->status = 'fail';
                $payment->logs = \GuzzleHttp\json_encode($razorpayOrder);
                $payment->save();
                return ['message'=>__("Payment Failed"),'url'=>$payment->getDetailUrl()];
            }

        }else{
            return ['message'=>__("Payment Failed"),'url'=>$payment->getDetailUrl()];
        }

    }

    public function handlePurchaseData($data, $payment)
    {
        $razorpaycheckout_args = array();
        $main_currency = setting_item('currency_main');
        $supported = $this->supportedCurrency();
        $convert_to = $this->getOption('convert_to');
        if($payment)
        {
            $payment->currency = $main_currency;
            $payment->amount = ((float)$payment->amount);
        }

        $billing = $payment->order->billing;
        $razorpaycheckout_args['currency'] = $main_currency;
        $razorpaycheckout_args['cart_order_id'] = $payment->id;
        $razorpaycheckout_args['amount'] = ((float)$payment->amount);
        $razorpaycheckout_args['description'] = setting_item("site_title")." - #".$payment->id;
        $razorpaycheckout_args['return_url'] = $this->getCancelUrl() . '?c=' . $payment->id;
        $razorpaycheckout_args['x_receipt_link_url'] = $this->getReturnUrl() . '?c=' . $payment->id;
        $razorpaycheckout_args['currency_code'] = setting_item('currency_main');
        $razorpaycheckout_args['card_holder_name'] = $payment->first_name . ' ' . $payment->last_name;
        $razorpaycheckout_args['street_address'] = $billing['address']??"";
        $razorpaycheckout_args['street_address2'] = $billing['address2']??"";
        $razorpaycheckout_args['city'] = $billing['city']??"";
        $razorpaycheckout_args['state'] = $billing['state']??"";
        $razorpaycheckout_args['country'] = $billing['country']??"";
        $razorpaycheckout_args['zip'] = $billing['zip']??"";
        $razorpaycheckout_args['phone'] = $billing['phone']??"";
        $razorpaycheckout_args['email'] = $billing['email']??"";
        $razorpaycheckout_args['lang'] = app()->getLocale();
        $supported = array_change_key_case($supported);
        if (!array_key_exists($main_currency, $supported)) {
            if (!$convert_to) {
                throw new Exception(__("RazorPay does not support currency: :name", ['name' => $main_currency]));
            }
            if (!$exchange_rate = $this->getOption('exchange_rate')) {
                throw new Exception(__("Exchange rate to :name must be specific. Please contact site owner", ['name' => $convert_to]));
            }
            if ($payment) {

                $payment->converted_currency = $convert_to;
                $payment->converted_amount = $payment->amount / $exchange_rate;
                $payment->exchange_rate = $exchange_rate;
            }
            $razorpaycheckout_args['amount'] = number_format( $payment->amount / $exchange_rate , 2 );
            $razorpaycheckout_args['currency'] = $convert_to;


        }


        return $razorpaycheckout_args;
    }

    public function getDisplayHtml()
    {
        return $this->getOption('html', '');
    }

    public function confirmPayment($request)
    {
        $c = $request->get('c');
        $payment = \Modules\Order\Models\Payment::find($c);
        if(empty($payment)){
            return url('/');
        }
        if ($payment->status !== 'completed') {
            $sandBoxEnable = $this->getOption('razorpay_enable_sandbox');
            if ($sandBoxEnable) {
                $keyId = $this->getOption('razorpay_test_key_id');
                $keySecret = $this->getOption('razorpay_test_key_secret');
            } else {
                $keyId = $this->getOption('razorpay_key_id');
                $keySecret = $this->getOption('razorpay_key_secret');
            }
            $orderId = $request->get('razorpay_order_id');
            $paymentId = $request->get('razorpay_payment_id');
            $payload = $orderId . '|' . $paymentId;
            $actualSignature = hash_hmac('sha256', $payload, $keySecret);
            if ($actualSignature != $request->razorpay_signature) {
                $payment->status = 'fail';
                $payment->logs = \GuzzleHttp\json_encode($request->all());
                $payment->save();
                $payment->addMeta('log',$request->all());
                Session::flash('error', __("Payment Failed"));
                return $payment->getDetailUrl();
            } else {
                $payment->status = 'completed';
                $payment->logs = \GuzzleHttp\json_encode($request->all());
                $payment->save();
                PaymentUpdated::dispatch($payment);
                Session::flash('success', __("You payment has been processed successfully"));
                return $payment->getDetailUrl();
            }
        }else{
            return $payment->getDetailUrl();
        }
    }

    public function cancelPayment(Request $request)
    {
        $c = $request->query('c');
        $payment = \Modules\Order\Models\Payment::find($c);
        if(empty($payment)){
            return redirect(url('/'));
        }
        if ($payment->status!=='completed') {
            $payment->status = 'cancel';
            $payment->logs = \GuzzleHttp\json_encode([
                'customer_cancel' => 1,
                'log'=>$request->all()
            ]);
            $payment->save();
            return redirect($payment->getDetailUrl())->with("error", __("You cancelled the payment"));
        }else{
            return redirect($payment->getDetailUrl());
        }
    }

    public function supportedCurrency()
    {
        return [
            'INR' => 'Indian rupee',
            'AED'=>'United Arab Emirates Dirham',
            'ALL'=>'Albanian lek',
            'AMD'=>'Armenian dram',
            'ARS'=>'Argentine peso',
            'AUD'=>'Australian dollar',
            'AWG'=>'Aruban florin',
            'BBD'=>'Barbadian dollar',
            'BDT'=>'Bangladeshi taka',
            'BMD'=>'Bermudian dollar',
            'BND'=>'Brunei dollar',
            'BOB'=>'Bolivian boliviano',
            'BSD'=>'Bahamian dollar',
            'BWP'=>'Botswana pula',
            'BZD'=>'Belize dollar',
            'CAD'=>'Canadian dollar',
            'CHF'=>'Swiss franc',
            'CNY'=>'Chinese yuan renminbi',
            'COP'=>'Colombian peso',
            'CRC'=>'Costa Rican colon',
            'CUP'=>'Cuban peso',
            'CZK'=>'Czech koruna',
            'DKK'=>'Danish krone',
            'DOP'=>'Dominican peso',
            'DZD'=>'Algerian dinar',
            'EGP'=>'Egyptian pound',
            'ETB'=>'Ethiopian birr',
            'EUR'=>'European euro',
            'FJD'=>'Fijian dollar',
            'GBP'=>'Pound sterling',
            'GHS'=>'Ghanian Cedi',
            'GIP'=>'Gibraltar pound',
            'GMD'=>'Gambian dalasi',
            'GTQ'=>'Guatemalan quetzal',
            'GYD'=>'Guyanese dollar',
            'HKD'=>'Hong Kong dollar',
            'HNL'=>'Honduran lempira',
            'HRK'=>'Croatian kuna',
            'HTG'=>'Haitian gourde',
            'HUF'=>'Hungarian forint',
            'IDR'=>'Indonesian rupiah',
            'ILS'=>'Israeli new shekel',
            'JMD'=>'Jamaican dollar',
            'KES'=>'Kenyan shilling',
            'KGS'=>'Kyrgyzstani som',
            'KHR'=>'Cambodian riel',
            'KYD'=>'Cayman Islands dollar',
            'KZT'=>'Kazakhstani tenge',
            'LAK'=>'Lao kip',
            'LBP'=>'Lebanese pound',
            'LKR'=>'Sri Lankan rupee',
            'LRD'=>'Liberian dollar',
            'LSL'=>'Lesotho loti',
            'MAD'=>'Moroccan dirham',
            'MDL'=>'Moldovan leu',
            'MKD'=>'Macedonian denar',
            'MMK'=>'Myanmar kyat',
            'MNT'=>'Mongolian tugrik',
            'MOP'=>'Macanese pataca',
            'MUR'=>'Mauritian rupee',
            'MVR'=>'Maldivian rufiyaa',
            'MWK'=>'Malawian kwacha',
            'MXN'=>'Mexican peso',
            'MYR'=>'Malaysian ringgit',
            'NAD'=>'Namibian dollar',
            'NGN'=>'Nigerian naira',
            'NIO'=>'Nicaraguan cordoba',
            'NOK'=>'Norwegian krone',
            'NPR'=>'Nepalese rupee',
            'NZD'=>'New Zealand dollar',
            'PEN'=>'Peruvian sol',
            'PGK'=>'Papua New Guinean kina',
            'PHP'=>'Philippine peso',
            'PKR'=>'Pakistani rupee',
            'QAR'=>'Qatari riyal',
            'RUB'=>'Russian ruble',
            'SAR'=>'Saudi Arabian riyal',
            'SCR'=>'Seychellois rupee',
            'SEK'=>'Swedish krona',
            'SGD'=>'Singapore dollar',
            'SLL'=>'Sierra Leonean leone',
            'SOS'=>'Somali shilling',
            'SSP'=>'South Sudanese pound',
            'SVC'=>'Salvadoran colón',
            'SZL'=>'Swazi lilangeni',
            'THB'=>'Thai baht',
            'TTD'=>'Trinidad and Tobago dollar',
            'TZS'=>'Tanzanian shilling',
            'USD'=>'United States dollar',
            'UYU'=>'Uruguayan peso',
            'UZS'=>'Uzbekistani so',
            'YER'=>'Yemeni rial',
            'ZAR'=>'South African rand',
        ];
    }

    public function generateRazorPayOrder($orderData,$key_id,$keySecret,$enableSandbox=false)
    {
        $ch = curl_init();

        $url = 'https://api.razorpay.com/v1/orders';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $keySecret);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }
}
