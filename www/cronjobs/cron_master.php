<?php
$last_cron_ping = $siteOptions->get('last_cron');




$timeoutIgnore = 1;

if ((($currentTime - 30) > $last_cron_ping) or $timeoutIgnore == 1) {

    //CORE
    include('cron_jobs/core/malicious_ips_cleanup.php');
    include('cron_jobs/core/malicious_useragents_cleanup.php');

    //EMAILER
    include('cron_jobs/run_email_queue.php');

    $db->sql("UPDATE api_data SET meta_value='$currentTime' WHERE meta_key='last_cron'");
}
