# Paypal Experience CLI

A set of command-line tools for managing "web experience profiles" in Paypal.

If Paypal's new PHP API

## Install

```
curl -s http://getcomposer.org/installer | php
php composer.phar require cullylarson/paypal-experience-cli
```

## Configuration

Configuration is done using a `.env` file (https://github.com/vlucas/phpdotenv).  An example file is provided, named `.env.dist`.  You can just copy it and set appropriately.  The `.env` file needs to be in the directory from which you are going to run commands.

## Profiles

You'll need to create some `Profile` classes.  These define the experience profile you'd like to create in Paypal.  They must extend `\PayPal\ExperienceCli\Profile`, and must at least implement the `GetProfileName` function.  There are a couple examples in the `sample-profiles` directory.

Create a directory for your profiles, and put them in there.  Then set `PAYPAL_EXPERIENCE_CLI_PROFILES_DIR` in your `.env` file to this directory.

A few of the commands ask for a profile name.  This is the class name of your profile, without the namespace (though, a namespace can be provided as another argument).  It also needs to be the name of the PHP file that contains the class (without the `.php` extension).  For example, if you put your profiles in a directory named `profiles`, and you created a profile class named `MyFirstProfile`, then that class needs to be defined in the `profiles/MyFirstProfile.php` file.

## Commands

### create-experience-profile

## Example

### 1. Create a directory for your profiles

```
> mkdir profiles
```

### 2. Set the directory in your `.env` file

```
PAYPAL_EXPERIENCE_CLI_PROFILES_DIR="profiles"
```

### 3. Create a `MyFirstProfile.php` file in your profiles directory

```
> touch profiles/MyFirstProfile.php
```

### 4. Edit your `MyFirstProfile.php` file

```
<?php

namespace My\Preferred\Namespace; // not necessary to namespace your profiles

use PayPal\ExperienceCli\Profile;

class MyFirstProfile extends Profile {
    public function GetProfileName() { return "This Needs to be Unique"; }
    public function GetBrandName() { return "My Business"; }
    public function GetLogoUrl() { return "https://www.google.com/images/srpr/logo11w.png"; }
}
```

### 5. Create this experience profile in Paypal

```
> php ./vendor/bin/create-experience-profile MyFirstProfile "\\My\\Preferred\\Namespace"
```

### 6. List the experience profiles you have in Paypal, to see your new profile

```
> php ./vendor/bin/list-experience-profiles
```

### 7. Update your profile, by first editing your `profiles/MyFirstProfile.php` file and making some changes

```
<?php

// no more namespace

use PayPal\ExperienceCli\Profile;

class MyFirstProfile extends Profile {
    public function GetProfileName() { return "This Needs to be Unique"; }
    public function GetBrandName() { return "My Better Business Name"; }
    // no more logo
}
```

### 8. Now run the update command.  It will pull the changes from your `MyFirstProfile` class and send them to Paypal.

```
> php ./vendor/bin/update-experience-profile THE-EXPERIENCE-PROFILE-ID-FROM-LIST MyFirstProfile
```

### 9. Remove the profile from Paypal.

```
> php ./vendor/bin/remove-experience-profile THE-EXPERIENCE-PROFILE-ID-FROM-LIST
```