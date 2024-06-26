<?php

function clear_malicious()
{

    global $db;
    global $userIP;

    $db->sql("DELETE FROM malicious_ips WHERE ip_address=?", 's', $userIP);
    $db->sql("DELETE FROM malicious_useragents WHERE agent_ip=?", 's', $userIP);

    return true;
}
