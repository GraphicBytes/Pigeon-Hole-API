<?php

function bot_check()
{

    //check known user agents
    global $db;
    global $userIP;
    global $knownBot;

    if ($knownBot == 1) {
        $bot = 1;
    } else {
        $bot = 0;
    }


    // check malicious_useragents
    $attemptsFromThisIP = 0;
    $res = $db->sql("SELECT * FROM malicious_useragents WHERE agent_ip=?", 's', $userIP);
    while ($row = $res->fetch_assoc()) {
        $attemptsFromThisIP = $attemptsFromThisIP + $row['attempts'];
    }
    if ($attemptsFromThisIP > 100) {
        $bot = 1;
    }

    return $bot;
}
