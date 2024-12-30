<?php

namespace Omnipay\Duitku\Message;

use Omnipay\Duitku\Message\PurchaseResponse;
use Omnipay\Duitku\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    protected $endpoint = 'https://api-sandbox.duitku.com/api/merchant/createInvoice';

    public function getData()
    {
        $this->validate('amount', 'returnUrl');

        $data = [
            'merchantCode' => $this->getMerchantCode(),
            'paymentAmount' => $this->getAmount(),
            'merchantOrderId' => $this->getTransactionId(),
            'productDetails' => $this->getDescription(),
            'email' => $this->getEmail(),
            'returnUrl' => $this->getReturnUrl(),
            'callbackUrl' => $this->getNotifyUrl(),
        ];

        $data['timestamp'] = time();
        $data['signature'] = hash('sha256', $this->getMerchantCode() . $data['timestamp'] . $this->getApiKey());

        return $data;
    }

    public function sendData($data)
    {
        try {

            $httpResponse = $this->httpClient->request('POST', $this->endpoint, [
                'headers' => [
                    'x-duitku-signature' => $data['signature'],
                    'x-duitku-timestamp' => $data['timestamp'],
                    'x-duitku-merchantcode' => $this->getMerchantCode(),
                    'Content-Type' => "application/json",
                    'Accept' => "application/json"
                    ]
                ], json_encode($data));
            } catch (ClientException $e) {
                if ($e->getResponse()->getStatusCode() == 404) {
                    $responseBody = $e->getResponse()->getBody()->getContents();
                    // Process the 404 response body here
                    echo "404 Error: " . $responseBody;
                }
            }
        bdump($httpResponse);

        $responseData = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new PurchaseResponse($this, $responseData);
    }

}