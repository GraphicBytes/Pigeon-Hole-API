<?php

function log_malicious()
{

    global $db;
    global $userIP;
    global $currentTime;
    global $userAgent;

    //$knownBot = bot_check();

    $toMD5 = $userAgent . $userIP;
    $userAgentMD5 = md5($toMD5);

    $db->sql("INSERT INTO malicious_useragents SET agent_md5=?, user_agent=?, agent_ip=?, attempts=1, last_attempt=? ON DUPLICATE KEY UPDATE attempts=attempts+1, last_attempt=?", 'sssii', $userAgentMD5, $userAgent, $userIP, $currentTime, $currentTime);

    $db->sql("INSERT INTO malicious_ips SET ip_address=?, last_attempt=? ON DUPLICATE KEY UPDATE attempts=attempts+1, last_attempt=?", 'sii', $userIP, $currentTime, $currentTime);


    return true;
}
