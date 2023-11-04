<?php
$hostIp = 'reservationprojectv2-meilisearch-1';
$hostPort = 7700;
$timeoutTime = 1;

if ($fp = fsockopen($hostIp, $hostPort, $errCode, $errStr, $timeoutTime)) {
    echo 'Port is open';
} else {
    echo 'Port is closed';
}
fclose($fp);
