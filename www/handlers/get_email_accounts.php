<?php

$platformCheck = platform_check($typea);
$platformValid = $platformCheck['valid'];
$platform = $platformCheck['platform'];

if (is_malicious() || $platformValid == 0) {
  log_malicious();
} else {

  if (isset($_POST['admin_token'])) {

    $submittedToken = $_POST['admin_token'];
    $tokenData = $crypt->decrypt($submittedToken, $networkPrimaryEncryptionKey);

    if ($tokenData !== false) {

      $tokenTimeLimit = $currentTime - 300;
      $tokenData = json_decode($tokenData);

      $tokenPlatform = $tokenData->platform;
      $tokenSU = $tokenData->super_user;

      if ($tokenSU === 1) {

        $res = $db->sql("SELECT * FROM email_accounts WHERE platform=?", 's', $tokenPlatform);

        $accountList = [];
        $accountData = [];

        while ($row = $res->fetch_assoc()) {

          $entry = new stdClass();
          $entry->label = $row['label'];
          $entry->value = $row['account'];
          $accountList[] = $entry;

          $entryDetails = new stdClass();
          $entryDetails->label = $row['label'];
          $entryDetails->username = $crypt->decrypt($row['username'], $emailerKey);
          $entryDetails->password = $crypt->decrypt($row['password'], $emailerKey);
          $entryDetails->smtp_host = $crypt->decrypt($row['smtp_host'], $emailerKey);
          $entryDetails->port = $row['port'];          
          $accountData[$row['account']] = $entryDetails;
          
        }

        $result["status"] = 1;
        $result["platform"] = $tokenPlatform;
        $result["accountList"] = $accountList;
        $result["accountData"] = $accountData;

      } else {
        log_malicious();
      }
    } else {
      log_malicious();
    }
  } else {
    log_malicious();
  }
}
