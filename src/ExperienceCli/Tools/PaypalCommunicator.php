<?php

namespace PayPal\ExperienceCli\Tools;

use PayPal\ExperienceCli\Container\Config;

class PaypalCommunicator {
    /**
     * @param Config $config
     * @param \PayPal\Api\WebProfile $webProfile
     * @return bool|string  False if something goes wrong.  Otherwise, the web profile id of the created profile.
     */
    public static function CreateExperienceProfile(Config $config, \PayPal\Api\WebProfile $webProfile) {
        try {
            $apiContext = self::getApiContext($config);

            $response = $webProfile->create($apiContext);
        }
        catch (\Exception $ex) {
            return false;
        }

        return $response->getId();
    }

    /**
     * @param Config $config
     * @return bool|\PayPal\Api\WebProfile[]    False if something goes wrong.  Otherwise, the profiles (NOTE: could be
     * empty if there are not profiles).
     */
    public static function ListExperienceProfiles(Config $config) {
        try {
            $apiContext = self::getApiContext($config);

            $profiles = \PayPal\Api\WebProfile::get_list($apiContext);
        }
        catch (\Exception $ex) {
            return false;
        }

        return $profiles;
    }

    /**
     * @param Config $config
     * @param \PayPal\Api\WebProfile $webProfile
     * @param $experienceProfileId
     * @return bool
     */
    public static function UpdateExperienceProfile(Config $config, \PayPal\Api\WebProfile $webProfile, $experienceProfileId) {
        // set the id
        $webProfile->setId($experienceProfileId);

        // try to update
        try {
            $apiContext = self::getApiContext($config);

            $updated = $webProfile->update($apiContext);;
        }
        catch (\Exception $ex) {
            return false;
        }

        if($updated) return true;
        else return false;
    }

    public static function DeleteExperienceProfile(Config $config, $experienceProfileId) {

    }

    private static function getApiContext(Config $config) {
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
