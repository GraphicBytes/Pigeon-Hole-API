<?php
//###########################################
//############### ENVIRONMENT ###############
//###########################################
$currentTime = time();

$fullURL = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//##########################################
//############### USER AGENT ###############
//##########################################
$userAgent = "";
if (isset($_SERVER['HTTP_USER_AGENT'])) {
  $userAgent = $_SERVER['HTTP_USER_AGENT'];
}

//#######################################
//############### USER IP ###############
//#######################################
if (isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
  $userIP = $_SERVER['HTTP_CF_CONNECTING_IP'];
} else if (isset($_SERVER['HTTP_X_REAL_IP'])) {
  $userIP = $_SERVER['HTTP_X_REAL_IP'];
} else {
  $userIP = $_SERVER['REMOTE_ADDR'];
}
