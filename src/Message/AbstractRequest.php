<?php
namespace Omnipay\Duitku\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {
 
  public function getBaseUrl() {
    return $this->getParameter('sandbox') ? 'https://api-sandbox.duitku.com' : 'https://api-prod.duitku.com';
  }

  public function getApiKey() {
      return $this->getParameter('apiKey');
  }

  public function setApiKey($v) {
    return $this->setParameter('apiKey', $v);
}
  
  public function getMerchantCode() {
    return $this->getParameter('merchantCode');
  }

  public function setMerchantCode($v) {
    return $this->setParameter('merchantCode', $v);
  }

  public function setEmail($v) {
    return $this->setParameter('email', $v);
  }

  public function getEmail() {
    return $this->getParameter('email');
  }

  public function getTimestamp() {
    $dateTime = new \DateTime('now');// new \DateTimeZone('Asia/Jakarta'));
    $timestampSeconds = $dateTime->getTimestamp();
    $timestampMilliseconds = $timestampSeconds * 1000;

    // Add microseconds
    $microseconds = $dateTime->format("u");
    $timestampMilliseconds += $microseconds / 1000;
    return (int) $timestampMilliseconds;
  }
}