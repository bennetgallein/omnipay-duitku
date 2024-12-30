<?php

namespace Omnipay\Duitku\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return isset($this->data['statusCode']) && $this->data['statusCode'] === '00';
    }

    public function isRedirect()
    {
        return $this->isSuccessful() && isset($this->data['paymentUrl']);
    }

    public function getRedirectUrl()
    {
        return $this->data['paymentUrl'] ?? null;
    }

    public function getTransactionReference()
    {
        return $this->data['reference'] ?? null;
    }
}