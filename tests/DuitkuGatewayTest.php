<?php

namespace Omnipay\Duitku\Test;

use Omnipay\Duitku\DuitkuGateway;
use Omnipay\Tests\GatewayTestCase;

class DuitkuGatewayTest extends GatewayTestCase
{
    protected $gateway;

    public function setUp(): void
    {
        parent::setUp();
        $this->gateway = new DuitkuGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'amount' => '10.00',
            'transactionId' => '123',
            'returnUrl' => 'https://example.com/return',
        ]);

        $this->assertInstanceOf('Omnipay\Duitku\Message\PurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }

    public function testCompletePurchase()
    {
        $request = $this->gateway->completePurchase([
            'amount' => '10.00',
            'transactionId' => '123',
        ]);

        $this->assertInstanceOf('Omnipay\Duitku\Message\CompletePurchaseRequest', $request);
        $this->assertSame('10.00', $request->getAmount());
    }
}