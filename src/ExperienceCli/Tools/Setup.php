<?php

namespace Paypal\ExperienceCli\Tools;

use Paypal\ExperienceCli\Container\Config;

class Setup {
    /**
     * Does the following:
     * - Includes the composer autoloader
     */
    public static function DoSetup() {
        /*
         * Include the autoloader
         */

        $autoloadPaths = array(
            __DIR__ . "/../../../../autoload.php", // likely location, if installed as a vendor package
            __DIR__ . "/../../../vendor/autoload.php", // dev location
        );


        foreach($autoloadPaths as $path) {
            if(file_exists($path)) {
                require($path);
                break;
            }
        }

        // if we didn't find the autoloader, your autoloader is in a stupid place, and you're on your own
    }

    /**
     * Loads the following environment variables, from the .env file in the current working directory (getcwd), and
     * puts them in a Config container.
     * - PAYPAL_CLIENT_ID
     * - PAYPAL_CLIENT_SECRET
     * - PAYPAL_ENDPOINT_MODE
     *
     * @return Config
     */
    public static function GetConfig() {
        /*
         * Load environment variables
         */

        \Dotenv::load(getcwd());

        /*
         * Make sure required environment variables are set
         */

        \Dotenv::required(array("PAYPAL_CLIENT_ID", "PAYPAL_CLIENT_SECRET", "PAYPAL_ENDPOINT_MODE", "PAYPAL_EXPERIENCE_CLI_PROFILES_DIR"));

        /*
         * Create a config object and return it
         */

        $config = new Config(getenv("PAYPAL_CLIENT_ID"), getenv("PAYPAL_CLIENT_SECRET"), getenv("PAYPAL_ENDPOINT_MODE"), getenv("PAYPAL_EXPERIENCE_CLI_PROFILES_DIR"));

        // make sure the profiles directory is valid
        if(!$config->GetProfilesDirAbsolute()) {
            die("ERROR / Could not find profiles directory.\n");
        }

        return $config;
    }
}