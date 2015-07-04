<?php

define('SIMPLESAML_PATH',  dirname( __FILE__ ) .  '/../IntuitInterface/simplesamlphp');
define('SIMPLEOAUTH_PATH', dirname( __FILE__ ) .  '/../IntuitInterface');

define('OAUTH_CONSUMER_KEY', 'qyprdgNUv7w8gCw5UW4wG7RVTF2DBi' );
define('OAUTH_SHARED_SECRET', 'jbCyB8jYjQqC1q00hsGyKzzi60CiZ74dWHoxaAj7' );

define('SAML_IDENTITY_PROVIDER_ID', 'privpassagg.185394.cc.dev-intuit.ipp.prod' );
define('SAML_X509_CERT_PATH',        dirname( __FILE__ ) . '/www.john2enterprises.com.crt');
define('SAML_X509_PRIVATE_KEY_PATH', dirname( __FILE__ ) . '/www.john2enterprises.com.key');
define('SAML_NAME_ID',               'j2e-prototype' ); // Up to you; just "keep track" of what you use

define('OAUTH_SAML_URL', 'https://oauth.intuit.com/oauth/v1/get_access_token_by_saml');
define('FINANCIAL_FEED_HOST', 'financialdatafeed.platform.intuit.com');
define('FINANCIAL_FEED_URL', 'https://'.FINANCIAL_FEED_HOST.'/');

require_once(SIMPLESAML_PATH . "/lib/xmlseclibs.php");
require_once(SIMPLESAML_PATH . "/lib/SimpleSAML/Utilities.php");
require_once(SIMPLEOAUTH_PATH . "/OAuthSimple.php");

?>

