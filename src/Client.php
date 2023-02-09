<?php

namespace SoerBV\Api
  
class Client
{
  
  protected string $authCode;
  protected string $requestId;
  
  public function __construct(string $authCode, string $requestId)
  {
    $this->authCode = $authcode;
    $this->requestId = $requestId
  }
  
}
