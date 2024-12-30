<?php

namespace Omnipay\Duitku\Test\Message;

use Omnipay\Duitku\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    public function testGetData()
    {
        $request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize([
            'amount' => '10.00',
            'transactionId' => '123',
            'returnUrl' => 'https://example.com/return',
            'merchantCode' => 'MERCHANT123',
            'apiKey' => 'secret',
        ]);

        $data = $request->getData();

        $this->assertSame('10.00', $data['paymentAmount']);
        $this->assertSame('123', $data['merchantOrderId']);
        $this->assertSame('https://example.com/return', $data['returnUrl']);
        $this->assertSame('MERCHANT123', $data['merchantCode']);
        $this->assertArrayHasKey('signature', $data);
    }
}