<?php
// Init
error_reporting(NULL);
ob_start();
session_start();
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

if ($_SESSION['user'] == 'admin') {
    if (!empty($_GET['srv'])) {
        if ($_GET['srv'] == 'iptables') {
            exec (HESTIA_CMD."v-update-firewall", $output, $return_var);
        } else {
            $v_service = escapeshellarg($_GET['srv']);
            exec (HESTIA_CMD."v-start-service ".$v_service, $output, $return_var);
        }
    }
    if ($return_var != 0) {
        $error = implode('<br>', $output);
        if (empty($error)) $error =  __('SERVICE_ACTION_FAILED',__('start'),$v_service);;
            $_SESSION['error_srv'] = $error;
    }
    unset($output);
}

header("Location: /list/server/");
exit;
