<?php

$lastMaliciousIPsCleanup = $siteOptions->get('last_malicious_ips_cleanup');

if (($currentTime - $lastMaliciousIPsCleanup) > 30) {

    $res = $db->sql("SELECT id, attempts, last_attempt FROM malicious_ips ORDER BY id ASC");
    while ($row = $res->fetch_assoc()) {
        $id = $row['id'];
        $attempts = $row['attempts'];
        $lastAttempt = $row['last_attempt'];

        $timeout = $currentTime - 600;

        if ($lastAttempt < $timeout) {

            $updateCount = $attempts - 5;
            if ($updateCount < 0) {

                $db->sql("DELETE FROM malicious_ips WHERE id = ?", "i", $id);
            } else {

                $db->sql("UPDATE malicious_ips SET attempts = ?, last_attempt = ? WHERE id = ?", "iii", $updateCount, $currentTime, $id);
            }
        }
    }


    $db->sql("UPDATE api_data SET meta_value=? WHERE meta_key=?", 'is', $currentTime, 'last_malicious_ips_cleanup');
}
