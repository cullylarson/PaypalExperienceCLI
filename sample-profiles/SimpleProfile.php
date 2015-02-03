<?php

namespace CullyTest;

use PayPal\ExperienceCli\Profile;

class SimpleProfile extends Profile {
    public function GetProfileName() { return "A Simple & Unique Profile Name"; }
    public function GetBrandName() { return "A Super Simple Business"; }
    public function GetLogoUrl() { return "https://www.google.com/images/srpr/logo11w.png"; }
}