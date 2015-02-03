<?php

namespace Paypal\ExperienceCli\Container;

class Config {
    public $ClientId;
    public $ClientSecret;
    public $EndpointMode;

    public function __construct($clientId, $clientSecret, $endpointMode) {
        $this->ClientId = $clientId;
        $this->ClientSecret = $clientSecret;
        $this->EndpointMode = $endpointMode;
    }
}