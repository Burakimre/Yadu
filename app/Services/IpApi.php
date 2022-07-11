<?php
namespace App\Services;

class IpApi{

    public $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

}