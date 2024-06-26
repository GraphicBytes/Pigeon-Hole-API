<?php

function is_malicious()
{

    global $db;
    global $userIP;

    $isUserABot = bot_check();

    $malicious = FALSE;

    // is this a recognised bot?
    if ($isUserABot == 1) {
        $malicious = TRUE;
    } else {
        // check recent nasty IPs
        $attemptsFromThisIP = 0;
        $res = $db->sql("SELECT * FROM malicious_ips WHERE ip_address=? ORDER BY id DESC LIMIT 1", 's', $userIP);
        while ($row = $res->fetch_assoc()) {
            $attemptsFromThisIP = $row['attempts'];
        }
        if ($attemptsFromThisIP > 25) {
            $malicious = TRUE;
        }
    }


    return $malicious;
}
