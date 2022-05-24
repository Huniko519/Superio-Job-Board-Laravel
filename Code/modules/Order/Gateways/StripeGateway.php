<?php
namespace Modules\Order\Gateways;

use Mockery\Exception;
use Modules\Booking\Events\BookingCreatedEvent;
use Modules\Order\Events\PaymentUpdated;
use Omnipay\Omnipay;
use Omnipay\Common\Exception\InvalidCreditCardException;
use Illuminate\Support\Facades\Log;

use App\Helpers\Assets;

class StripeGateway extends BaseGateway
{
    protected $id = 'stripe';

    public $name = 'Stripe Checkout';

    protected $gateway;

    public function getOptionsConfigs()
    {
        return [
            [
                'type'  => 'checkbox',
                'id'    => 'enable',
                'label' => __('Enable Stripe Standard?')
            ],
            [
                'type'  => 'input',
                'id'    => 'name',
                'label' => __('Custom Name'),
                'std'   => __("Stripe"),
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
                'type'       => 'input',
                'id'        => 'stripe_secret_key',
                'label'     => __('Secret Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_publishable_key',
                'label'     => __('Publishable Key'),
            ],
            [
                'type'       => 'checkbox',
                'id'        => 'stripe_enable_sandbox',
                'label'     => __('Enable Sandbox Mode'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_test_secret_key',
                'label'     => __('Test Secret Key'),
            ],
            [
                'type'       => 'input',
                'id'        => 'stripe_test_publishable_key',
                'label'     => __('Test Publishable Key'),
            ]
        ];
    }

    public function process(\Modules\Order\Models\Payment $payment)
    {

        if (!$payment->amount) {
            throw new Exception(__("Booking total is zero. Can not process payment gateway!"));
        }
        $rules = [
            'card_name'    => ['required'],
            'token'  => ['required'],
        ];
        $messages = [
            'card_name.required'    => __('Card Name is required field'),
            'token.required'  => __('Card invalid!'),
        ];
        if(is_api()){
            $rules = [
                'card_name'    => ['required'],
                'card_number'  => ['required'],
                'cvv'          => ['required'],
                'expiry_month' => ['required'],
                'expiry_year'  => ['required'],
            ];
            $messages = [
                'card_name.required'    => __('Card Name is required field'),
                'card_number.required'  => __('Card Number is required field'),
                'cvv.required'          => __('CVV Code is required field'),
                'expiry_month.required' => __('Expiry Month is required field'),
                'expiry_year.required'  => __('Expiry Year is required field'),
            ];
        }
        $validator = \Illuminate\Support\Facades\Validator::make(request()->input(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['errors'   => $validator->errors() ], 200)->send();
        }
        $this->getGateway();
        $data = $this->handlePurchaseData([
            'amount'        => (float)$payment->amount,
            'transactionId' => $payment->id.'.'.uniqid()
        ], $payment);
        try{
            $response = $this->gateway->purchase($data)->send();
            if ($response->isSuccessful()) {

                $payment->addMeta('log',$response->getData());
                $payment->status = 'completed';
                $payment->logs = json_encode($response->getData());
                $payment->save();

                PaymentUpdated::dispatch($payment);

                return ['url' => $payment->getDetailUrl()];

            } else {
                $payment->status = 'fail';
                $payment->logs = json_encode($response->getData());
                $payment->save();
                throw new Exception($response->getMessage());
            }
        }
        catch(Exception | InvalidCreditCardException $e){
            $payment->status = 'fail';
            $payment->save();
            throw new Exception('Stripe Gateway: ' . $e->getMessage());
        }
    }

    public function getValidationRules()
    {
        $rules = [
            'card_name'    => ['required'],
            'token'  => ['required'],
        ];
        return $rules;
    }

    public function getValidationMessages()
    {
        return  [
            'card_name.required'    => __('Card Name is required field'),
            'token.required'  => __('Card invalid!'),
        ];
    }

    public function getGateway()
    {
        $this->gateway = Omnipay::create('Stripe');
        $this->gateway->setApiKey($this->getOption('stripe_secret_key'));
        if ($this->getOption('stripe_enable_sandbox')) {
            $this->gateway->setApiKey($this->getOption('stripe_test_secret_key'));
        }
    }

    public function handlePurchaseData($data, \Modules\Order\Models\Payment $payment)
    {
        $request = request();
        $data['currency'] = setting_item('currency_main');
        if(is_api()){
            $cardData = array(
                'lastName'     => $request->input("card_name"),
                'number'       => $request->input("card_number"),
                'expiryMonth'  => $request->input("expiry_month"),
                'expiryYear'   => $request->input("expiry_year"),
                'cvv'          => $request->input("cvv"),
            );
            $data["card"] = $cardData;

        }else{
            $data['token'] = $request->input("token");
        }
        $data['description'] = setting_item("site_title")." - #".$payment->id;
        return $data;
    }

    public function getDisplayHtml()
    {

        $script_inline = "
        var superio_gateways_stripe = {
                stripe_publishable_key:'{$this->getOption('stripe_publishable_key')}',
                stripe_test_publishable_key:'{$this->getOption('stripe_test_publishable_key')}',
                stripe_enable_sandbox:'{$this->getOption('stripe_enable_sandbox')}',
            };";
        Assets::registerJs("https://js.stripe.com/v3/",true);
        Assets::registerJs($script_inline,true,10,false,true);
        Assets::registerJs( asset('module/booking/gateways/stripe.js') ,true);
        $data = [
            'html' => $this->getOption('html', ''),
        ];
        return view("Booking::frontend.gateways.stripe",$data);
    }
    public function getApiDisplayHtml(){
        return "";
    }
    public function getApiOptions()
    {
        return [
            'publishable_key'=>$this->getOption('stripe_enable_sandbox') ? $this->getOption('stripe_test_publishable_key') : $this->getOption('stripe_publishable_key')
        ];
    }

    public function getForm()
    {
        return [
            'card_name'    => [
                'label'=>__('Card Name'),
                'required'=>true,
            ],
            'card_number'  =>[
                'label'=>__('Card Number'),
                'required'=>true,
            ],
            'expiry_month' => [
                'label'=>__('Expiry Month'),
                'required'=>true,
            ],
            'expiry_year'  =>[
                'label'=>__('Expiry Year'),
                'required'=>true,
            ],
            'cvv'          =>[
                'label'=>__('CVV Code'),
                'required'=>true,
            ],
        ];
    }
}
