<?php

namespace PayPal\ExperienceCli;

abstract class Profile {
    /**
     * A unique name for this profile.
     *
     * @return string
     */
    abstract public function GetProfileName();

    public function GetLogoUrl() { return null; }

    /**
     * If set (not null), this will override the business name in the PayPal account on the PayPal pages.
     *
     * @return string|null
     */
    public function GetBusinessName() { return null; }

    /**
     * @return string
     */
    public function GetLocale() { return "US"; }

    /**
     * Must return "Billing" or "Login". When set to Billing, the Non-PayPal account landing page is used. When set to
     * Login, the PayPal account login landing page is used.
     *
     * @return string
     */
    public function GetLandingPageType() { return "Login"; }

    /**
     * Whether to let the customer add a note when making a payment.
     *
     * @return bool
     */
    public function GetAllowNote() { return false; }

    /**
     * Allowed values: 0, 1, or 2. When set to 0, PayPal displays the shipping address on the PayPal pages. When set
     * to 1, PayPal does not display shipping address fields whatsoever. When set to 2, if you do not pass the shipping
     * address, PayPal obtains it from the buyer’s account profile. For digital goods, this field is required, and you
     * must set it to 1.
     *
     * @return int
     */
    public function GetNoShipping() { return 1; }

    /**
     * Determines if the PayPal pages should display the shipping address supplied in this call, rather than the
     * shipping address on file with PayPal for this buyer. Displaying the address on file does not allow the buyer to
     * edit the address. Allowed values: 0 or 1. When set to 0, the PayPal pages should display the address on file.
     * When set to 1, the PayPal pages should display the addresses supplied in this call instead of the address from
     * the buyer's PayPal account.
     *
     * @return int
     */
    public function GetAddressOverride() { return 0; }
}
