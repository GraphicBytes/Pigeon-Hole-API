<?php

use PHPMailer\PHPMailer\PHPMailer;

$pingCountDown = 12;
//$pingCountDown = 1;

while ($pingCountDown > 0) {

  $mysqlquery = "SELECT * FROM email_queue WHERE sending_email=0 AND email_sent=0 AND failed=0 ORDER BY id ASC LIMIT 1";
  $res = $db->sql($mysqlquery);
  while ($row = $res->fetch_assoc()) {

      $pingTime = time();
      $db->sql("UPDATE api_data SET meta_value='$pingTime' WHERE meta_key='last_queue_ping'");

      $id = $row['id'];

      $platform = $row['platform'];
      $account = $row['email_account'];
      $email = $crypt->decrypt($row['email'], $emailerKey);
      $subject = $crypt->decrypt($row['subject'], $emailerKey);
      $body = $crypt->decrypt($row['body'], $emailerKey);
      $altbody = $crypt->decrypt($row['altbody'], $emailerKey);
      $id_marker = $row['id_marker'];
      $priority = $row['priority'];

      $accountRes = $db->sql("SELECT * FROM email_accounts WHERE platform=? AND account=? ORDER BY id LIMIT 1", "ss", $platform, $account);
      while ($accountRow = $accountRes->fetch_assoc()) {
          $accountID = $accountRow['id'];
          $accountUsername = $crypt->decrypt($accountRow['username'], $emailerKey);
          $accountPassword = $crypt->decrypt($accountRow['password'], $emailerKey);
          $accountHost = $crypt->decrypt($accountRow['smtp_host'], $emailerKey);
          $accountPort = $accountRow['port'];
          $accountLastPing = $accountRow['last_send'];
      }

      $timeNow = time();
      if ($timeNow - $accountLastPing > 9) {

          // Debug: Print the query and parameters
          //echo "Executing update query with id: $id\n";

          $result = $db->sql("UPDATE email_queue SET sending_email=1 WHERE id=?", "i", $id);
          if ($result) {
              //echo "Update query executed successfully.\n";
          } else {
              //echo "Update query failed.\n";
          }

          $db->sql("INSERT INTO token_log SET token=?", 's', $email);

          $db->sql("UPDATE email_accounts SET last_send='$timeNow' WHERE id=?", "i", $accountID);

          $mail = new PHPMailer();
          $mail->IsSMTP();
          $mail->SMTPOptions = array(
              'ssl' => array(
                  'verify_peer' => false,
                  'verify_peer_name' => false,
                  'allow_self_signed' => true
              )
          );
          $mail->SMTPDebug = 0;
          $mail->SMTPAuth = true;
          $mail->SMTPSecure = 'ssl';
          $mail->Host = $accountHost;
          $mail->Port = $accountPort;
          $mail->IsHTML(true);
          $mail->Username = $accountUsername;
          $mail->Password = $accountPassword;
          $mail->SetFrom($accountUsername);
          $mail->Subject = $subject;
          $mail->Body = $body;
          $mail->AddAddress($email);
          $mail->Timeout = 4;

          if ($mail->send()) {
              $db->sql("UPDATE email_queue SET sending_email=2, email_sent=1 WHERE id=?", "i", $id);
          } else {
              $db->sql("UPDATE email_queue SET sending_email=2, failed=1 WHERE id=?", "i", $id);
          }
      } else {
          $db->sql("UPDATE email_queue SET sending_email=4 WHERE id=?", "i", $id);
      }

      $email = null;
      $accountHost = null;
      $accountPort = null;
      $accountUsername = null;
      $accountPassword = null;
      $subject = null;
      $body = null;
  }

  $pingCountDown = $pingCountDown - 1;
  sleep(5);
}