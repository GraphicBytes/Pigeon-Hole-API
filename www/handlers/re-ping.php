<?php

$platformCheck = platform_check($typea);
$platformValid = $platformCheck['valid'];
$platform = $platformCheck['platform'];

$result["ip"] = $userIP;

$result["post_data"] = $_POST;

if (is_malicious() || $platformValid == 0) {
  log_malicious();
} else {

    if (isset($_POST['data'])) {

    $submittedToken = $_POST['data'];
    $tokenData = $crypt->decrypt($submittedToken, $networkPrimaryEncryptionKey);
    
    if ($tokenData !== false) {

      $tokenTimeLimit = $currentTime - 300;
      //$db->sql("INSERT INTO token_log SET token=?", 's', $tokenData);
      $tokenData = json_decode($tokenData);

      $marker = $tokenData->marker;

      $tokenUsed = 0;
      $markerRes = $db->sql("SELECT * FROM used_resend_markers WHERE id_marker=?", 's', $marker);
      while ($markerRow = $markerRes->fetch_assoc()) {
        $tokenUsed = 1;
        log_malicious();
      }

      if (
        $tokenUsed == 0
        && $platform == $tokenData->platform
        && $tokenData->token_age > $tokenTimeLimit
        && $tokenData->user_ip == $userIP
        && $tokenData->user_agent == $userAgent
      ) {

        $mailTemplateToUse = $tokenData->template;
        $mailSendTo = $tokenData->sendto;
        $mailPriority = $tokenData->priority;
        $mailTemplateValues = $tokenData->email_template_values;
        //$mailDisplayName = $tokenData->display_name;

        $tokenUsed = 0;
        $templateRes = $db->sql("SELECT * FROM email_templates WHERE template_name=? AND platform=? ORDER BY id LIMIT 1", 'ss', $mailTemplateToUse, $platform);
        while ($templateRow = $templateRes->fetch_assoc()) {

          $templateAccount = $templateRow['account'];
          $templateSubject = $templateRow['subject'];
          $templateBodyMessage = $templateRow['body_message'];
          $templateAltBody = $templateRow['alt_body'];

          foreach ($mailTemplateValues as $templateKey => $tempateValue) {

            $toReplace = "[[" . $templateKey . "]]";
            $replaceWith = $tempateValue;

            $replaceWithString = is_string($replaceWith) || is_array($replaceWith) ? $replaceWith : "";
            if (is_object($replaceWith)) {
              // Attempt to convert object to string using json_encode, or you might choose another method depending on the object structure
              $replaceWithString = json_encode($replaceWith);
            }

            $toReplaceString = is_string($toReplace) || is_array($toReplace) ? $toReplace : "";
            if (is_object($toReplace)) {
              // Attempt to convert object to string using json_encode, or you might choose another method depending on the object structure
              $toReplaceString = json_encode($toReplace);
            }

            $templateSubjectString = is_string($templateSubject) || is_array($templateSubject) ? $templateSubject : "";
            if (is_object($templateSubject)) {
              // Attempt to convert object to string using json_encode, or you might choose another method depending on the object structure
              $templateSubjectString = json_encode($templateSubject);
            }

            $templateBodyMessageString = is_string($templateBodyMessage) || is_array($templateBodyMessage) ? $templateBodyMessage : "";
            if (is_object($templateBodyMessage)) {
              // Attempt to convert object to string using json_encode, or you might choose another method depending on the object structure
              $templateBodyMessageString = json_encode($templateBodyMessage);
            }

            $templateAltBodyString = is_string($templateAltBody) || is_array($templateAltBody) ? $templateAltBody : "";
            if (is_object($templateAltBody)) {
              // Attempt to convert object to string using json_encode, or you might choose another method depending on the object structure
              $templateAltBodyString = json_encode($templateAltBody);
            }


            $templateSubject = str_replace($toReplaceString, $replaceWithString, $templateSubjectString);
            $templateBodyMessage = str_replace($toReplaceString, $replaceWithString, $templateBodyMessageString);
            $templateAltBody = str_replace($toReplaceString, $replaceWithString, $templateAltBodyString);
          }

          $smtpAccountRes = $db->sql("SELECT * FROM email_accounts WHERE platform=? AND account=? ORDER BY id LIMIT 1", 'ss', $platform, $templateAccount);
          while ($smtpAccountRow = $smtpAccountRes->fetch_assoc()) {

            $smtpUsername = $crypt->decrypt($smtpAccountRow['username'], $emailerKey);
            $smtpPassword = $crypt->decrypt($smtpAccountRow['password'], $emailerKey);
            $smtpHost = $crypt->decrypt($smtpAccountRow['smtp_host'], $emailerKey);
            $smtpPort = $smtpAccountRow['port'];

            $subject = $crypt->encrypt($templateSubject, $emailerKey);
            $themessage = $crypt->encrypt($templateBodyMessage, $emailerKey);
            $altbody = $crypt->encrypt($templateAltBody, $emailerKey);
            $sendTo = $crypt->encrypt($mailSendTo, $emailerKey);
            //$name = $crypt->encrypt($mailDisplayName, $emailerKey);
            $platform = $platform;
            $priority = $mailPriority;


            if (isset($tokenData->transit_token)) {
              $transitToken = $tokenData->transit_token;
              $result["transitToken"] = $crypt->encrypt(json_encode($transitToken), $networkPrimaryEncryptionKey);
            }

            if (isset($tokenData->newcsrf)) {
              $result["newcsrf"] = $tokenData->newcsrf;
            }

            $db->sql("INSERT INTO email_queue SET platform=?, email_account=?, email=?, subject=?, body=?, altbody=?, id_marker=?, priority=?", 'sssssssi', $platform, $templateAccount, $sendTo, $subject, $themessage, $altbody, $marker, $priority);
            $db->sql("INSERT INTO used_resend_markers SET id_marker=?", 's', $marker);

            clear_malicious();

            $result["status"] = 1;            
            
          }
        }
      }
    } else {
      log_malicious();
    }
  } else {
    log_malicious();
  }
}
