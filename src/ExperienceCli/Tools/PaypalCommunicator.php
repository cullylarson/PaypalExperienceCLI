<?php

namespace PayPal\ExperienceCli\Tools;

use PayPal\ExperienceCli\Container\Config;

class PaypalCommunicator {
    /**
     * @param Config $config
     * @param \PayPal\Api\WebProfile $webProfile
     * @return bool|string  False if something goes wrong.  Otherwise, the web profile id of the created profile.
     */
    public static function CreateWebProfile(Config $config, \PayPal\Api\WebProfile $webProfile) {
        try {
            $apiContext = self::createApiContext($config);

            $response = $webProfile->create($apiContext);
        }
        catch (\Exception $ex) {
            return false;
        }

        return $response->getId();
    }

    private static function createApiContext(Config $config) {
        /*
         * Set up the context configuration
         */

        $contextConfig = array(
            'mode' => $config->EndpointMode,
            'log.LogEnabled' => false,
        );

        // if logs are enable
        if($config->EnableLog) {
            $contextConfig['log.LogEnabled'] = true;
            $contextConfig['log.FileName'] = $config->LogFilename;
            $contextConfig['log.LogLevel'] = "FINE";
            $contextConfig['validation.level'] = "log";
        }

        /*
         * Build the context object and return it
         */

        $apiContext = new \PayPal\Rest\ApiContext(new \PayPal\Auth\OAuthTokenCredential($config->ClientId, $config->ClientSecret));
        $apiContext->setConfig($contextConfig);

        return $apiContext;
    }
}
