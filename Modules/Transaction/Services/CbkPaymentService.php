<?php
namespace Modules\Transaction\Services;

class CbkPaymentService
{
    protected $paymentMode;
    protected $paymentUrl;
    protected $apiKey;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $config_path = 'services.payment_gateway.cbk_payment.' . config('services.payment_gateway.cbk_payment.payment_mode');
        $this->paymentUrl = config($config_path . '.PAYMENT_URL') ?? '';
        $this->apiKey = config($config_path . '.ENCRP_KEY') ?? '';
        $this->clientId = config($config_path . '.CLIENT_ID') ?? '';
        $this->clientSecret = config($config_path . '.CLIENT_SECRET') ?? '';
    }

    public function send($order, $type = 'order', $payment,$price = null)
    // public function send($order, $pay_id, $payment = 'online', $requestType = '')
    {
        $accessToken = $this->generateAccessToken();

        info('paymentUrl : ' . $this->paymentUrl);
        info('****************************************');
        info('clientId : ' . $this->clientId);
        info('clientSecret : ' . $this->clientSecret);
        info('tij_MerchAuthKeyApi : ' . $accessToken);
        info('****************************************');
        info('tij_MerchantEncryptCode : ' . $this->apiKey);
        info('****************************************');
        if ($accessToken == '')
            return 'failed_to_generate_access_token';

        if (!empty($accessToken)) {

            $payment_url = null;

            // try {
                $client = new \GuzzleHttp\Client([
                    'base_uri' => $this->paymentUrl,
                    'allow_redirects' => true,
                    'cookies' => true,
                ]);

                $res = $client->request('POST', '/epay/pg/epay?_v=' . $accessToken, [
                    'on_stats' => function (\GuzzleHttp\TransferStats $stats) use (&$payment_url) {
                        $payment_url = $stats->getEffectiveUri();
                    },
                    'form_params' => [
                        'tij_MerchantEncryptCode' => $this->apiKey,
                        'tij_MerchAuthKeyApi' => $accessToken,
                        'tij_MerchantPaymentLang' => 'en',
                        'tij_MerchantPaymentAmount' => $price ?? $order['price'],
                        'tij_MerchantPaymentTrack' => $order['id'],
                        'tij_MerchantPaymentRef' => 'description',
                        'tij_MerchantPaymentCurrency' => 'KWD',
                        'tij_MerchantUdf1' => $order['id'],
                        'tij_MerchantUdf2' => auth()->check() ? auth()->id() : null,
                        'tij_MerchantUdf3' => '',
                        'tij_MerchantUdf4' => '',
                        'tij_MerchantUdf5' => '',
                        'tij_MerchPayType' => '1',
                        "tij_MerchReturnUrl" => url(route('frontend.subscriptions.notify')),
                    ]
                ]);

                logger("res :");
                logger($res->getBody());
                logger('****************************************');

            // } catch (\Exception $e) {
            //     // handle error response here...
            //     logger('Payment:msg::');
            //     logger($e->getMessage());
            // }

            info($payment_url);
            return (string)$payment_url;
        }
    }

    public function generateAccessToken()
    {
        $url = $this->paymentUrl . '/ePay/api/cbk/online/pg/merchant/Authenticate';
        $postRequest = [
            "ClientId" => $this->clientId,
            "ClientSecret" => $this->clientSecret,
            "ENCRP_KEY" => $this->apiKey
        ];
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postRequest));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);
        $err_in = curl_error($curl);
        $info = htmlspecialchars(curl_exec($curl));
        curl_close($curl);
        $json = json_decode($result, true);

        logger('AccessToken::');
        logger($json);

        if (!is_null($json) && $json['Status'] == '1')
            $accessToken = $json['AccessToken'] ?? '';
        else
            $accessToken = '';

        return $accessToken;
    }

    public function verifyPayment($encrp)
    {
        $accessToken = $this->generateAccessToken();
        $url = $this->paymentUrl . '/ePay/api/cbk/online/pg/GetTransactions/' . $encrp . '/' . $accessToken;
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);
        $err_in = curl_error($curl);
        $info = htmlspecialchars(curl_exec($curl));
        curl_close($curl);
        $json = json_decode($result, true);

        logger('verifyPayment::');
        logger($json);

        return $json;
    }

}
