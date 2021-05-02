<?php
 class Notification {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }
    
    public function getNotifications() {
        $this->db->query("SELECT notifications.*, notifications.noti_date AS 'notiDate',
                            notifications.message AS 'msg', users.profile_img AS 'profileImg', 
                            CONCAT(users.first_name, ' ', users.last_name) AS 'fullname' 
                            FROM notifications INNER JOIN users 
                            ON notifications.noti_from = users.id
                            WHERE notifications.noti_from = users.id ORDER BY notifications.noti_date DESC");

        $this->db->bind('read', '0');
        $notifications = $this->db->resultSet();
       
        if ($this->db->execute()) {
            return $notifications;
        } else {
            return false;
        }
    }

    public function addNotification($notiTo, $notiMsg) {
        $this->db->query("INSERT INTO notifications(noti_from, noti_to, message) VALUES(:notiFrom, :notiTo, :notiMsg)");

        $notiFrom = $_SESSION['user_id'];
        $this->db->bind('notiFrom', $notiFrom);
        $this->db->bind('notiTo', $notiTo);
        $this->db->bind('notiMsg', $notiMsg);

        if ($this->db->execute()) {
            return $this->notificationsCount();
        } else {
            return false;
        }
    }

    public function notificationsCount() {
        $this->db->query("SELECT count(*) AS 'count' FROM notifications
                          WHERE noti_to = :notiTo AND is_read = :read");

        $notiTo = $_SESSION['user_id'];

        $this->db->bind('read', '0');
        $this->db->bind('notiTo', $notiTo);
        $count = $this->db->single();

        if ($this->db->execute()) {
            return json_encode($count->count);
        } else {
            return false;
        }
    }

    public function seenNotification() {
        $this->db->query("UPDATE notifications SET is_read = :read");

        $this->db->bind('read', '1');

        $seenNoti = array(
            "notification" => 0
        ); 

        if ($this->db->execute()) {
            return json_encode($seenNoti);
        } else {
            return false;
        }
    }

    public function notificationsRow() {
        $this->db->query("SELECT * FROM notifications");
        
         $rows = $this->db->resultSet();

        //Check Rows
        if($this->db->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }

 }