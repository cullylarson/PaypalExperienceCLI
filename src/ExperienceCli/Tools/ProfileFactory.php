<?php

namespace PayPal\ExperienceCli\Tools;

use PayPal\ExperienceCli\Profile;

class ProfileFactory {
    /**
     * @param string $profilesDirectory
     * @param string $profileName
     * @param string|null $profileNamespace
     * @return Profile|null
     */
    public static function ConstructProfileFromName($profilesDirectory, $profileName, $profileNamespace=null) {
        // make sure the profile name doesn't contain any path info
        $profileName = basename($profileName);

        // path to php file containing the profile class
        $profilePath = "{$profilesDirectory}/{$profileName}.php";

        // make sure the profile file exists
        if( !file_exists($profilePath)) return null;

        // include it
        require($profilePath);

        // add namespace if provided
        $namespacedProfileName = $profileName;
        if( $profileNamespace ) $namespacedProfileName = "{$profileNamespace}\\{$namespacedProfileName}";

        // make sure the class exists
        if( !class_exists($namespacedProfileName) ) return null;

        // instantiate
        $profile = new $namespacedProfileName();

        if( !($profile instanceof Profile) ) return null;
        else return $profile;
    }
}
