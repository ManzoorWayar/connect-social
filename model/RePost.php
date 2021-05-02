<?php
 class RePost {
     private $db;

     public function __construct() {
         $this->db = new Database;
     }

     public function rePostsCount($postID) {
        $this->db->query("SELECT count(*) AS 'count' FROM reposts WHERE post_id = :postID");

        $this->db->bind('postID', $postID);
        $count = $this->db->single();

        if ($this->db->execute()) {
            return $count->count;
        } else {
            return false;
        }
     }

     public function rePosts($postID) {
        $userID = $_SESSION['user_id'];

        if ($this->isRePosted($postID)) {

            $this->db->query("DELETE FROM reposts WHERE user_id = :userID AND post_id = :postID");

            $this->db->bind('userID', $userID);
            $this->db->bind('postID', $postID);

            $result = array(
                "rePosts" => -1
            );

            if ($this->db->execute()) {
                return json_encode($result);
            } else {
                return false;
            }

        } else {
         
            $this->db->query("INSERT INTO reposts(user_id, post_id) VALUES(:userID, :postID)");
  
            $this->db->bind('userID', $userID);
            $this->db->bind('postID', $postID);

            $result = array(
                "rePosts" => 1
            );

            if ($this->db->execute()) {
                return json_encode($result);
            } else {
                return false;
            }
        }
     }

     public function isRePosted($postID) {
         $this->db->query("SELECT * FROM reposts WHERE user_id = :userID AND post_id = :postID");

         $userID = $_SESSION['user_id'];
         
         $this->db->bind('userID', $userID);
         $this->db->bind('postID', $postID);

         $row = $this->db->single();

         if ($this->db->rowCount() > 0) {
             return true;
         } else {
             return false;
         }
     }

     public function checkRePosts($postID) {
         $this->db->query("SELECT * FROM reposts 
         LEFT JOIN users ON reposts.user_id = users.id 
         RIGHT JOIN posts ON reposts.post_id = posts.id
          WHERE :userID = users.id AND :postID = posts.id");

        $userID = $_SESSION['user_id'];

        $this->db->bind('userID', $userID);
        $this->db->bind('postID', $postID);

        $results = $this->db->resultSet();

        return $results;
     }
 }


