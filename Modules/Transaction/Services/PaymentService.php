<?php

namespace Modules\Transaction\Services;

use Illuminate\Support\Facades\Hash;

class PaymentService
{
    /*
     * Test CREDENTIALS
     */
    const MERCHANT_ID = "1201";
    const USERNAME = "test";
    const PASSWORD = "test";
    const API_KEY = "jtest123";

    protected $paymentMode = 'test_mode';
    protected $test_mode = 1;
    protected $whitelabled = true;
    protected $paymentUrl = "https://api.upayments.com/test-payment";
    protected $apiKey = '';
    protected $charges = 0.350;
    protected $cc_charges = 2.7;

    public function __construct()
    {

        if (setting('payment_gateway', 'upayment.payment_mode') == 'live_mode') {
            $this->paymentMode = 'live_mode';
            $this->test_mode = false;
            $this->whitelabled = false;
            $this->paymentUrl = "https://api.upayments.com/payment-request";
            $this->apiKey = password_hash(config('setting.payment_gateway.upayment.' . $this->paymentMode . '.API_KEY') ?? self::API_KEY, PASSWORD_BCRYPT);
        } else {
            $this->apiKey = setting('payment_gateway', 'upayment.' . $this->paymentMode . '.API_KEY') ?? self::API_KEY;
        }

        $this->charges = setting("payment_gateway.upayment.{$this->paymentMode}.charges", $this->charges);
        $this->cc_charges = setting("payment_gateway.upayment.{$this->paymentMode}.cc_charges", $this->cc_charges);
    }

    public function send($order, $type = 'order', $payment,$price = null)
    {
        if (auth()->check()) {
            $user = [
                'name' => auth()->user()->name ?? '',
                'email' => auth()->user()->email ?? '',
                'mobile' => auth()->user()->calling_code ?? '' . auth()->user()->mobile ?? '',
            ];
        } else {
            $user = [
                'name' => 'Guest User',
                'email' => 'test@test.com',
                'mobile' => '12345678',
            ];
        }

        $extraMerchantsData = array();
        $extraMerchantsData['amounts'][0] =  $price ?? $order['price'];
        $extraMerchantsData['charges'][0] = $this->charges;
        $extraMerchantsData['chargeType'][0] = 'fixed'; // or 'percentage'
        $extraMerchantsData['cc_charges'][0] = $this->cc_charges; // or 'percentage'
        $extraMerchantsData['cc_chargeType'][0] = 'percentage'; // or 'percentage'
        $extraMerchantsData['ibans'][0] = setting('payment_gateway', 'upayment.' . $this->paymentMode . '.IBAN') ?? '';

        $url = $this->paymentUrls();

        $fields = [
            'api_key' => $this->apiKey,
            'merchant_id' => setting('payment_gateway', 'upayment.' . $this->paymentMode . '.MERCHANT_ID') ?? self::MERCHANT_ID,
            'username' => setting('payment_gateway', 'upayment.' . $this->paymentMode . '.USERNAME') ?? self::USERNAME,
            'password' => stripslashes(setting('payment_gateway', 'upayment.' . $this->paymentMode . '.PASSWORD') ?? self::PASSWORD),
            'order_id' => $order['id'],
            'CurrencyCode' => 'KWD',
            'CstFName' => $user['name'],
            'CstEmail' => $user['email'],
            'CstMobile' => $user['mobile'],
            'success_url' => $url['success'],
            'error_url' => $url['failed'],
            'ExtraMerchantsData' => json_encode($extraMerchantsData),
            'test_mode' => $this->test_mode, // 1 == test mode enabled
            'whitelabled' => $this->whitelabled, // false == in live mode
            'payment_gateway' => $payment, // knet / cc
            'reference' => $order['id'],
            'notifyURL' => route('frontend.subscriptions.notify'),
            'total_price' => $this->test_mode ?  ($price ?? $order['price']) : ($price ?? $order['price']), true, false,
        ];

        $fields_string = http_build_query($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->paymentUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $server_output = json_decode($server_output, true);


        return $server_output['paymentURL'];
    }


    public function paymentUrls()
    {
        $url['success'] = route('frontend.subscriptions.success');
        $url['failed'] = route('frontend.subscriptions.failed');
        return $url;
    }
}
