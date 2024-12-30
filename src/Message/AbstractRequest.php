<?php
namespace Omnipay\Duitku\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {
 
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
}