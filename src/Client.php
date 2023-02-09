<?php

namespace SoerBV\Api
  
class Client
{
  protected string $host;
  protected string $apiKey;
  
  public function __construct(string $host, string $apiKey)
  {
    $this->host = $host;
    $this->apiKey = $apiKey;
  }
  
}
