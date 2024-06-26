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

        $res = $db->sql("SELECT * FROM email_templates WHERE platform=?", 's', $tokenPlatform);

        $templateList = [];
        $templateData = [];

        while ($row = $res->fetch_assoc()) {

          $entry = new stdClass();
          $entry->label = $row['label'];
          $entry->value = $row['template_name'];
          $templateList[] = $entry;

          $entryDetails = new stdClass();
          $entryDetails->label = $row['label'];
          $entryDetails->account = $row['account'];
          $entryDetails->subject = $row['subject'];
          $entryDetails->body_message = $row['body_message'];
          $entryDetails->alt_body = $row['alt_body'];          
          $templateData[$row['template_name']] = $entryDetails;
          
        }

        $result["status"] = 1;
        $result["platform"] = $tokenPlatform;
        $result["templateList"] = $templateList;
        $result["templateData"] = $templateData;

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
