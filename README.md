# Paypal Experience CLI

A set of command-line tools for managing "web experience profiles" in Paypal.

PayPal now allows you to customize the payment experience your customers have, when they go to PayPal to make a payment (what used to be called Express Checkout).  To do this, you need to create web experience profiles in PayPal, using their new REST API.  It's stupid. I don't know why they don't just let you do that in your Developer Dashboard, but it's the way it is.  This is a simple command line tool that allows you to Create, List, Update, and Remove experience profiles. I hope it saves some of you the headache of having to implement something yourself.

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

Create a web experience profile in PayPal.

#### USAGE

```
> php ./vendor/bin/create-experience-profile PROFILE_CLASS_NAME [PROFILE_NAMESPACE]
```
#### ARGUMENTS

- **PROFILE_CLASS_NAME** *(required)* -- The name of your class (e.g. MyFirstProfile).  Don't include the .php extension.
- **PROFILE_NAMESPACE** *(optional)* -- If your profile class has namespace, provided it here (e.g. "\\My\\Favorite\\Namespace").  Don't include a final `\` (it won't work).


### list-experience-profiles

List all of the web experience profiles you have in PayPal.

#### USAGE

```
> php ./vendor/bin/list-experience-profiles
```

### update-experience-profile

Update a web experience profile in PayPal.  You can do this by first editing the `Profile` class you originally used to create this experience profile, or you can create a new class and just pass it as an argument.  Basically any changes to the class will be sent to PayPal.

#### USAGE

```
> php ./vendor/bin/update-experience-profile EXPERIENCE_PROFILE_ID PROFILE_CLASS_NAME [PROFILE_NAMESPACE]
```
#### ARGUMENTS

- **EXPERIENCE_PROFILE_ID** *(required)* -- The web experience profile ID of the profile you'd like to modify.  You can get this by listing your profiles.
- **PROFILE_CLASS_NAME** *(required)* -- The name of your class (e.g. MyFirstProfile).  Don't include the .php extension.  Info from this class will be used to update your experience profile in PayPal.
- **PROFILE_NAMESPACE** *(optional)* -- If your profile class has namespace, provided it here (e.g. "\\My\\Favorite\\Namespace").  Don't include a final `\` (it won't work).


### remove-experience-profile

Remove a web experience profile from PayPal.

#### USAGE

```
> php ./vendor/bin/remove-experience-profile EXPERIENCE_PROFILE_ID
```
#### ARGUMENTS

- **EXPERIENCE_PROFILE_ID** *(required)* -- The web experience profile ID of the profile you'd like to remove.  You can get this by listing your profiles.


## Example of Everything

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