<?php

use AmazonIntegration\AmazonIntegration;

/**
 * **********************************************************************
 * REQUIRED
 *
 * All AWS requests must contain the AWSAccessKeyId, AssociateTag, $secretAccessKey
 *
 * *********************************************************************
 */
define('PRODUCT_ADVERTISING_AWS_ACCESS_KEY_ID', AmazonIntegration::getConfigValue('PRODUCT_ADVERTISING_AWS_ACCESS_KEY_ID'));
define('PRODUCT_ADVERTISING_AWS_SECRET_ACCESS_KEY', AmazonIntegration::getConfigValue('PRODUCT_ADVERTISING_AWS_SECRET_ACCESS_KEY'));
define('PRODUCT_ADVERTISING_AWS_ASSOCIATE_TAG', AmazonIntegration::getConfigValue('PRODUCT_ADVERTISING_AWS_ASSOCIATE_TAG'));
define('PRODUCT_ADVERTISING_AWS_MARKETPLACE', AmazonIntegration::getConfigValue('PRODUCT_ADVERTISING_AWS_MARKETPLACE'));
