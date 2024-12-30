<?php

namespace Omnipay\Duitku\Message;

use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    protected $endpoint = 'https://sandbox.duitku.com/webapi/api/merchant/v2/inquiry';

    public function getData()
    {
        $this->validate('amount', 'returnUrl');

        $data = [
            'merchantCode' => $this->getParameter('merchantCode'),
            'paymentAmount' => $this->getParameter('amount'),
            'merchantOrderId' => $this->getTransactionId(),
            'productDetails' => $this->getDescription(),
            'email' => $this->getParameter('email'),
            'returnUrl' => $this->getReturnUrl(),
            'callbackUrl' => $this->getNotifyUrl(),
        ];

        $data['timestamp'] = time();
        $data['signature'] = hash('sha256', $this->getParameter('merchantCode') . $data['timestamp'] . $this->getParameter('apiKey'));

        return $data;
    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->request('POST', $this->endpoint, [
            'headers' => [
                'x-duitku-signature' => $data['signature'],
                'x-duitku-timestamp' => $data['timestamp'],
                'x-duitku-merchantcode' => $this->getMerchantCode()
            ]
        ], json_encode($data));
        $responseData = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new PurchaseResponse($this, $responseData);
    }

    // Add getter and setter methods for merchantCode and apiKey
}