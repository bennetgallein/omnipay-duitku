<?php
namespace Omnipay\Duitku\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest {
 
  public function getApiKey()
  {
      return $this->getParameter('apiKey');
  }
  
  public function getMerchantCode() {
    return $this->getParameter('merchantCode');
  }
}