<?php

namespace Omnipay\Duitku\Message;

use Omnipay\Duitku\Message\PurchaseResponse;
use Omnipay\Duitku\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{
    protected $endpoint = '/api/merchant/createInvoice';

    public function getData()
    {
        $this->validate('amount', 'returnUrl');

        $data = [
            'merchantCode' => $this->getMerchantCode(),
            'paymentAmount' => (int) $this->getAmount(),
            'merchantOrderId' => $this->getTransactionId(),
            'productDetails' => $this->getDescription(),
            'email' => $this->getEmail(),
            'returnUrl' => $this->getReturnUrl(),
            'callbackUrl' => $this->getNotifyUrl(),
        ];

        $data['timestamp'] = $this->getTimestamp();
        $data['signature'] = hash('sha256', $this->getMerchantCode() . $data['timestamp'] . $this->getApiKey());

        return $data;
    }

    public function sendData($data) {
        $httpResponse = $this->httpClient->request('POST', $this->getBaseUrl() . $this->endpoint, [
                'x-duitku-signature' => $data['signature'],
                'x-duitku-timestamp' => $data['timestamp'],
                'x-duitku-merchantcode' => $this->getMerchantCode(),
                'Content-Type' => "application/json",
                'Accept' => "application/json"
            ], json_encode($data)
        );

        $responseData = json_decode($httpResponse->getBody()->getContents(), true);

        return $this->response = new PurchaseResponse($this, $responseData);
    }

}