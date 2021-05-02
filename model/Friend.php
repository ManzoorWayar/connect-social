<?php
  class Friend {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getFriends() {
        $this->db->query("SELECT friends.reciver, friends.sender,
                        CONCAT(users.first_name ,' ', users.last_name) AS 'fullname',
                        users.profile_img AS 'profileImg' FROM friends 
                        INNER JOIN users 
                        ON friends.reciver = users.id 
                        WHERE is_friend = :true");

        $this->db->bind('true', 1);
        $friends = $this->db->resultSet();

        if ($this->db->execute())  {
            return $friends;
        } else {
            return false;
        }

    }

    public function followFriend($reciverID) {
        $senderID = $_SESSION['user_id'];

        if ($this->isFriend($reciverID)) {
            $this->db->query("DELETE FROM friends WHERE sender = :sender AND reciver = :reciver");

            $this->db->bind('sender', $senderID);
            $this->db->bind('reciver', $reciverID);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }

        } else {
            $this->db->query("INSERT INTO friends(sender, reciver, is_friend) VALUES(:sender, :reciver, :true)");

            $senderID = $_SESSION['user_id'];
            $this->db->bind('sender', $senderID);
            $this->db->bind('reciver', $reciverID);
            $this->db->bind(':true', 1);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }
       return true;
    }

    public function isFriend($reciverID) {
        $senderID = $_SESSION['user_id'];
        $this->db->query("SELECT * FROM friends WHERE sender = :sender AND reciver = :reciver");

        $this->db->bind('sender', $senderID);
        $this->db->bind('reciver', $reciverID);

        $this->db->single();
        
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
  }