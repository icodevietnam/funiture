<?php

use Nova\Config\Config;


/**
 * Setup the Google reCAPTCHA configuration
 */
Config::set('recaptcha', array(
    'active'  => false,
    'siteKey' => '',
    'secret'  => '',
));
