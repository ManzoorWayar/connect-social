<?php
    require_once '../model/Friend.php';
    require_once '../model/Notification.php';

 class Friends {
    public function __construct() {
        $this->friendModel = new Friend;
        $this->notificationModel = new Notification;
    }

    public function allFriends() {
        return $this->friendModel->getFriends();
    }

    public function followFriend($reciverId) {
        if ($this->friendModel->followFriend($reciverId) == true) {
            return $this->notificationModel->addNotification($reciverId, 'Started following you!');
        }
    }

    public function isFriend($reciverId) {
        $isFriend = $this->friendModel->isFriend($reciverId);

        if ($isFriend) {
            echo $text = "FOLLOWING";
        } else {
            echo $text = "FOLLOW";
        }
    }

 }