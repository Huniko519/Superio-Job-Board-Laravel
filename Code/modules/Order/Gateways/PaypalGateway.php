<?php
namespace Modules\Order\Gateways;

use App\Currency;
use Illuminate\Http\Request;
use Mockery\Exception;
use Modules\Booking\Events\BookingUpdatedEvent;
use Modules\Booking\Models\Booking;
use Modules\Booking\Models\Payment;
use Modules\Order\Events\PaymentUpdated;
use Omnipay\Omnipay;
use Omnipay\PayPal\ExpressGateway;
use Illuminate\Support\Facades\Log;

class PaypalGateway extends BaseGateway
{
    public $name = 'Paypal Express Checkout';
    /**
     * @var $gateway ExpressGateway
     */
    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Paypal Standard?')
            ],
            [
                'type'       => 'input',
                'id'         => 'name',
                'label'      => __('Custom Name'),
                'std'        => __("Paypal"),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'upload',
                'id'    => 'logo_id',
                'label' => __('Custom Logo'),
            ],
            [
                'type'  => 'editor',
                'id'    => 'html',
                'label' => __('Custom HTML Description'),
                'multi_lang' => "1"
            ],
            [
                'type'  => 'checkbox',
                'id'    => 'test',
                'label' => __('Enable Sandbox Mode?')
            ],
            [
                'type'    => 'select',
                'id'      => 'convert_to',
                'label'   => __('Convert To'),
                'desc'    => __('In case of main currency does not support by PayPal. You must select currency and input exchange_rate to currency that PayPal support'),
                'options' => $this->supportedCurrency()
            ],
            [
                'type'       => 'input',
                'input_type' => 'number',
                'id'         => 'exchange_rate',
                'label'      => __('Exchange Rate'),
                'desc'       => __('Example: Main currency is VND (which does not support by PayPal), you may want to convert it to USD when customer checkout, so the exchange rate must be 23400 (1 USD ~ 23400 VND)'),
            ],
            [
                'type'      => 'input',
                'id'        => 'test_account',
                'label'     => __('Sandbox API Username'),
                'condition' => 'g_paypal_test:is(1)'
            ],
            [
                'type'      => 'input',
                'id'        => 'test_client_id',
                'label'     => __('Sandbox API Password'),
                'condition' => 'g_paypal_test:is(1)'
            ],
            [
                'type'      => 'input',
                'id'        => 'test_client_secret',
                'label'     => __('Sandbox Signature'),
                'std'       => '',
                'condition' => 'g_paypal_test:is(1)'
            ],
            [
                'type'      => 'input',
                'id'        => 'account',
                'label'     => __('API Username'),
                'condition' => 'g_paypal_test:is()'
            ],
            [
                'type'      => 'input',
                'id'        => 'client_id',
                'label'     => __('API Password'),
                'condition' => 'g_paypal_test:is()'
            ],
            [
                'type'      => 'input',
                'id'        => 'client_secret',
                'label'     => __('Signature'),
                'std'       => '',
                'condition' => 'g_paypal_test:is()'
            ],
        ];
    }

    public function process(\Modules\Order\Models\Payment $payment)
    {
        if (!$payment->amount) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }
        $this->getGateway();
        $data = $this->handlePurchaseData([
            'amount'        => (float)$payment->amount,
            'transactionId' => $payment->id.'.'.uniqid()
        ], $payment);
        $response = $this->gateway->purchase($data)->send();
        if ($response->isRedirect()) {
            $payment->status = $payment::ON_HOLD;
            $payment->save();
            return ['url' => $response->getRedirectUrl()];

        } else {
            throw new Exception('Paypal Gateway: ' . $response->getMessage());
        }
    }

    public function confirmPayment(Request $request)
    {
        $c = $request->query('c');
        $payment = \Modules\Order\Models\Payment::find($c);
        if ($payment) {
            $this->getGateway();
            $data = $this->handlePurchaseData([
                'amount'        => (float)$payment->amount,
                'transactionId' => $payment->id . '.' . uniqid()
            ], $payment);
            $response = $this->gateway->completePurchase($data)->send();
            if ($response->isSuccessful()) {
                $payment->addMeta('log',$response->getData());
                $payment->status = 'completed';
                $payment->logs = \GuzzleHttp\json_encode($response->getData());
                $payment->save();

                PaymentUpdated::dispatch($payment);

            } else {
                $payment->addMeta('log',$response->getData());
            }

            return redirect($payment->getDetailUrl());
        }
    }

    public function cancelPayment(Request $request)
    {
        $c = $request->query('c');
        $payment = \Modules\Order\Models\Payment::find($c);
        if ($payment) {
            $payment->addMeta('query',$request->query());
            return redirect($payment->getDetailUrl());
        }

    }

    public function getGateway()
    {

        $this->gateway = Omnipay::create('PayPal_Express');
        $this->gateway->setUsername($this->getOption('account'));
        $this->gateway->setPassword($this->getOption('client_id'));
        $this->gateway->setSignature($this->getOption('client_secret'));
        $this->gateway->setTestMode(false);
        if ($this->getOption('test')) {
            $this->gateway->setUsername($this->getOption('test_account'));
            $this->gateway->setPassword($this->getOption('test_client_id'));
            $this->gateway->setSignature($this->getOption('test_client_secret'));
            $this->gateway->setTestMode(true);
        }
    }

    public function handlePurchaseData($data, $payment = null)
    {
        $main_currency = setting_item('currency_main');
        $supported = $this->supportedCurrency();
        $convert_to = $this->getOption('convert_to');
        $data['currency'] = $main_currency;
        $data['returnUrl'] = $this->getReturnUrl() . '?c=' . $payment->id;
        $data['cancelUrl'] = $this->getCancelUrl() . '?c=' . $payment->id;
        if (!array_key_exists($main_currency, $supported)) {
            if (!$convert_to) {
                throw new Exception(__("PayPal does not support currency: :name", ['name' => $main_currency]));
            }
            if (!$exchange_rate = $this->getOption('exchange_rate')) {
                throw new Exception(__("Exchange rate to :name must be specific. Please contact site owner", ['name' => $convert_to]));
            }
            if ($payment) {
                $payment->converted_currency = $convert_to;
                $payment->converted_amount = $data['amount'] / $exchange_rate;
                $payment->exchange_rate = $exchange_rate;
            }
            $data['originalAmount'] = (float)$data['amount'];
            $data['amount'] = number_format( (float)$data['amount'] / $exchange_rate , 2 );
            $data['currency'] = $convert_to;
        }
        return $data;
    }

    public function supportedCurrency()
    {
        return [
            "aud" => "Australian dollar",
            "brl" => "Brazilian real 2",
            "cad" => "Canadian dollar",
            "czk" => "Czech koruna",
            "dkk" => "Danish krone",
            "eur" => "Euro",
            "hkd" => "Hong Kong dollar",
            "huf" => "Hungarian forint 1",
            "inr" => "Indian rupee 3",
            "ils" => "Israeli new shekel",
            "jpy" => "Japanese yen 1",
            "myr" => "Malaysian ringgit 2",
            "mxn" => "Mexican peso",
            "twd" => "New Taiwan dollar 1",
            "nzd" => "New Zealand dollar",
            "nok" => "Norwegian krone",
            "php" => "Philippine peso",
            "pln" => "Polish złoty",
            "gbp" => "Pound sterling",
            "rub" => "Russian ruble",
            "sgd" => "Singapore dollar ",
            "sek" => "Swedish krona",
            "chf" => "Swiss franc",
            "thb" => "Thai baht",
            "usd" => "United States dollar",
        ];
    }
}
