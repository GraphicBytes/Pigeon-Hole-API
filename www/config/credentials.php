<?php
//#########################################
//############### KEYS & SALTS ############
//#########################################
$networkPrimaryEncryptionKey = getenv('NETWORK_PRIMARY_ENCRYPTION_KEY');
$networkMinorEncryptionKey = getenv('NETWORK_MINOR_ENCRYPTION_KEY');
$emailerKey = getenv('EMAILER_KEY');
$superUserPassphrase = getenv('NETWORK_SUPER_USER_PASSPHRASE');

//##############################################
//############### DB CREDENTIALS ###############
//##############################################
$dbhost = getenv('MYSQL_HOST');
$dbuser = getenv('MYSQL_USER');
$dbpw = getenv('MYSQL_PASSWORD');
$dbname = getenv('MYSQL_DATABASE');