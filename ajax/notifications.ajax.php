<?php
    require_once '../bootstrap.php';
    $objnotifications = new notifications;

    if (isset($_POST['action']) && $_POST['action'] == 'updateNoti') {
        echo $objnotifications->seenNotification();
    }

    if (isset($_POST['action']) && $_POST['action'] == 'notifictionCount') {
        echo $objnotifications->notificationsCount();
    }