<?php
//###############################################################
//###############################################################
//##########                                           ##########
//##########        CLOUD PIGEON HOLE API V1.0         ########## 
//##########                                           ########## 
//###############################################################
//###############################################################

//sleep(2);

//###################################################
//############### CONFIGURATION FILES ###############
//###################################################
include_once('config/credentials.php');
include_once('config/environment.php');
include_once('config/known_bots.php');

//##############################################
//############### CORE FUNCTIONS ###############
//##############################################
include_once('functions/core/db.php');
include_once('functions/core/site_options.php');
include_once('functions/core/encryption.php');

//#######################################################
//############### CORE SECURITY FUNCTIONS ###############
//#######################################################
include_once('functions/core/check_request.php');
include_once('functions/core/bot_check.php');
include_once('functions/core/is_malicious.php');
include_once('functions/core/log_malicious.php');
include_once('functions/core/clear_malicious.php');
include_once('functions/core/platform_check.php');

//#################################################
//############### EMAILER FUNCTIONS ###############
//#################################################
include_once('functions/PHPMailer/src/Exception.php');
include_once('functions/PHPMailer/src/PHPMailer.php');
include_once('functions/PHPMailer/src/SMTP.php');

//###################################################
//############### DATABASE CONNECTION ###############
//###################################################
$db = new db();

//#####################################################
//############### GET AND CHECK REQUEST ###############
//#####################################################
$thisRequest = check_request();
$isThisASafeRequest = $thisRequest['is_this_a_safe_request'];
$page = $thisRequest['get1'];
$typea = $thisRequest['get2'];
$typeb = $thisRequest['get3'];
$typec = $thisRequest['get4'];
$typed = $thisRequest['get5'];
$typee = $thisRequest['get6'];
$typef = $thisRequest['get7'];
$typeg = $thisRequest['get8'];
$typeh = $thisRequest['get9'];
$typei = $thisRequest['get10'];
$typej = $thisRequest['get11'];
$typek = $thisRequest['get12'];
$typel = $thisRequest['get13'];
$typem = $thisRequest['get14'];
$typen = $thisRequest['get15'];

if ($isThisASafeRequest == 0) {
    log_malicious();
    die();
}

//#########################################################
//############### PRIMARY OBJECTS & OPTIONS ###############
//#########################################################
$siteOptions = new siteOptions();
$crypt = new EncryptData();

//#######################################
//############### HEADERS ###############
//#######################################
$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$referer = rtrim($referer, '/');
header('Access-Control-Allow-Origin: ' . $referer);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Expose-Headers: false");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
header("X-Frame-Options: SAMEORIGIN");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// header("Content-Security-Policy: default-src 'self' " . $global_site_url . "; script-src 'self' " . $global_site_url . " 'unsafe-inline' 'unsafe-eval' data: *.cookielaw.org *.sales-promotions.com *.pcapredict.com *.postcodeanywhere.co.uk *.google-analytics.com *.cloudflare.com *.bootstrapcdn.com *.jquery.com *.datatables.net *.newrelic.com *.ckeditor.com *.jsdelivr.net *.fontawesome.com; object-src 'none'; style-src 'self' " . $global_site_url . " 'unsafe-inline' *.typekit.net *.googleapis.com *.postcodeanywhere.co.uk *.bootstrapcdn.com *.jquery.com *.cloudflare.com *.jsdelivr.net *.fontawesome.com; img-src 'self' " . $global_site_url . " data: *.google-analytics.com *.fbsbx.com; media-src 'self'; frame-src 'self' " . $global_site_url . " *.sales-promotions.com; font-src 'self' data: " . $global_site_url . " *.gstatic.com *.typekit.net *.bootstrapcdn.com *.sales-promotions.com *.cloudflare.com *.jsdelivr.net *.fontawesome.com; connect-src 'self' " . $global_site_url . " *.cookielaw.org *.postcodeanywhere.co.uk *.google-analytics.com; frame-ancestors 'self' " . $global_site_url . ";");
//
// header("X-Content-Security-Policy: default-src 'self' " . $global_site_url . "; script-src 'self' " . $global_site_url . " 'unsafe-inline' 'unsafe-eval' data: *.cookielaw.org *.sales-promotions.com *.pcapredict.com *.postcodeanywhere.co.uk *.google-analytics.com *.cloudflare.com *.bootstrapcdn.com *.jquery.com *.datatables.net *.newrelic.com *.ckeditor.com *.jsdelivr.net; object-src 'none'; style-src 'self' " . $global_site_url . " 'unsafe-inline' *.typekit.net *.googleapis.com *.postcodeanywhere.co.uk *.bootstrapcdn.com *.jquery.com *.cloudflare.com *.jsdelivr.net *.fontawesome.com *.jsdelivr.net; img-src 'self' " . $global_site_url . " data: *.google-analytics.com *.fbsbx.com; media-src 'self'; frame-src 'self' " . $global_site_url . " *.sales-promotions.com; font-src 'self' data: " . $global_site_url . " *.gstatic.com *.typekit.net *.bootstrapcdn.com *.sales-promotions.com *.cloudflare.com *.jsdelivr.net *.fontawesome.com; connect-src 'self' " . $global_site_url . " *.cookielaw.org *.postcodeanywhere.co.uk *.google-analytics.com; frame-ancestors 'self' " . $global_site_url . ";");

//##############################################
//############### REQUEST ROUTER ###############
//##############################################
$result = array();
$result['status'] = 0;

///////////////////////
////// CRON JOBS //////
///////////////////////
if ($page == "cron-jGLynxaP5y") {
    include_once('cronjobs/cron_master.php');
}

//////////////////////////
////// API REQUESTS //////
//////////////////////////

// test
else if ($page == "test" && getenv('MYSQL_DATABASE') == "development") {
    include_once('handlers/test.php');
}

// ping
else if ($page == "ping") {
    include_once('handlers/ping.php');
}

// get email accounts
else if ($page == "get-email-accounts") {
  include_once('handlers/get_email_accounts.php');
}

// get email templates
else if ($page == "get-email-templates") {
  include_once('handlers/get_email_templates.php');
}

// re-ping
else if ($page == "re-ping") {
  include_once('handlers/re-ping.php');
}


echo json_encode($result);
