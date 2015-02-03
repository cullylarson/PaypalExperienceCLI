<?php

namespace Paypal\ExperienceCli\Container;

class Config {
    public $ClientId;
    public $ClientSecret;
    public $EndpointMode;
    public $ProfilesDir;

    private $profilesDirAbsolute;

    public function __construct($clientId, $clientSecret, $endpointMode, $profilesDir) {
        $this->ClientId = $clientId;
        $this->ClientSecret = $clientSecret;
        $this->EndpointMode = $endpointMode;
        $this->ProfilesDir = $profilesDir;
    }

    public function GetProfilesDirAbsolute() {
        // We've already found it!
        if($this->profilesDirAbsolute) return $this->profilesDirAbsolute;

        /*
         * Otherwise, try to find it
         */

        $profilesDirOptions = array(
            $this->ProfilesDir,
            getcwd() . "/{$this->ProfilesDir}",
        );

        foreach($profilesDirOptions as $profilesDir) {
            // Found it!
            if( is_dir($profilesDir) ) {
                $this->profilesDirAbsolute = realpath($profilesDir);
                return $this->profilesDirAbsolute;
            }
        }

        // Couldn't find it :(
        return null;
    }
}