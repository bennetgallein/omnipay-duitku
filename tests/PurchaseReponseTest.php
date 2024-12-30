<?php

namespace Omnipay\Duitku\Test\Message;

use Omnipay\Duitku\Message\PurchaseResponse;
use Omnipay\Tests\TestCase;

class PurchaseResponseTest extends TestCase
{
    public function testPurchaseSuccess()
    {
        $response = new PurchaseResponse($this->getMockRequest(), [
            'statusCode' => '00',
            'paymentUrl' => 'https://duitku.com/payment',
            'reference' => 'REF123',
        ]);

        $this->assertTrue($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertSame('https://duitku.com/payment', $response->getRedirectUrl());
        $this->assertSame('REF123', $response->getTransactionReference());
    }

    public function testPurchaseFailure()
    {
        $response = new PurchaseResponse($this->getMockRequest(), [
            'statusCode' => '01',
            'statusMessage' => 'Failed',
        ]);

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('Failed', $response->getMessage());
    }
}