<?php

namespace PayPal\ExperienceCli\Container;

class Config {
    public $ClientId;
    public $ClientSecret;
    public $EndpointMode;
    public $ProfilesDir;
    public $EnableLog;
    public $LogFilename;

    private $profilesDirAbsolute;

    public function __construct($clientId, $clientSecret, $endpointMode, $profilesDir, $enableLog=0, $logFilename=null) {
        $this->ClientId = $clientId;
        $this->ClientSecret = $clientSecret;
        $this->EndpointMode = $endpointMode;
        $this->ProfilesDir = $profilesDir;
        $this->SetEnableLog($enableLog);
        $this->SetLogFilename($logFilename);
    }

    public function SetEnableLog($enableLog) {
        $enableLog = empty($enableLog) ? 0 : 1;
        $this->EnableLog = $enableLog;
    }

    public function SetLogFilename($logFilename) {
        $logFilename = empty($logFilename) ? null : $logFilename;
        $this->LogFilename = $logFilename;
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
