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
            'paymentAmount' => $this->getParameter('amount'),
            'merchantOrderId' => $this->getParameter('orderId'),
            'productDetails' => $this->getParameter('description'),
            'email' => $this->getParameter('email'),
            'returnUrl' => $this->getReturnUrl(),
            'callbackUrl' => $this->getNotifyUrl(),
        ];

        $data['timestamp'] = time();
        $data['signature'] = hash('sha256', $this->getMerchantCode() . $data['timestamp'] . $this->getApiKey());

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
        bdump($this);
        bdump([
            'x-duitku-signature' => $data['signature'],
            'x-duitku-timestamp' => $data['timestamp'],
            'x-duitku-merchantcode' => $this->getMerchantCode()
        ]);
        $responseData = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new PurchaseResponse($this, $responseData);
    }

}