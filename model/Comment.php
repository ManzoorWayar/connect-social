<?php
 class Comment {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addComments($postID, $commentTxt) {
        $this->db->query("INSERT INTO comments(user_id, post_id, comment_txt, comment_date) VALUES(:userID, :postID, :commentTxt, :commentDate)");
        
        $userID = $_SESSION['user_id'];
        $ComDate = date('Y-m-d H:i:s');
        
        $this->db->bind('userID', $userID);
        $this->db->bind('postID', $postID);
        $this->db->bind('commentTxt', $commentTxt);
        $this->db->bind('commentDate', $ComDate);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getComments() {
        $this->db->query("SELECT comments.*, comments.comment_date AS 'commentDate',
         CONCAT(users.first_name, ' ', users.last_name) AS 'fullname', 
         users.username, users.profile_img AS 'profileImg', posts.id AS 'postID',
          posts.posted_by AS 'postedBy', posts.post_txt AS 'postedBy' FROM comments
           INNER JOIN users ON comments.user_id = users.id INNER JOIN posts 
           ON posts.id = comments.post_id WHERE posts.id = comments.post_id AND users.id = comments.user_id
            ORDER by comments.comment_date DESC");

        $rows = $this->db->resultSet();

        if ($this->db->execute()) {
            return $rows;
        } else {
            return false;
        }
    }

    public function isCommented($postID) {
        $this->db->query("SELECT * FROM comments WHERE user_id = :userID AND post_id = :postID");

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

  }