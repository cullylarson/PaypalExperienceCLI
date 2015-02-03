<?php

use PayPal\ExperienceCli\Profile;

class ComplexProfile extends Profile {
    public function GetProfileName() { return "More Trouble Than It's Worth"; }
    public function GetBrandName() { return "Buy My Stuff, I'm Really Trying"; }
    public function GetLogoUrl() { return "https://www.google.com/images/srpr/logo11w.png"; }
    public function GetLandingPageType() { return "Billing"; }
    public function GetAllowNote() { return true; }
    public function GetNoShipping() { return 0; }
    public function GetAddressOverride() { return 1; }
}