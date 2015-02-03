<?php

namespace Paypal\ExperienceCli\Tools;

use Paypal\ExperienceCli\Profile;

class WebProfileBuilder {
    /**
     * @param $profile Profile
     * @return \PayPal\Api\WebProfile
     */
    public static function ConstructWebProfile(Profile $profile) {
        $flowConfig = new \PayPal\Api\FlowConfig();
        $flowConfig->setLandingPageType($profile->GetLandingPageType());

        $presentation = new \PayPal\Api\Presentation();
        $presentation->setLocaleCode($profile->GetLocale());

        $logoUrl = $profile->GetLogoUrl();
        if($logoUrl) $presentation->setLogoImage($logoUrl);

        $businessName = $profile->GetBusinessName();
        if($businessName) $presentation->setBrandName($businessName);

        $inputFields = new \PayPal\Api\InputFields();
        $inputFields
                ->setAllowNote($profile->GetAllowNote())
                ->setNoShipping($profile->GetNoShipping())
                ->setAddressOverride($profile->GetAddressOverride());

        $webProfile = new \PayPal\Api\WebProfile();
        $webProfile
                ->setName($profile->GetProfileName())
                ->setFlowConfig($flowConfig)
                ->setPresentation($presentation)
                ->setInputFields($inputFields);

        return $webProfile;
    }
}