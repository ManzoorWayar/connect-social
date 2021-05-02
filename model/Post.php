<?php
 class Post {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Get user's data
    public function getPosts() {
        $sql = $this->db->query("SELECT posts.post_txt, posts.post_img AS 'postImg', posts.post_date,
                                    CONCAT(users.first_name, ' ', users.last_name) AS 'fullname',
                                    posts.posted_by AS 'postedBy',
                                    users.profile_img  AS 'profileImg', posts.id AS 'postID'
                                    FROM users INNER JOIN posts 
                                    ON users.id = posts.posted_by
                                    ORDER BY posts.post_date DESC");

        $userID = $_SESSION['user_id'];

        $this->db->bind('id', $userID);

        $results = $this->db->resultSet();

        return $results;
    }

    // Add post
    public function addPost($data) {
        $sql = $this->db->query("INSERT INTO posts(posted_by, post_txt, post_img, post_date) 
                                    VALUES(:userID, :postTxt, :postImg, :post_date)");
        
        $userID = $_SESSION['user_id'];
        
        $this->db->bind('userID'   , $userID);
        $this->db->bind('postTxt'  , $data['postTxt']);
        $this->db->bind('postImg'  , $data['postImg']);
        $this->db->bind('post_date', $data['post_date']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Single post of own user
    public function getSinglePost($userID) {
        $sql = $this->db->query("SELECT posts.post_txt, posts.post_img AS 'postImg', posts.post_date,
                                    CONCAT(users.first_name, ' ', users.last_name) AS 'fullname',
                                    posts.id AS 'postID', users.profile_img AS 'profileImg' FROM users 
                                    INNER JOIN posts ON users.id = posts.posted_by 
                                    WHERE users.id = :id 
                                    ORDER BY posts.post_date DESC");

        $this->db->bind('id', $userID);

        $results = $this->db->resultSet();;

        return $results;
    }
}