<?php
 class Like {
     private $db;

     public function __construct() {
         $this->db = new Database;
     }

     public function likesCount($postID) {
        $this->db->query("SELECT count(*) AS 'count' FROM likes WHERE post_id = :postID");

        $this->db->bind('postID', $postID);
        $count = $this->db->single();

        if ($this->db->execute()) {
            return $count->count;
        } else {
            return false;
        }
     }

     public function likes($postID) {
        $userID = $_SESSION['user_id'];

        if ($this->isLiked($postID)) {

            $this->db->query("DELETE FROM likes WHERE user_id = :userID AND post_id = :postID");

            $this->db->bind('userID', $userID);
            $this->db->bind('postID', $postID);

            $result = array(
                "likes" => -1
            );

            if ($this->db->execute()) {
                return json_encode($result);
            } else {
                return false;
            }

        } else {
         
            $this->db->query("INSERT INTO likes(user_id, post_id) VALUES(:userID, :postID)");
  
            $this->db->bind('userID', $userID);
            $this->db->bind('postID', $postID);

            $result = array(
                "likes" => 1
            );

            if ($this->db->execute()) {
                return json_encode($result);
            } else {
                return false;
            }
        }
     }

     public function isLiked($postID) {
         $this->db->query("SELECT * FROM likes WHERE user_id = :userID AND post_id = :postID");

         $userID = $_SESSION['user_id'];
         
         $this->db->bind('userID', $userID);
         $this->db->bind('postID', $postID);

         $this->db->single();

         if ($this->db->rowCount() > 0) {
             return true;
         } else {
             return false;
         }
     }
     
 }


