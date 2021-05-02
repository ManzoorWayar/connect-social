<?php
    require_once '../model/Notification.php';
 
 class Notifications {
    public function __construct()  {
        $this->notiModel = new Notification;
    }

    public function getNotifications() {
        return $this->notiModel->getNotifications();
    }

    public function addNotification($noti_to, $notiMsg) {
        return $this->notiModel->addNotification($noti_to, $notiMsg);
    }

    public function notificationsCount() {
         return $this->notiModel->notificationsCount();
    }

    public function seenNotification() {
        return $this->notiModel->seenNotification();
    }

 }
